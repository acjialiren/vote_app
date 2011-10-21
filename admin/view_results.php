<?php
require_once('../config.php');
require_once('../db/pdo.php');
require_once('../classes/security.php');
require_once('../classes/vote.php');

session_start();
if (($_GET['sesskey'] != $_SESSION['sesskey']) && ($_SESSION['admin'] != $USER->name)) {
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
$id = $_GET['id'];
?>
<html>
<head>
    <title>Admin - Control Panel -> View Results</title>
</head>
<body>
    <a href="admin.php" style="float: left;">Back to Admin Page</a><br />
<?php
if (!empty($id)) {
    $sql = "SELECT question, answers FROM polls WHERE id=?";
    $db->execute_query($sql, array($id));
    $results = $db->fetch_results();
    $question = $results[0]->question;
    $answers = explode('|', $results[0]->answers);
    $count = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);

    $sql = "SELECT id FROM votes WHERE poll=?";

    if ($db->execute_query($sql, array($id))) {
        $vote_ids = $db->fetch_results();

        if (!empty($vote_ids)) {
            foreach ($vote_ids as $vote_id) {
                $vote = new votes($vote_id->id);
                if ($vote->get()) {
                    switch ($vote->vote) {
                        case 1:
                            $count[1]++;
                            break;

                        case 2:
                            $count[2]++;
                            break;

                        case 3:
                            $count[3]++;
                            break;

                        case 4:
                            $count[4]++;
                            break;

                        case 5:
                            $count[5]++;
                            break;
                    }
                }
            }
        }
    }
    echo "\t<h3>".$question." - Results</h3>\n";
    echo "\t<table border=\"1\">\n";
    echo "\t\t<tr>\n";
    echo "\t\t\t<th>Answer</th>\n";
    echo "\t\t\t<th>No. of times Selected</th>\n";
    echo "\t\t</tr>\n";

    foreach ($answers as $key => $value) {
        echo "\t\t<tr>\n";
        echo "\t\t\t<td style=\"width: 200px;\">\n";
        echo "\t\t\t\t".$value."\n";
        echo "\t\t\t</td>\n";
        echo "\t\t\t<td>\n";
        switch ($key) {
            case 0:
                echo "\t\t\t\t".$count[1]."\n";
                break;

            case 1:
                echo "\t\t\t\t".$count[2]."\n";
                break;

            case 2:
                echo "\t\t\t\t".$count[3]."\n";
                break;

            case 3:
                echo "\t\t\t\t".$count[4]."\n";
                break;

            case 4:
                echo "\t\t\t\t".$count[5]."\n";
                break;
        }
        echo "\t\t\t</td>\n";
        echo "\t\t</tr>\n";
    }
    echo "\t</table>\n";
}
?>
    <a href="admin.php" style="float: left;">Back to Admin Page</a>
</body>
</html>

