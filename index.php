<?php
session_start();
$_SESSION["SYS_PATH"] = __DIR__;
header("Location: common/index.php");
?>