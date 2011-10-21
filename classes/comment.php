<?php
require_once('../config.php');
require_once('../db/pdo.php');

class comments {
    private $id = null;
    public $poll = null;
    public $email = null;
    public $name = null;
    public $comment = null;
    public $ip = null;
    public $approved = null;
    public $timecreated = null;
    private $db = null;

    function __construct($id=null) {
        if (!empty($id)) {
            $this->id = $id;
        }
        $this->db = new db();
    }

    function get() {
        if (!empty($this->id)) {
            $sql = "SELECT poll, email, name, comment, ip, approved, timecreated FROM comments WHERE id=?";
            if ($this->db->execute_query($sql, array($this->id))) {
                $results = $this->db->fetch_results();

                if (!empty($results)) {
                    $result = $results[0];
                    $this->poll = $result->poll;
                    $this->email = $result->email;
                    $this->name = $result->name;
                    $this->comment = $result->comment;
                    $this->ip = $result->ip;
                    $this->approved = $result->approved;
                    $this->timecreated = $result->timecreated;
                    return true;
                }
                return false;
            }
        }
        return false;
    }

    function save($poll, $email, $name, $comment, $ip) {
        if (empty($this->id)) {
            $time = time();
            $sql = "INSERT INTO comments(poll, email, name, comment, ip, approved, timecreated) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params = array($poll, $email, $name, $comment, $ip, 0, $time);

            if ($this->db->execute_query($sql, $params)) {
                $this->id = $this->db->last_id();
                $this->poll = $poll;
                $this->email = $email;
                $this->name = $name;
                $this->comment = $comment;
                $this->ip = $ip;
                $this->approved = 0;
                $this->timecreated = $time;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE comment SET comment=? WHERE id=?";

            if ($this->db>execute_query($sql, array($comment, $this->id))) {
                $this->comment = $comment;
                return true;
            }
            return false;
        }
    }

    function approve() {
        if (!empty($this->id)) {
            $sql = "UPDATE comments SET approved=? WHERE id=?";

            if ($this->db->execute_query($sql, array(1, $this->id))) {
                $this->approved = 1;
                return true;
            }
            return false;
        }
        return false;
    }
}
?>
