<?php
require_once('config/db.php');

class Score {
	public $db;
	
	function __construct()
	{
		$this->db = Db::getInstance();
	}

	public function score_question($score_id, $rate, $comment, $qid) {
      	$req = $this->db->query('INSERT INTO score_question(score_id, question_id, score, comments) VALUES ('.$score_id.','.$qid.','.$rate.',"'.$comment.'")');

        return $this->db->lastInsertId();

    }

    public function score_select($score_id, $selections, $qid) {
        $req = $this->db->query('INSERT INTO score_select(score_id, question_id, selections, comments) VALUES ('.$score_id.','.$qid.',"'.$selections.'",NULL)');

        return $this->db->lastInsertId();

    }

    public function add_score() {
        $req = $this->db->query('INSERT INTO scores() VALUES()');

        return $this->db->lastInsertId();

    }

    public function save_score($language_id, $hotel_id, $score_id, $nationality, $comments, $mail, $roomno) {
        $req = $this->db->query('UPDATE scores SET language_id='.$language_id.', nationality="'.$nationality.'",room_no='.$roomno.',hotel_id='.$hotel_id.',email="'.$mail.'",comments="'.$comments.'",active=1 WHERE id='.$score_id);
    }

}

?>