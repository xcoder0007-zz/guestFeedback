<?php
require_once('config/db.php');

class Authmodel {
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

    public function auth_user($login) {
        $req = $this->db->query('SELECT id, password, active FROM users WHERE username = "'.$login.'" OR email = "'.$login.'"');
        return $req->fetch();
    }

    
}

?>