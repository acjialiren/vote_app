<?php
if ($argc >= 1) {
    if (!empty($argv[1])) {
        $password = $argv[1];
        $salt = shell_exec('pwgen 16 -1');
        echo "Salt: ".$salt;
        echo "Password: ".$password."\n";
        echo "Hash of Password and Salt: ".md5($password.$salt)."\n";
    } else {
        echo "Useage: \"php gen_password PASSWORD\"\n";
    }

} else {
    echo "Useage: \"php gen_password PASSWORD\"\n";
}
?>
