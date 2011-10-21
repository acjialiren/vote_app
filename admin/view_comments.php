<?php
require_once('../config.php');
require_once('../db/pdo.php');
require_once('../classes/security.php');
require_once('../classes/comment.php');

session_start();
if (($_GET['sesskey'] != $_SESSION['sesskey']) && ($_SESSION['admin'] != $USER->name)) {
    unset($_SESSION['sesskey']);
    unset($_SESSION['admin']);
    session_write_close();
    header("Location: index.php");
    exit(1);
}

if (isset($_GET['comment']) && isset($_GET['approved'])) {
    if ($_GET['sesskey'] == $_SESSION['sesskey']) {
        $comment = new comments($_GET['comment']);
        $comment->approve();
    }
}

$sess_key = gen_sesskey();
$_SESSION['sesskey'] = $sess_key;
session_write_close();

$db = new db();
$id = $_GET['id'];
?>
<html>
<head>
    <title>Admin - Control Panel -> View Comments</title>
</head>
<body>
    <a href="admin.php" style="float: left;">Back to Admin Page</a><br />
<?php
if (!empty($id)) {
    $sql = "SELECT id FROM comments WHERE poll=?";

    if ($db->execute_query($sql, array($id))) {
        $comment_ids = $db->fetch_results();

        if (!empty($comment_ids)) {
            echo "\t<table border=\"1\">\n";
            echo "\t\t<tr>\n";
            echo "\t\t\t<th>Email</th>\n";
            echo "\t\t\t<th>Name</th>\n";
            echo "\t\t\t<th>Comment</th>\n";
            echo "\t\t\t<th>IP</th>\n";
            echo "\t\t\t<th>Time Created</th>\n";
            echo "\t\t\t<th>Approve</th>\n";
            echo "\t\t</tr>\n";
            foreach ($comment_ids as $comment_id) {
                $comment = new comments($comment_id->id);
                if ($comment->get()) {
                    echo "\t\t<tr>\n";
                    echo "\t\t\t<td style=\"width: 200px;\">\n";
                    echo "\t\t\t\t".$comment->email."\n";
                    echo "\t\t\t</td>\n";
                    echo "\t\t\t<td style=\"width: 150px;\">\n";
                    echo "\t\t\t\t".$comment->name."\n";
                    echo "\t\t\t</td>\n";
                    echo "\t\t\t<td style=\"width: 400px;\">\n";
                    echo "\t\t\t\t".$comment->comment."\n";
                    echo "\t\t\t</td>\n";
                    echo "\t\t\t<td style=\"width: 150px;\">\n";
                    echo "\t\t\t\t".$comment->ip."\n";
                    echo "\t\t\t</td>\n";
                    echo "\t\t\t<td>\n";
                    echo "\t\t\t\t".$comment->timecreated."\n";
                    echo "\t\t\t</td>\n";
                    
                    if ($comment->approved == 0) {
                        $url = "?id=".$id."&amp;sesskey=".$sess_key."&amp;comment=".$comment_id->id."&amp;approved=1";
                        echo "\t\t\t<td>\n";
                        echo "\t\t\t\t<a href=\"".$url."\">Approve</a>\n";
                        echo "\t\t\t</td>\n";
                    }
                    echo "\t\t</tr>\n";
                }
            }
            echo "\t</table>\n";
        }
    }
}
?>
    <a href="admin.php" style="float: left;">Back to Admin Page</a>
</body>
</html>
