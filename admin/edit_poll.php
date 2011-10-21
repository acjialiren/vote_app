<?php
require_once('../config.php');
require_once('../db/pdo.php');
require_once('../classes/security.php');
require_once('../classes/poll.php');

session_start();
if (($_GET['sesskey'] != $_SESSION['sesskey']) && ($_SESSION['admin'] != $USER->name)) {
    unset($_SESSION['sesskey']);
    unset($_SESSION['admin']);
    session_write_close();
    header("Location: index.php");
    exit(1);
}

if (isset($_GET['poll_question']) && isset($_GET['poll_answers'])) {
    if ($_GET['sesskey'] == $_SESSION['sesskey']) {
        $poll = new polls($_GET['id']);
        $poll->save($_GET['poll_question'], $_GET['poll_answers']);
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
    <title>Admin - Control Panel -> Edit Poll</title>
</head>
<body>
    <a href="admin.php" style="float: left;">Back to Admin Page</a><br />
<?php
if (!empty($id)) {
    $poll = new polls($id);
    $poll->get();

    echo "\t<h3>Edit Poll - ".$poll->question."</h3>\n";
}
?>
    <form method="get">
        <table>
            <tr>
                <td>Question / Poll Name</td>
                <td><input type="text" name="poll_question" value="<?php echo $poll->question; ?>"/></td>
            </tr>
            <tr>
                <td>Answers (seperate answers with '|')</td>
                <td><textarea rows="5" cols="40" name="poll_answers"><?php echo implode('|', $poll->answers);?></textarea></td>
            </tr>
            <tr>
                <td><input type="hidden" name="sesskey" value="<?php echo $sess_key; ?>" /><input type="hidden" value="<?php echo $id;?>" name="id" /></td>
                <td><input type="submit" value="Save" /></td>
            </tr>
        </table>
    </form>
    <a href="admin.php" style="float: left;">Back to Admin Page</a>
</body>
</html>
