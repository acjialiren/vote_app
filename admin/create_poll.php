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
        $poll = new polls();
        $poll->save($_GET['poll_question'], $_GET['poll_answers']);
    }
}


$sess_key = gen_sesskey();
$_SESSION['sesskey'] = $sess_key;
session_write_close();

?>
<html>
<head>
    <title>Admin - Control Panel -> Create Poll</title>
</head>
<body>
    <a href="admin.php" style="float: left;">Back to Admin Page</a><br />
    <h3>Create Poll</h3>
    <p>
        Seperate each answer with a pipe('|'). Each answers will related to a number.<br />
        For example: yes|no, yes would be 1 and no would 2.<br />
        Maxium of 5 answers per poll.
    </p>
    <form method="get">
        <table>
            <tr>
                <td>Question / Poll Name</td>
                <td><input type="text" name="poll_question" /></td>
            </tr>
            <tr>
                <td>Answers</td>
                <td><textarea rows="5" cols="40" name="poll_answers"></textarea></td>
            </tr>
            <tr>
                <td><input type="hidden" value="<?php echo $sess_key; ?>" name="sesskey" /></td>
                <td><input type="submit" value="Save" /></td>
            </tr>
        </table>
    </form>
    <a href="admin.php" style="float: left;">Back to Admin Page</a>
</body>
</html>
