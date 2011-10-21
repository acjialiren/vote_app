<?php
require_once('../classes/security.php');
session_start();
$sesskey = gen_sesskey();
$_SESSION['sesskey'] = $sesskey;
session_write_close();

header('Content-type: application/json');
echo json_encode(array('sesskey' => $sesskey));
exit;
?>
