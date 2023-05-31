<?php
session_start();
unset($_SESSION["name"]);

echo "<script>alert('登出成功!'); location.href = 'user-list.php';</script>";

?>






