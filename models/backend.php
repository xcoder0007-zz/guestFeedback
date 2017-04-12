<?php
require_once('config/db.php');

class Backmodel {
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

    public function get_user_hotels($uid) {
        $req = $this->db->query('SELECT hotel_id FROM users_hotels WHERE user_id ='.$uid);
        return $req->fetchAll(PDO::FETCH_COLUMN);
    }

    private function users_hotels($uid, $hotels) {
        $this->db->query('DELETE FROM users_hotels WHERE user_id ='.$uid);
        foreach ($hotels as $hotel_id) {
            $req = $this->db->query('INSERT INTO users_hotels(user_id, hotel_id) VALUES("'.$uid.'","'.$hotel_id.'")');
        }
    }

    private function question_titles($qid, $titles) {
        $this->db->query('DELETE FROM question_title WHERE question_id ='.$qid);
        foreach ($titles as $language_id => $title) {
            $req = $this->db->query('INSERT INTO question_title(question_id, title, language_id) VALUES("'.$qid.'","'.$title.'","'.$language_id.'")');
        }
    }

    private function question_texts($qid, $texts) {
        $this->db->query('DELETE FROM question_text WHERE question_id ='.$qid);
        foreach ($texts as $language_id => $text) {
            $req = $this->db->query('INSERT INTO question_text(question_id, `text`, language_id) VALUES("'.$qid.'","'.$text.'","'.$language_id.'")');
        }
    }

    private function question_options($qid, $options) {
        $this->db->query('DELETE FROM question_options WHERE question_id ='.$qid);
        foreach ($options as $item) {
            if(!empty($item['option'])) {
                $req = $this->db->query('INSERT INTO question_options(question_id, `option`, flag) VALUES("'.$qid.'","'.$item['option'].'", "'.$item['flag'].'")');
            }
        }
    }

    public function insert_user($name, $username, $password, $email, $active, $admin, $hotels) {
        $req = $this->db->query('INSERT INTO users(name, username, password, email, active, admin) VALUES("'.$name.'", "'.$username.'", "'.$password.'", "'.$email.'", "'.$active.'", "'.$admin.'")');
        $uid = $this->db->lastInsertId();

        $this->users_hotels($uid, $hotels);

    }

    public function update_user($id, $name, $username, $password, $email, $active, $admin, $hotels) {
        $req = $this->db->query('UPDATE users SET name = "'.$name.'", username = "'.$username.'", password = "'.$password.'", email = "'.$email.'", active = "'.$active.'", admin = "'.$admin.'" WHERE id = '.$id);

        $this->users_hotels($id, $hotels);        

    }

    public function delete_user($id) {
        $req = $this->db->query('DELETE FROM users WHERE id = '.$id);

        $this->users_hotels($id, array());

    }

    public function get_questions() {
        $req = $this->db->query('SELECT questions.id, description, title FROM questions
            JOIN sections ON questions.section_id = sections.id
            JOIN question_title ON questions.id = question_title.question_id
            WHERE language_id = 1');
        return $req->fetchAll();
    }

    public function get_question_titles($qid) {
        $req = $this->db->query('SELECT language_id, title FROM question_title where question_id ='.$qid);
        return $req->fetchAll(PDO::FETCH_KEY_PAIR);
    }


    public function get_question_texts($qid) {
        $req = $this->db->query('SELECT language_id, text FROM question_text where question_id ='.$qid);
        return $req->fetchAll(PDO::FETCH_KEY_PAIR);
    }


    public function get_question_options($qid) {
        $req = $this->db->query('SELECT `option`, flag FROM question_options where question_id ='.$qid);
        return $req->fetchAll();
    }

    public function get_sections() {
        $req = $this->db->query('SELECT id, description AS name FROM sections');
        return $req->fetchAll();
    }

    public function insert_question($section_id, $titles, $texts, $option, $options) {
        $req = $this->db->query('INSERT INTO questions(section_id, `option`) VALUES("'.$section_id.'", "'.$option.'")');
        $qid = $this->db->lastInsertId();

        $this->question_titles($qid, $titles);
        $this->question_texts($qid, $texts);
        $this->question_options($qid, $options);

    }

    public function update_question($id, $section_id, $titles, $texts, $option, $options) {
        $req = $this->db->query('UPDATE questions SET section_id = "'.$section_id.'", `option` = "'.$option.'" WHERE id = '.$id);

        $this->question_titles($id, $titles);
        $this->question_texts($id, $texts);
        $this->question_options($id, $options);

    }


    public function delete_question($id) {
        $req = $this->db->query('DELETE FROM questions WHERE id = '.$id);

        $this->question_titles($id, array());
        $this->question_texts($id, array());
        $this->question_options($id, array());

    }


    public function insert_hotel($code, $name, $logo, $exceptions) {
        $req = $this->db->query('INSERT INTO hotels(code, name, logo, exceptions) VALUES("'.$code.'", "'.$name.'", "'.$logo.'", "'.$exceptions.'")');
        $uid = $this->db->lastInsertId();
    }

    public function update_hotel($id, $code, $name, $logo, $exceptions) {
        $req = $this->db->query('UPDATE hotels SET code = "'.$code.'", name = "'.$name.'", logo="'.$logo.'", exceptions = "'.$exceptions.'" WHERE id = '.$id);
    }

    public function delete_hotel($id) {
        $req = $this->db->query('DELETE FROM hotels WHERE id = '.$id);
    }


    public function insert_language($code, $name, $flag) {
        $req = $this->db->query('INSERT INTO languages(code, name, flag) VALUES("'.$code.'", "'.$name.'", "'.$flag.'")');
        $uid = $this->db->lastInsertId();
    }

    public function update_language($id, $code, $name, $flag) {
        $req = $this->db->query('UPDATE languages SET code = "'.$code.'", name = "'.$name.'", flag="'.$flag.'" WHERE id = '.$id);
    }

    public function delete_language($id) {
        $req = $this->db->query('DELETE FROM languages WHERE id = '.$id);
    }

    public function get_section_names($sid) {
        $req = $this->db->query('SELECT language_id, name FROM section_name where section_id ='.$sid);
        return $req->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    private function section_names($sid, $names) {
        $this->db->query('DELETE FROM section_name WHERE section_id ='.$sid);
        foreach ($names as $language_id => $name) {
            $req = $this->db->query('INSERT INTO section_name(section_id, name, language_id) VALUES("'.$sid.'","'.$name.'","'.$language_id.'")');
        }
    }

    public function insert_section($description, $names) {
        $req = $this->db->query('INSERT INTO sections(description) VALUES("'.$description.'")');
        $sid = $this->db->lastInsertId();
        $this->section_names($sid, $names);
    }

    public function update_section($id, $description, $names) {
        $req = $this->db->query('UPDATE sections SET description = "'.$description.'" WHERE id = '.$id);
        $this->section_names($id, $names);

    }

    public function delete_section($id) {
        $req = $this->db->query('DELETE FROM sections WHERE id = '.$id);
        $this->section_names($id, array());
    }


    public function get_text_texts($tid) {
        $req = $this->db->query('SELECT language_id, text FROM texts_text where text_id ='.$tid);
        return $req->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    private function text_texts($tid, $texts) {
        $this->db->query('DELETE FROM texts_text WHERE text_id ='.$tid);
        foreach ($texts as $language_id => $text) {
            $req = $this->db->query('INSERT INTO texts_text(text_id, text, language_id) VALUES("'.$tid.'","'.$text.'","'.$language_id.'")');
        }
    }

    public function insert_text($description, $texts) {
        $req = $this->db->query('INSERT INTO texts(description) VALUES("'.$description.'")');
        $uid = $this->db->lastInsertId();
        $this->text_texts($id, $texts);
    }

    public function update_text($id, $description, $texts) {
        $req = $this->db->query('UPDATE texts SET description = "'.$description.'" WHERE id = '.$id);
        $this->text_texts($id, $texts);

    }

    public function delete_text($id) {
        $req = $this->db->query('DELETE FROM texts WHERE id = '.$id);
        $this->text_texts($id, array());
    }
}

?>