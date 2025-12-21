<!-- connection -->
<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "qodex_v1";
$conn = "";

$conn = mysqli_connect(
    $db_server,
    $db_user,
    $db_pass,
    $db_name
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>


<?php

session_unset();
session_destroy();
header('Location: auth/login.php');
exit;
?>