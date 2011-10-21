<?php
//MYSQL Databse Details
$DB = new stdClass();
$DB->host = ''; //Database Host
$DB->name = ''; //Database Name
$DB->user = ''; //Database Username
$DB->pass = ''; //Database Password

//Admin User Details
$USER = new stdClass();
$USER->name = ''; //Username for admin

/*
* Create admin password.
* Run gen_password.php in the command line, php gen_password {PASSWORD}.
* Replace {PASSWORD} with your password you want to login with.
* Copy the Salt into $USER->salt and the Hashed Password snd Salt into $USER->password.
*/
$USER->password = ''; 
$USER->salt = '';
//Copy or rename this file to config.php once the file is setup.
?>
