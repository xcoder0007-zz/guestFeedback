<?php
require_once('models/backend.php');

/**
* backend class
*/
class Backend
{
	private $model;
	private $data;
	
	function __construct()
	{
		$this->model = new Backmodel();
		if (!isset($_SESSION['user']['id'])) {
			header('Location: /auth/login');
			die();
		}
	}

	public function index() {
		$this->data['view'] = 'view';
		$this->view();
	}

	/**
	 * generic file upload
	 */
	private function upload_file($filename) {
		$result = array(
			'error' => "",
			'filename' => "");
		// Undefined | Multiple Files | $_FILES Corruption Attack
	    // If this request falls under any of them, treat it invalid.
	    if (!isset($_FILES[$filename]['error']) || is_array($_FILES[$filename]['error'])) {
	        $result['error'][] = 'Invalid parameters.';
	    }

	    // Check $_FILES[$filename]['error'] value.
	    switch ($_FILES[$filename]['error']) {
	        case UPLOAD_ERR_OK:
	            break;
	        case UPLOAD_ERR_NO_FILE:
	            $result['error'][] = 'No file sent.';
	        case UPLOAD_ERR_INI_SIZE:
	        case UPLOAD_ERR_FORM_SIZE:
	            $result['error'][] = 'Exceeded filesize limit.';
	        default:
	            $result['error'][] = 'Unknown errors.';
	    }

	    // You should also check filesize here. 
	    if ($_FILES[$filename]['size'] > 1000000) {
	        $result['error'][] = 'Exceeded filesize limit.';
	    }

	    // DO NOT TRUST $_FILES[$filename]['mime'] VALUE !!
	    // Check MIME Type by yourself.
	    $finfo = new finfo(FILEINFO_MIME_TYPE);
	    if (false === $ext = array_search(
	        $finfo->file($_FILES[$filename]['tmp_name']),
	        array(
	            'jpg' => 'image/jpeg',
	            'png' => 'image/png',
	            'gif' => 'image/gif',
	        ),
	        true
	    )) {
	        $result['error'][] = 'Invalid file format.';
	    }

	    // You should name it uniquely.
	    // DO NOT USE $_FILES[$filename]['name'] WITHOUT ANY VALIDATION !!
	    // On this example, obtain safe unique name from its binary data.
	    $result['filename'] = sprintf('/files/uploads/%s.%s',
	            sha1_file($_FILES[$filename]['tmp_name']),
	            $ext
	        ); 
	    if (!move_uploaded_file($_FILES[$filename]['tmp_name'], getcwd().$result['filename'])) {
	        $result['error'][] = 'Failed to move uploaded file.';
	    }

	    return $result;
	}

	private function view() {
		require_once('views/backend/backend.php');
	}


	###SECTION### users
	public function users() {
		$this->data['users'] = $this->model->getall('users');
		$this->data['view'] = 'view';

		$this->data['table'] = 'users';
		$this->data['title'] = 'Users';
		$this->data['action'] = 'user';
		$this->data['heads'] = array('#', 'Name', 'Email', 'Username');
		$this->data['fields'] = array('id', 'name', 'email', 'username');

		$this->view();
	}

	public function user($id) {

		if (!empty($_POST)) {
	         
	        // validate input
	        $valid = true;
	        if (empty($_POST['name'])) {
	            $Error = 'Please enter Name';
	            $valid = false;
	        }

	        $active = isset($_POST['active'])? 1 : 0;
	        $admin = isset($_POST['admin'])? 1 : 0;
	         
	        // insert data
	        if (!$valid) {
	        	$this->data['error'] = $Error;
	        } else {
	        	if(empty($_POST['id'])) {
	        		$uid = $this->model->insert_user($_POST['name'], $_POST['username'], $_POST['password'], $_POST['email'], $active, $admin, $_POST['hotels']);
	        	} else {
	        		$this->model->update_user($_POST['id'], $_POST['name'], $_POST['username'], $_POST['password'], $_POST['email'], $active, $admin, $_POST['hotels']);
	        	}

	        	header('Location: /backend/users');
				die();
	        }
	    }

		if (isset($id) && !is_nan($id)) {
			$this->data['user'] = $this->model->get_by_id('users', $id);
			$this->data['user']['hotels'] = array_flip($this->model->get_user_hotels($id));
		}
		$this->data['view'] = 'process';
		$this->data['item'] = 'user';
		$this->data['table'] = 'users';
		$this->data['title'] = 'User';
		$this->data['inputs'] = array(
			array('head' => '#' , 'field' => 'id', 'type' => 'hidden' ),
			array('head' => 'Name' , 'field' => 'name', 'type' => 'text' ),
			array('head' => 'Email' , 'field' => 'email', 'type' => 'text' ),
			array('head' => 'Username' , 'field' => 'username', 'type' => 'text' ),
			array('head' => 'Password' , 'field' => 'password', 'type' => 'password' ),
			array('head' => 'Active' , 'field' => 'active', 'type' => 'checkbox' ),
			array('head' => 'Admin' , 'field' => 'admin', 'type' => 'checkbox' ),
			array('head' => 'Hotels' , 'field' => 'hotels', 'type' => 'select', 'attributes' => 'multiple', 'options' => $this->model->getall('hotels'))
			);


		$this->view();
	}

	public function user_rem($id) {
		$this->model->delete_user($id);
		header('Location: /backend/users');
		die();
	}

	##END_SECTION### users

	###SECTION### questions
	public function questions() {
		$this->data['questions'] = $this->model->get_questions();
		$this->data['view'] = 'view';

		$this->data['table'] = 'questions';
		$this->data['title'] = 'Questions';
		$this->data['action'] = 'question';
		$this->data['heads'] = array('#', 'Section', 'Title');
		$this->data['fields'] = array('id', 'description', 'title');

		$this->view();
	}

	public function question($id) {

		if (!empty($_POST)) {
	         
	        // validate input
	        $valid = true;
	        if (empty($_POST['section_id'])) {
	            $Error = 'Please select section';
	            $valid = false;
	        }

	        $options = array();
	        foreach ($_POST['options'] as $key => $o) {
	        	$options[] = array('option' => $o, 'flag' => $_POST['flag'][$key]);
	        }

	        $option = isset($_POST['option'])? 1: 0;
	         
	        // insert data
	        if (!$valid) {
	        	$this->data['error'] = $Error;
	        } else {
	        	if(empty($_POST['id'])) {
	        		$qid = $this->model->insert_question($_POST['section_id'], $_POST['title'], $_POST['text'], $option, $options);
	        	} else {
	        		$this->model->update_question($_POST['id'], $_POST['section_id'], $_POST['title'], $_POST['text'], $option, $options);
	        	}
	        	
	        	header('Location: /backend/questions');
				die();
	        }
	    }

	    $languages = $this->model->getall('languages');

		if (isset($id) && !is_nan($id)) {
			$this->data['question'] = $this->model->get_by_id('questions', $id);
			
			$qtitles = $this->model->get_question_titles($id);
			foreach ($qtitles as $key => $value) {
				$this->data['question']["title[${key}]"] = $value;
			}

			$qtexts = $this->model->get_question_texts($id);
			foreach ($qtexts as $key => $value) {
				$this->data['question']["text[${key}]"] = $value;
			}

			if ($this->data['question']['option']) {
				$question_options = $this->model->get_question_options($id);
			}
		}
		$this->data['view'] = 'process';
		$this->data['item'] = 'question';
		$this->data['table'] = 'questions';
		$this->data['title'] = 'Question';
		$this->data['inputs'] = array(
			array('head' => '#' , 'field' => 'id', 'type' => 'hidden' ),
			array('head' => 'Section' , 'field' => 'section_id', 'type' => 'select', 'options' => $this->model->get_sections() ),
			
			);

		foreach ($languages as $language) {
			$this->data['inputs'][] = array('head' => "${language['name']} Title" , 'field' => "title[${language['id']}]", 'type' => 'text' );
			$this->data['inputs'][] = array('head' => "${language['name']} Text" , 'field' => "text[${language['id']}]", 'type' => 'text' );
		}


		$this->data['inputs'][] = array('head' => "Options" , 'field' => "option", 'type' => 'checkbox' );
			
		if(isset($question_options)) {
			foreach ($question_options as $option) {
				$this->data['inputs'][] = array('head' => "" , 'field' => "options[]", 'type' => 'inc', 'value' => $option['option'], 'flag' => $option['flag']);
			}
		}

		$this->data['inputs'][] = array('head' => "" , 'field' => "options[]", 'type' => 'inc');


		$this->view();
	}

	public function question_rem($id) {
		$this->model->delete_question($id);
		header('Location: /backend/questions');
		die();
	}
	###END_SECTION### questions

	###SECTION### hotels
	public function hotels() {
		$this->data['hotels'] = $this->model->getall('hotels');
		$this->data['view'] = 'view';

		$this->data['table'] = 'hotels';
		$this->data['title'] = 'Hotels';
		$this->data['action'] = 'hotel';
		$this->data['heads'] = array('#', 'Name', 'Code');
		$this->data['fields'] = array('id', 'name', 'code');

		$this->view();
	}

	public function hotel($id) {

		if (!empty($_POST)) {
	         
	        // validate input
	        $valid = true;
	        if (empty($_POST['name'])) {
	            $Error = 'Please enter name';
	            $valid = false;
	        }

	        if ($_FILES['logo']['size']) {
		        $logo = $this->upload_file('logo');

		        if (!empty($logo['error'])) {
		        	$Error = $logo['error'];
		        	$valid = false;
		        }
		    }

	        // insert data
	        if (!$valid) {
	        	$this->data['error'] = $Error;
	        } else {
	        	if(empty($_POST['id'])) {
	        		$qid = $this->model->insert_hotel($_POST['code'], $_POST['name'], $logo['filename'], $_POST['exceptions']);
	        	} else {
	        		$this->model->update_hotel($_POST['id'], $_POST['code'], $_POST['name'], $logo['filename'], $_POST['exceptions']);
	        	}
	        	
	        	header('Location: /backend/hotels');
				die();
	        }
	    }

		if (isset($id) && !is_nan($id)) {
			$this->data['hotel'] = $this->model->get_by_id('hotels', $id);
			
		}
		$this->data['view'] = 'process';
		$this->data['item'] = 'hotel';
		$this->data['table'] = 'hotels';
		$this->data['title'] = 'hotel';
		$this->data['inputs'] = array(
			array('head' => '#' , 'field' => 'id', 'type' => 'hidden' ),
			array('head' => "Name" , 'field' => "name", 'type' => 'text'),
			array('head' => "Code" , 'field' => "code", 'type' => 'text'),
			array('head' => "Logo" , 'field' => "logo", 'type' => 'img'),
			array('head' => "Eexceptions" , 'field' => "exception", 'type' => 'text')			
			);

		$this->view();
	}

	public function hotel_rem($id) {
		$this->model->delete_hotel($id);
		header('Location: /backend/hotels');
		die();
	}
	###END_SECTION### hotels

	###SECTION### languages
		public function languages() {
		$this->data['languages'] = $this->model->getall('languages');
		$this->data['view'] = 'view';

		$this->data['table'] = 'languages';
		$this->data['title'] = 'languages';
		$this->data['action'] = 'language';
		$this->data['heads'] = array('#', 'Name', 'Code');
		$this->data['fields'] = array('id', 'name', 'code');

		$this->view();
	}

	public function language($id) {

		if (!empty($_POST)) {
	         
	        // validate input
	        $valid = true;
	        if (empty($_POST['name'])) {
	            $Error = 'Please enter name';
	            $valid = false;
	        }

	        if ($_FILES['flag']['size']) {
		        $flag = $this->upload_file('flag');

		        if (!empty($flag['error'])) {
		        	$Error = $flag['error'];
		        	$valid = false;
		        }
		    }

	        // insert data
	        if (!$valid) {
	        	$this->data['error'] = $Error;
	        } else {
	        	if(empty($_POST['id'])) {
	        		$qid = $this->model->insert_language($_POST['code'], $_POST['name'], $flag['filename']);
	        	} else {
	        		$this->model->update_language($_POST['id'], $_POST['code'], $_POST['name'], $flag['filename']);
	        	}
	        	
	        	header('Location: /backend/languages');
				die();
	        }
	    }

		if (isset($id) && !is_nan($id)) {
			$this->data['language'] = $this->model->get_by_id('languages', $id);
			
		}
		$this->data['view'] = 'process';
		$this->data['item'] = 'language';
		$this->data['table'] = 'languages';
		$this->data['title'] = 'language';
		$this->data['inputs'] = array(
			array('head' => '#' , 'field' => 'id', 'type' => 'hidden' ),
			array('head' => "Name" , 'field' => "name", 'type' => 'text'),
			array('head' => "Code" , 'field' => "code", 'type' => 'text'),
			array('head' => "Flag" , 'field' => "flag", 'type' => 'img'),		
			);

		$this->view();
	}

	public function language_rem($id) {
		$this->model->delete_language($id);
		header('Location: /backend/languages');
		die();
	}
	###END_SECTION### languages


	###SECTION### sections
		public function sections() {
		$this->data['sections'] = $this->model->getall('sections');
		$this->data['view'] = 'view';

		$this->data['table'] = 'sections';
		$this->data['title'] = 'sections';
		$this->data['action'] = 'section';
		$this->data['heads'] = array('#', 'Description');
		$this->data['fields'] = array('id', 'description');

		$this->view();
	}

	public function section($id) {

		if (!empty($_POST)) {
	         
	        // validate input
	        $valid = true;
	        if (empty($_POST['name'])) {
	            $Error = 'Please enter name';
	            $valid = false;
	        }

	        // insert data
	        if (!$valid) {
	        	$this->data['error'] = $Error;
	        } else {
	        	if(empty($_POST['id'])) {
	        		$qid = $this->model->insert_section($_POST['description'], $_POST['name']);
	        	} else {
	        		$this->model->update_section($_POST['id'], $_POST['description'], $_POST['name']);
	        	}
	        	
	        	header('Location: /backend/sections');
				die();
	        }
	    }


	    $languages = $this->model->getall('languages');

		if (isset($id) && !is_nan($id)) {
			$this->data['section'] = $this->model->get_by_id('sections', $id);

			$snames = $this->model->get_section_names($id);
			foreach ($snames as $key => $value) {
				$this->data['section']["name[${key}]"] = $value;
			}
			
		}

		$this->data['view'] = 'process';
		$this->data['item'] = 'section';
		$this->data['table'] = 'sections';
		$this->data['title'] = 'section';
		$this->data['inputs'] = array(
			array('head' => '#' , 'field' => 'id', 'type' => 'hidden' ),
			array('head' => "Description" , 'field' => "description", 'type' => 'text' )
			);

		foreach ($languages as $language) {
			$this->data['inputs'][] = array('head' => "${language['name']} Name" , 'field' => "name[${language['id']}]", 'type' => 'text' );
		}

		$this->view();
	}

	public function section_rem($id) {
		$this->model->delete_section($id);
		header('Location: /backend/sections');
		die();
	}
	###END_SECTION### sections


	###SECTION### texts
		public function texts() {
		$this->data['texts'] = $this->model->getall('texts');
		$this->data['view'] = 'view';

		$this->data['table'] = 'texts';
		$this->data['title'] = 'texts';
		$this->data['action'] = 'text';
		$this->data['heads'] = array('#', 'Description');
		$this->data['fields'] = array('id', 'description');

		$this->view();
	}

	public function text($id) {

		if (!empty($_POST)) {
	         
	        // validate input
	        $valid = true;
	        if (empty($_POST['text'])) {
	            $Error = 'Please enter text';
	            $valid = false;
	        }

	        // insert data
	        if (!$valid) {
	        	$this->data['error'] = $Error;
	        } else {
	        	if(empty($_POST['id'])) {
	        		$qid = $this->model->insert_text($_POST['description'], $_POST['text']);
	        	} else {
	        		$this->model->update_text($_POST['id'], $_POST['description'], $_POST['text']);
	        	}
	        	
	        	header('Location: /backend/texts');
				die();
	        }
	    }


	    $languages = $this->model->getall('languages');

		if (isset($id) && !is_nan($id)) {
			$this->data['text'] = $this->model->get_by_id('texts', $id);

			$ttexts = $this->model->get_text_texts($id);
			foreach ($ttexts as $key => $value) {
				$this->data['text']["text[${key}]"] = $value;
			}
			
		}

		$this->data['view'] = 'process';
		$this->data['item'] = 'text';
		$this->data['table'] = 'texts';
		$this->data['title'] = 'Text';
		$this->data['inputs'] = array(
			array('head' => '#' , 'field' => 'id', 'type' => 'hidden' ),
			array('head' => "Description" , 'field' => "description", 'type' => 'text' )
			);

		foreach ($languages as $language) {
			$this->data['inputs'][] = array('head' => "${language['name']} text" , 'field' => "text[${language['id']}]", 'type' => 'textarea' );
		}

		$this->view();
	}

	public function text_rem($id) {
		$this->model->delete_text($id);
		header('Location: /backend/texts');
		die();
	}
	###END_SECTION### texts


}


#ROUTER#
$be = new Backend();
if (empty($params[1])) {
	$params[1] = 'index';
}
$be->{$params[1]}($params[2]);
?>