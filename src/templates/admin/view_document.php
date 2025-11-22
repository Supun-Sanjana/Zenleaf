<?php
// Simple document viewer for admin BR preview
include("../../backend/admin/admin_auth.php");

checkAdmin(); // Ensure admin is logged in

if (!isset($_GET['file']) || empty($_GET['file'])) {
    http_response_code(400);
    die('No file specified');
}

$filePath = $_GET['file'];

// Security: Prevent directory traversal
$filePath = str_replace(['../', '..\\', '../\\'], '', $filePath);

// The file path from database is: /uploads/business_files/filename
// We need to construct the correct path from the admin folder
$fullPath = '';

// Remove leading slash and construct path
$cleanPath = ltrim($filePath, '/');

// Check different possible locations for the file
$possiblePaths = [
    '../../../' . $cleanPath,  // From admin templates to project root
    '../../' . $cleanPath,     // From templates to src root
    '../../../src/' . $cleanPath, // If file is in src folder
    __DIR__ . '/../../../' . $cleanPath, // Absolute path
    '/workspace/uploads/updated/' . $cleanPath, // Full absolute path
];

foreach ($possiblePaths as $testPath) {
    if (file_exists($testPath)) {
        $fullPath = realpath($testPath);
        break;
    }
}

// If not found, try creating the file path by copying from the correct location
if (!$fullPath) {
    // Check if the file exists in the expected upload location
    $uploadPath = '/workspace/uploads/updated/uploads/business_files/' . basename($filePath);
    if (file_exists($uploadPath)) {
        $fullPath = $uploadPath;
    }
}

if (!$fullPath || !file_exists($fullPath)) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>File Not Found</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="text-center bg-white p-8 rounded-lg shadow-lg max-w-2xl">
            <div class="text-6xl mb-4">📄❌</div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Document Not Found</h1>
            <p class="text-gray-600 mb-4">The requested business registration document could not be found.</p>
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p class="text-sm text-gray-700 mb-2"><strong>Requested file:</strong></p>
                <code class="text-xs bg-gray-200 p-1 rounded"><?= htmlspecialchars($filePath) ?></code>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p class="text-xs text-gray-600 mb-2"><strong>Searched paths:</strong></p>
                <ul class="text-xs text-gray-500 text-left">
                    <?php foreach ($possiblePaths as $path): ?>
                        <li class="mb-1">• <code><?= htmlspecialchars($path) ?></code>
                            <?= file_exists($path) ? '<span class="text-green-600">✓ EXISTS</span>' : '<span class="text-red-600">✗ NOT FOUND</span>' ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <button onclick="window.parent.postMessage('close', '*')" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Close Preview
            </button>
        </div>
    </body>
    </html>
    <?php
    http_response_code(404);
    exit;
}

// Get file info
$fileInfo = pathinfo($fullPath);
$extension = strtolower($fileInfo['extension']);

// Handle download request
if (isset($_GET['download']) && $_GET['download'] == '1') {
    $mimeType = mime_content_type($fullPath);
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fullPath) . '"');
    header('Content-Length: ' . filesize($fullPath));
    readfile($fullPath);
    exit;
}

// Handle different file types for preview
switch ($extension) {
    case 'pdf':
        // For PDF files, set proper headers and output
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($fullPath) . '"');
        readfile($fullPath);
        break;

    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
    case 'webp':
        // For images, create a proper web path
        $webPath = '';

        // Convert file system path to web-accessible path
        if (strpos($fullPath, '/workspace/uploads/updated/') === 0) {
            // Remove the workspace prefix and create relative path
            $relativePath = str_replace('/workspace/uploads/updated/', '', $fullPath);
            $webPath = '../../../' . $relativePath;
        } else {
            // Fallback: serve image as base64
            $imageData = file_get_contents($fullPath);
            $mimeType = mime_content_type($fullPath);
            $base64 = base64_encode($imageData);
            $webPath = "data:$mimeType;base64,$base64";
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Business Registration Document</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                body {
                    margin: 0;
                    padding: 20px;
                    background: #f8fafc;
                    font-family: system-ui, -apple-system, sans-serif;
                }
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                }
                .image-container {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 70vh;
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
                    padding: 20px;
                }
                .document-image {
                    max-width: 100%;
                    max-height: 80vh;
                    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                    border-radius: 8px;
                    border: 1px solid #e2e8f0;
                }
                .header {
                    background: white;
                    padding: 20px;
                    border-radius: 12px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-file-image text-blue-600 mr-2"></i>
                        Business Registration Document
                    </h2>
                    <p class="text-gray-600"><?= htmlspecialchars(basename($fullPath)) ?></p>
                    <p class="text-sm text-gray-500">File size: <?= number_format(filesize($fullPath) / 1024, 1) ?> KB</p>
                </div>

                <div class="image-container">
                    <?php if (strpos($webPath, 'data:') === 0): ?>
                        <img src="<?= $webPath ?>"
                             alt="Business Registration Document"
                             class="document-image"
                             onload="console.log('Image loaded successfully')"
                             onerror="console.error('Failed to load image'); this.style.display='none'; document.getElementById('error-msg').style.display='block';">
                    <?php else: ?>
                        <img src="<?= htmlspecialchars($webPath) ?>"
                             alt="Business Registration Document"
                             class="document-image"
                             onload="console.log('Image loaded successfully')"
                             onerror="console.error('Failed to load image from: <?= htmlspecialchars($webPath) ?>'); this.style.display='none'; document.getElementById('error-msg').style.display='block';">
                    <?php endif; ?>

                    <div id="error-msg" style="display: none;" class="text-center text-gray-600">
                        <div class="text-6xl mb-4">🖼️❌</div>
                        <h3 class="text-xl font-semibold mb-2">Image Display Error</h3>
                        <p class="mb-4">Unable to display the image in the browser.</p>
                        <a href="?file=<?= urlencode($filePath) ?>&download=1"
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block">
                            <i class="fas fa-download mr-2"></i>Download Image
                        </a>
                        <div class="mt-4 text-xs text-gray-500">
                            <p>Debug info:</p>
                            <p>Full path: <?= htmlspecialchars($fullPath) ?></p>
                            <p>Web path: <?= htmlspecialchars($webPath) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Add some debug logging
                console.log('Document viewer loaded');
                console.log('File path: <?= htmlspecialchars($filePath) ?>');
                console.log('Full path: <?= htmlspecialchars($fullPath) ?>');
                console.log('Web path: <?= htmlspecialchars($webPath) ?>');
            </script>
        </body>
        </html>
        <?php
        break;

    default:
        // For other file types, show download option
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Document Preview</title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>
        <body class="bg-gray-100 flex items-center justify-center min-h-screen">
            <div class="text-center bg-white p-8 rounded-lg shadow-lg">
                <div class="text-6xl mb-4">📄</div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Business Registration Document</h1>
                <p class="text-gray-600 mb-4">File Type: <?= strtoupper($extension) ?></p>
                <p class="text-sm text-gray-500 mb-6">This file type cannot be previewed in the browser.</p>
                <a href="?file=<?= urlencode($filePath) ?>&download=1"
                   class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 inline-block">
                    <i class="fas fa-download mr-2"></i>Download Document
                </a>
            </div>
        </body>
        </html>
        <?php
        break;
}
?>