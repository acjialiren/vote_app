<?php
require_once('../config.php');
require_once('../db/pdo.php');

class polls {
    private $id = null;
    public $question = null;
    public $answers = null;
    public $timecreated = null;
    public $timemodified = null;
    private $db = null;

    function __construct($id=null) {
        if (!empty($id)) {
            $this->id = $id;
        }
        $this->db = new db();
    }

    function get() {
        if (!empty($this->id)) {
            $sql = "SELECT question, answers, timecreated, timemodified FROM polls WHERE id=?";

            if ($this->db->execute_query($sql, array($this->id))) {
                $results = $this->db->fetch_results();

                if (!empty($results)) {
                    $result = $results[0];
                    $this->question = $result->question;
                    $this->answers = $this->process_answers($result->answers);
                    $this->timecreated = $result->timecreated;
                    $this->timemodified = $result->timemodified;
                    return true;
                }
            }
        }
        return false;
    }

    function save($question, $answers) {
        if (empty($this->id)) {
            $time = time();
            $sql = "INSERT INTO polls(question, answers, timecreated) VALUES (?, ?, ?)";

            if ($this->db->execute_query($sql, array($question, $answers, $time))) {
                $this->question = $question;
                $this->answers = $this->process_answers($answers);
                $this->timecreated = $time;
                return true;
            }
            return false;
        } else {
            $time = time();
            $sql = "UPDATE polls SET question=?, answers=?, timemodified=? WHERE id=?";

            if ($this->db->execute_query($sql, array($question, $answers, $time, $this->id))) {
                $this->question = $question;
                $this->answers = $this->process_answers($answers);
                $this->timemodified = $time;
                return true;
            }
            return false;
        }
    }

    private function process_answers($answers) {
        return explode('|', $answers);
    }
}
?>
