<?php
include("../../lib/database.php");
include("../../backend/admin/admin_auth.php");

checkAdmin(); // Ensure admin is logged in

// Toggle Approve/Disapprove
if (isset($_POST['toggle_approve']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $res = mysqli_query($con, "SELECT approve FROM users WHERE user_id='$user_id' AND type='supplier'");
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $newStatus = $row['approve'] ? 0 : 1;
        mysqli_query($con, "UPDATE users SET approve='$newStatus' WHERE user_id='$user_id'");
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch suppliers + business reg - FIXED QUERY
function fetchSuppliers($con)
{
    $suppliers = [];

    // Fixed query - using CAST to ensure proper matching
    $sql = "SELECT u.user_id, u.first_name, u.user_name, u.email, u.approve,
                   b.id as br_id, b.b_certificate, b.b_name
            FROM users u
            LEFT JOIN business_reg b ON CAST(u.user_id AS CHAR) = CAST(b.user_id AS CHAR)
            WHERE u.type='supplier'
            ORDER BY u.user_id DESC";

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $suppliers[] = $row;
        }
    }

    return $suppliers;
}

$suppliers = fetchSuppliers($con);
?>
<?php include './header.php'; ?>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    crossorigin="anonymous" />

<div class="bg-gray-800 min-h-screen p-6">
    <div class="bg-gray-900 p-8 shadow-xl rounded-xl">
        <h2 class="text-3xl font-bold text-emerald-400 mb-6">Supplier Management 🚚</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="py-3.5 px-4 text-left text-sm font-semibold text-gray-300">First Name</th>
                        <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-300">User Name</th>
                        <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-300">Email</th>
                        <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-300">Approve</th>
                        <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-300">Business Registration</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 bg-gray-800">
                    <?php if (!empty($suppliers)): ?>
                        <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium text-gray-200">
                                    <?= htmlspecialchars($supplier['first_name']) ?>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-400">
                                    <?= htmlspecialchars($supplier['user_name']) ?>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-400">
                                    <?= htmlspecialchars($supplier['email']) ?>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-400">
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?= $supplier['user_id'] ?>">
                                        <?php if ($supplier['approve']): ?>
                                            <button type="submit" name="toggle_approve"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                                Disapprove
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" name="toggle_approve"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                                                Approve
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-400">
                                    <?php if (!empty($supplier['b_certificate']) && !is_null($supplier['br_id'])): ?>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="openBRModal('<?= htmlspecialchars($supplier['b_certificate']) ?>', '<?= htmlspecialchars($supplier['user_name']) ?>')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                                <i class="fas fa-eye mr-1"></i>Preview BR
                                            </button>
                                            <span class="text-green-400 text-xs">
                                                <i class="fas fa-check-circle mr-1"></i>Uploaded
                                            </span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Not uploaded
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-400">No suppliers found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Enhanced Modal -->
<div id="brModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-4xl h-5/6 flex flex-col relative">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b bg-gray-50 rounded-t-lg">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                Business Registration - <span id="supplierName"></span>
            </h3>
            <div class="flex space-x-2">
                <button onclick="downloadBR()" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-download mr-1"></i>Download
                </button>
                <button onclick="closeBRModal()" class="text-gray-600 hover:text-gray-900 text-xl font-bold px-2">
                    &times;
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="flex-1 p-4">
            <div id="loadingSpinner" class="flex items-center justify-center h-full hidden">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <span class="ml-3 text-gray-600">Loading document...</span>
            </div>
            <iframe id="brFrame"
                    class="w-full h-full rounded border-2 border-gray-200"
                    onload="hideLoading()"
                    onerror="showError()">
            </iframe>
            <div id="errorMessage" class="hidden flex items-center justify-center h-full text-center">
                <div class="text-gray-500">
                    <i class="fas fa-exclamation-triangle text-4xl mb-4 text-yellow-500"></i>
                    <p class="text-lg mb-2">Unable to preview document</p>
                    <p class="text-sm">The file might be corrupted or in an unsupported format.</p>
                    <button onclick="downloadBR()" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        <i class="fas fa-download mr-1"></i>Download File
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentFilePath = '';

    function openBRModal(filePath, supplierName) {
        // Show loading spinner
        document.getElementById('loadingSpinner').classList.remove('hidden');
        document.getElementById('errorMessage').classList.add('hidden');

        // Set supplier name
        document.getElementById('supplierName').textContent = supplierName;

        // Store file path for download
        currentFilePath = filePath;

        // Use the document viewer endpoint
        const viewerUrl = './view_document.php?file=' + encodeURIComponent(filePath);

        console.log('Loading document via:', viewerUrl); // Debug log

        // Set iframe source
        document.getElementById('brFrame').src = viewerUrl;

        // Show modal
        document.getElementById('brModal').classList.remove('hidden');
    }

    function closeBRModal() {
        document.getElementById('brFrame').src = '';
        document.getElementById('brModal').classList.add('hidden');
        currentFilePath = '';
    }

    function hideLoading() {
        document.getElementById('loadingSpinner').classList.add('hidden');
    }

    function showError() {
        document.getElementById('loadingSpinner').classList.add('hidden');
        document.getElementById('errorMessage').classList.remove('hidden');
    }

    function downloadBR() {
        if (currentFilePath) {
            // Use the document viewer with download parameter
            const downloadUrl = './view_document.php?file=' + encodeURIComponent(currentFilePath) + '&download=1';
            window.open(downloadUrl, '_blank');
        }
    }

    // Close modal when clicking outside
    document.getElementById('brModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBRModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('brModal').classList.contains('hidden')) {
            closeBRModal();
        }
    });
</script>

<style>
    /* Custom scrollbar for iframe */
    #brFrame {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }

    #brFrame::-webkit-scrollbar {
        width: 8px;
    }

    #brFrame::-webkit-scrollbar-track {
        background: #f7fafc;
    }

    #brFrame::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 4px;
    }
</style>