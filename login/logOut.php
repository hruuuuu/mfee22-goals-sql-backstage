<?php
session_start();
unset($_SESSION["name"]);
echo "<script>alert('您已登出!'); location.href = 'login.php';</script>";








