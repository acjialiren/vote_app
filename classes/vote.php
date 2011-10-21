<?php
require_once('../config.php');
require_once('../db/pdo.php');

class votes {
    private $id = null;
    public $poll = null;
    public $vote = null;
    private $ip = null;
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
            $sql = "SELECT poll, vote, ip, timecreated FROM votes WHERE id=?";
            if ($this->db->execute_query($sql, array($this->id))) {
                $results = $this->db->fetch_results();

                if (!empty($results)) {
                    $result = $results[0];
                    $this->poll = $result->poll;
                    $this->vote = $result->vote;
                    $this->ip = $result->ip;
                    $this->timecreated = $result->timecreated;
                    return true;
                }
                return false;
            }
            return false;
        } else {
            return false;
        }
    }

    function save($poll, $vote, $ip) {
        if (empty($this->id)) {
            $sql = "INSERT INTO votes(poll, vote, ip, timecreated) VALUES (?, ?, ?)";
            $time = time();
            if ($this->db->execute_query($sql, array($poll, $vote, $ip, $time))) {
                $this->id = $this->db->last_id();
                $this->poll = $poll;
                $this->vote = $vote;
                $this->ip = $ip;
                $this->timcreated = $time;
                return true;
            }
            return false;
        } else {
            $sql = "UPDATE votes SET vote=?, ip=? WHERE id=?";
            if ($this->db->execute_query($sql, array($vote, $ip, $this->id))) {
                $this->vote = $vote;
                $this->ip = $ip;
                return true;
            }
            return false;
        }
    }
}
?>
