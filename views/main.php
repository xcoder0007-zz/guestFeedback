<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		var ratingDefaultLabel		=	'<?php echo $texts[27]; ?>';
		var rating1Label			=	'<?php echo $texts[28]; ?>';
		var rating2Label			=	'<?php echo $texts[29]; ?>';
		var rating3Label			=	'<?php echo $texts[30]; ?>';
		var rating4Label			=	'<?php echo $texts[31]; ?>';
		var rating5Label			=	'<?php echo $texts[32]; ?>';

		var noRatingValueError		= 	'<?php echo $texts[33]; ?>';
		var commentRequired			=	'<?php echo $texts[34]; ?>';
		var noCookieWarning			=	'<?php echo $texts[35]; ?>';
	</script>
	<?php require_once('views/header.php'); ?>
	<title>SUNRISE feedback</title>
</head>
<body>
	<div data-role="page" id="page0" class="disable_until_window_load">
		<div data-role="header">
			
			<h1 class="header"><?php echo $hotel['name']; ?></h1>
			<a href="#sendfeedbackpage" class="send_feedback_button ui-btn-right" data-role="button" data-iconpos="right" data-theme="d" data-icon="arrow-r" data-inline="true"><?php echo $texts[4] ?></a>
		</div>
		<div data-role="content">
			<div class="contentheader">
				<div class="container_12">
					<div class="grid_8 if_logo">
						<a href="#page0" data-transition="none">
							<img src="<?php echo $hotel['logo']; ?>"></a>
					</div>
					<div class="grid_4 langselector">
						<a href="#languages" data-role="button" data-mini="true" data-inline="true">
							<img class="flag" src="<?php echo $language['flag']; ?>" />
						</a>
					</div>
				</div>
			</div>
			<div class="contentbody contentbodyheight topicslist">
				<h1 class="headerquest"><?php echo $texts[1]; ?></h1>
				<?php foreach ($sections as $section): ?>
				<ul data-role="listview" data-inset="true">
					<li>
						<a href="#page<?php echo $section['id'] ?>" id="a<?php echo $section['id'] ?>" class="category_link">
							<?php echo $section['name'] ?></a>
						<span class="ui-li-count" id="ratingsum_span<?php echo $section['id'] ?>" style="visibility: hidden">0</span>
					</li>
				</ul>
				<?php endforeach; ?>
			</div>
		</div>
		<div data-role="footer">
			<?php include('views/footer.php'); ?>
		</div>
	</div>
	<?php foreach ($sections as $section): ?>
	<div data-role="page" id="page<?php echo $section['id'] ?>" class="disable_until_window_load">
	  <div data-role="header">
	    <a href="#page0" data-icon="arrow-l" data-transition="none"><?php echo $texts[3]; ?></a>
	    <h1 class="header"><?php echo $section['name'] ?></h1>
	    <a href="#sendfeedbackpage" class="send_feedback_button ui-btn-right" data-role="button" data-iconpos="right" data-theme="d" data-icon="arrow-r" data-inline="true"><?php echo $texts[4]; ?></a>
	  </div>
	  <div data-role="content">
	    <div class="contentheader">
	      <div class="container_12">
	        <div class="grid_8 if_logo">
	          <a href="#page0" data-transition="none">
	            <img src="<?php echo $hotel['logo']; ?>"></a>
	        </div>
	        <div class="grid_4 langselector">
	          <a href="#languages" data-role="button" data-mini="true" data-inline="true">
	            <img class="flag" src="<?php echo $language['flag']; ?>" />
	          </a>
	        </div>
	      </div>
	    </div>
	    <div class="contentbody contentbodyheight topicslist">
	    <?php foreach ($questions[$section['id']] as $question): ?>
	    <ul data-role="listview" data-inset="true">
	        <li data-icon="false" id="l<?php echo $question['id'] ?>">
	        <?php if ($question['option']): ?>
	        	<script type="text/javascript">
	        		var q<?php echo $question['id'] ?>options = <?php echo $question['option'] ?>;
	        	</script>
	        	<a href="#feedbacko" id="a<?php echo $question['id'] ?>" class="rating_link" onClick="javascript:setTopicIdo(<?php echo $question['id'] ?>, '<?php echo $question['title'] ?>', '<?php echo $question['text'] ?>', q<?php echo $question['id'] ?>options )" rating-strs="">
	        <?php else: ?>
	          	<a href="#feedback" id="a<?php echo $question['id'] ?>" class="rating_link" onClick="javascript:setTopicId(<?php echo $question['id'] ?>, '<?php echo $question['title'] ?>', '<?php echo $question['text'] ?>')" rating-strs="">
	      <?php endif; ?>
	            <?php echo $question['title'] ?>
	            <span class="ui-li-count" id="rating_span<?php echo $question['id'] ?>" style="visibility:hidden"></span>
	            <span id="rating_value_span<?php echo $question['id'] ?>" class="rating_value_span"></span>
	            <span id="rating_comment_span<?php echo $question['id'] ?>" class="rating_comment_span"></span>
	          </a>
	        </li>
	    </ul>
	    <?php endforeach ?>
	    </div>
	  </div>
	  <div data-role="footer">
	  <?php include('views/footer.php'); ?>
	  </div>
	</div>
	<?php endforeach ?>
	<?php include('views/feedback.php'); ?>
	<?php include('views/feedbacko.php'); ?>
	<?php include('views/language.php'); ?>
	<?php include('views/sendfeedback.php'); ?>
	<?php include('views/checkout.php'); ?>
</body>
</html>