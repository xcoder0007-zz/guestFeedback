<?php
if (isset($_SESSION['score_id'])) {
	session_destroy();
	header("Location: http://{$_SERVER['SERVER_NAME']}/{$params[0]}/{$params[1]}/{$params[2]}#");
}

$hotel_code = $params[1];
$language_code = $params[2];

require_once('models/skeleton.php');
$model = new Model();

$languages = $model->getall('languages');

$hotel = $model->get_by_code("hotels", $hotel_code);
$language = $model->get_by_code("languages", $language_code);

$_SESSION['language_id'] = $language['id'];
$_SESSION['hotel_id'] = $hotel['id'];


$texts = $model->get_texts($_SESSION['language_id']);
$sections = $model->get_sections($_SESSION['language_id']);

$questions = array();
foreach ($sections as $section) {
	$questions[$section['id']] = $model->get_section_questions($section['id'], $_SESSION['language_id']);
	foreach ($questions[$section['id']] as $qk => $question) {
		if ($question['option']) {
			$questions[$section['id']][$qk]['option'] = json_encode($model->get_question_options($question['id']));
		}
	}
}


require_once('views/main.php');
?>