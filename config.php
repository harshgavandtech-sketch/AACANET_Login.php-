<?php

$conn = mysqli_connect("localhost", "root", "MyNewRootPass@123", "login_knt");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM users");

while ($row = mysqli_fetch_assoc($result)) {
    echo "Username: " . $row['username'] . "<br>";
}
?>