<?php
require_once('../config.php');
session_start();

if ($_POST['sesskey'] == $_SESSION['sesskey']) {
    $username = $_POST['admin_uname'];
    $password = $_POST['admin_pword'];

    if ($username == $USER->name) {
        if (md5($password.$USER->salt) == $USER->password) {
            $_SESSION['admin'] = $USER->name;
            session_write_close();
            header("Location: admin.php");
            exit(1);
        }
        session_write_close();
        header("Location: index.php");
        exit(1);
    }
    session_write_close();
    header("Location: index.php");
    exit(1);
}
session_write_close();
header("Location: index.php");
exit(1);
?>
