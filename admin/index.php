<?php
require_once('../classes/security.php');
$sess_key = gen_sesskey();
session_start();
$_SESSION['sesskey'] = $sess_key;
session_write_close();
?>
<html>
<head>
    <title>Admin - Login</title>
</head>
<body>
    <form method="post" action="login.php">
        <table>
            <tr>
                <td>Username: </td>
                <td><input type="text" name="admin_uname" /></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="admin_pword" /></td>
            </tr>
            <tr>
                <td><input type="hidden" value="<?php echo $sess_key; ?>" name="sesskey" /></td>
                <td><input type="submit" value="Login" /></td>
            </tr>
        </table>
    </form>
</body>
</html>
