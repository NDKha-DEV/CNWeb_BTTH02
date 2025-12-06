<?php
require_once "database.php";

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "Kết nối thành công!";
} else {
    echo "Kết nối thất bại!";
}
?>
