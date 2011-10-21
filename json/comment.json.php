<?php
require_once('../config.php');
require_once('../db/pdo.php');
require_once('../classes/comment.php');
session_start();

$fake_email = array('example.com', 'localhost.com', 'fake.com', 'example.net', 'localhost.net', 'fake.net');
$response = array('sucessful' => false);
if (isset($_GET['sesskey']) && ($_GET['sesskey'] == $_SESSION['sesskey'])) {
    $poll = isset($_GET['poll']) : $_GET['poll'] ? null;
    $email = isset($_GET['email']) : $_GET['email'] ? null;
    $name = isset($_GET['name']) : $_GET['name'] ? null;
    $comment = isset($_GET['comment']) : $_GET['comment'] ? null;

    if (!empty($poll) && !empty($email) && !empty($name) && !empty($comment)) {
        $db = new db();
        $db->execute_query("SELECT id FROM polls WHERE id=?", array($poll));
        $results = $db->fetch_results();
        $result = $results[0];

        if (!empty($result)) {
            if (preg_match('#([A-Z a-z 0-9]+)@([A-Z a-z 0-9]+)\.([A-Z a-z]+)#', $email, $matches)) {
                if (!in_array($matches[2].'.'.$matches[3], $fake_email)) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $comment = new comments();

                    if ($comment->save($result->id, $email, $name, $comment, $ip)) {
                        $response['sucessful'] = true;
                    }
                }
            }
        }
    }

}
session_write_close();
header('Content-type: application/json');
echo json_encode($response);
exit;
?>
