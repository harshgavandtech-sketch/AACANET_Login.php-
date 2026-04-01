<?php
$conn = mysqli_connect("localhost", "root", "MyNewRootPass@123", "login_knt");

if ($conn) {
    echo "Database Connected ✅";
} else {
    echo "Connection Failed ❌";
}
?>