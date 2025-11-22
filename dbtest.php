<?php
// Force full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simple test script
echo "🚀 Starting DB test...<br>";

// DB credentials
$DBServer = "sql103.alwaysfreehost.xyz";
$DBUser   = "xeyra_40030434";
$DBPass   = "rJY0o8DOrSV3oN7";
$DBName   = "xeyra_40030434_zenleaf";

// Try connection
$con = mysqli_connect($DBServer, $DBUser, $DBPass, $DBName);

// Check connection
if (!$con) {
    die("❌ Connection failed: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
} else {
    echo "✅ Connected successfully to database!<br>";
}

// Try a query
$sql = "SHOW TABLES";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("❌ Query failed: " . mysqli_error($con));
} else {
    echo "✅ Query succeeded!<br>";
    while ($row = mysqli_fetch_array($result)) {
        echo "- " . htmlspecialchars($row[0]) . "<br>";
    }
}

echo "🎉 Done.";
?>
