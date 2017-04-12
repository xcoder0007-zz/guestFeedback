<?php

require_once('models/score.php');

$model = new score();

if (!isset($_SESSION['score_id'])) {
	$_SESSION['score_id'] = $model->add_score();
}

function true_value($var) {
	return ($var)? true : false;
}

if (isset($_POST['score'])) {
	$score = $_POST['score'];
	if (isset($score['options'])) {
		$selections = implode(',', array_keys(array_filter($score[$score['topic_id']], "true_value")));
		echo $model->score_select($_SESSION['score_id'], $selections, $score['topic_id']);
	} else {
		echo $model->score_question($_SESSION['score_id'], $score['star_rating'], $score['ratingcomment'], $score['topic_id']);
	}
	
} elseif (isset($_POST['info'])) {
	$info = $_POST['info'];
	echo $model->save_score($_SESSION['language_id'], $_SESSION['hotel_id'], $_SESSION['score_id'], $info['contact_nationality'], $info['contact_comments'], $info['contact_mail'], $info['contact_roomno']);
	session_destroy();
} else {
	die('invalid');
}

?>