<?php
require_once('../config.php');
require_once('../db/pdo.php');
require_once('../classes/vote.php');
session_start();
$response = array('sucessful' => false);

if (isset($_GET['sesskey']) && ($_GET['sesskey'] == $_SESSION['sesskey'])) {
    if (isset($_GET['poll']) && isset($_GET['vote'])) {
        $db = new db();
        $db->execute_query("SELECT id FROM polls WHERE id=?", array($_GET['poll']));
        $results = $db->fetch_results();
        $result = $results[0];
        
        if (!empty($result)) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $vote = new votes();
            if ($vote->save($result->id, $_GET['vote'], $ip)) {
                $response['sucessful'] = true;
            }
        }
    }
}
session_write_close();
header('Content-type: application/json');
echo json_encode($response);
exit;
?>
