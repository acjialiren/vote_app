<?php
require_once('../config.php');
session_start();
if (($_GET['sesskey'] == $_SESSION['sesskey']) && ($_SESSION['admin'] == $USER->name)) {
    unset($_SESSION['sesskey']);
    unset($_SESSION['admin']);
    session_write_close();
    header("Location: index.php");
    exit(1);
}
?>
