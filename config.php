<<<<<<< HEAD
<?php

$conn = mysqli_connect("localhost", "root", "MyNewRootPass@123", "login_knt");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM users");

while ($row = mysqli_fetch_assoc($result)) {
    echo "Username: " . $row['username'] . "<br>";
}
=======
<?php

$conn = mysqli_connect("localhost", "root", "MyNewRootPass@123", "login_knt");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM users");

while ($row = mysqli_fetch_assoc($result)) {
    echo "Username: " . $row['username'] . "<br>";
}
>>>>>>> 410b6a40405f9ddc6214cbd100a89139c07040f5
?>