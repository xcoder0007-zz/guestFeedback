<?php
require_once('config/db.php');

/**
* skeleton model
*/
class Model {
	public $db;
	
	function __construct()
	{
		$this->db = Db::getInstance();
	}

	public function getall($table) {
      	$req = $this->db->query('SELECT * FROM '.$table);
      	return $req->fetchAll();
    }

    public function get_by_id($table, $id) {
    	$req = $this->db->query('SELECT * FROM '.$table.' WHERE id = '.$id);
      	return $req->fetch();
    }

    public function get_by_code($table, $code) {
        $req = $this->db->query('SELECT * FROM '.$table.' WHERE code = "'.$code.'"');
        return $req->fetch();
    }

    public function get_texts($language_id) {
    	$req = $this->db->query('SELECT texts.id, text 
    		FROM texts 
    		JOIN texts_text ON texts.id = texts_text.text_id 
    		WHERE texts_text.language_id = '.$language_id.' 
    		ORDER BY texts.id');
      	return $req->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function get_sections($language_id) {
    	$req = $this->db->query('SELECT sections.id, name 
    		FROM sections 
    		JOIN section_name ON sections.id = section_name.section_id 
    		WHERE section_name.language_id = '.$language_id.' 
    		ORDER BY sections.id');
      	return $req->fetchAll();
    }

    public function get_section_questions($section_id, $language_id) {
    	$req = $this->db->query('SELECT questions.id, title, text, `option` 
    		FROM questions 
    		JOIN question_title ON questions.id = question_title.question_id  
    		JOIN question_text ON questions.id = question_text.question_id 
    		WHERE question_title.language_id = '.$language_id.' 
    		AND question_text.language_id = '.$language_id.' 
    		AND questions.section_id = '.$section_id);
    	return $req->fetchAll();
    }

    public function get_question_options($question_id) {
        $req = $this->db->query('SELECT id, `option`, flag
            FROM question_options
            WHERE question_id = '.$question_id);
        return $req->fetchAll();
    }
}

?>