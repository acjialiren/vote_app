<?php
require_once('../config.php');
require_once('../db/pdo.php');
require_once('../classes/security.php');

session_start();
if ($_SESSION['admin'] != $USER->name) {
    unset($_SESSION['sesskey']);
    unset($_SESSION['admin']);
    session_write_close();
    header("Location: index.php");
    exit(1);
}
$sess_key = gen_sesskey();
$_SESSION['sesskey'] = $sess_key;
session_write_close();

$db = new db();
?>
<html>
<head>
    <title>Admin - Control Panel</title>
</head>
<body>
<a href="logout.php?sesskey=<?php echo $sess_key;?>" style="float: right;">Logout</a>
<form method="get" action="create_poll.php">
    <input type="hidden" value="<?php echo $sess_key;?>" name="sesskey" />
    <input type="submit" value="Create Poll" />
</form>

<?php
$sql = "SELECT id, question FROM polls";

if ($db->execute_query($sql, array())) {
    $results = $db->fetch_results();

    if (!empty($results)) {
        echo "\t<table border=\"1\">\n";
        foreach ($results as $result) {
            echo "\t\t<tr>\n";
            echo "\t\t\t<td style=\"width: 300px;\">\n";
            echo "\t\t\t\t".$result->question."\n";
            echo "\t\t\t</td>\n";
            echo "\t\t\t<td>\n";
            echo "\t\t\t\t<a href=\"view_comments.php?id=".$result->id."&amp;sesskey=".$sess_key."\">View Comments</a>\n";
            echo "\t\t\t</td>\n";
            echo "\t\t\t<td>\n";
            echo "\t\t\t\t<a href=\"view_results.php?id=".$result->id."&amp;sesskey=".$sess_key."\">View Results</a>\n";
            echo "\t\t\t</td>\n";
            echo "\t\t\t<td>\n";
            echo "\t\t\t\t<a href=\"edit_poll.php?id=".$result->id."&amp;sesskey=".$sess_key."\">Edit Poll</a>\n";
            echo "\t\t\t</td>\n";
            echo "\t\t</tr>\n";
        }
        echo "\t</table>\n";
    }
}
?>
<a href="logout.php?sesskey=<?php echo $sess_key; ?>" style="float: right;">Logout</a>
</body>
</html>
