<div data-role="page" id="feedbacko">
	<div data-role="header">
	<a href="#" data-rel="back" data-icon="arrow-l"><?php echo $texts[3] ?></a>
		<h1 class="header" id="optionFormHeader"><?php echo $texts[5] ?></h1>
	</div>
	<div data-role="content" style="text-align: center;">
		<div class="contentbody popup">
			<form action="/score" method="POST" id="tx_ifeedback_optionform" data-ajax="false">
				<h2 class="question" id="optionform_topic_description"></h2>
				<p id="yes-no" class="buttonaction">
					<input id="yes-button" type="button" value="<?php echo $texts[39] ?>" class="data-more" data-inline="true" data-icon="check" data-theme="a" />
					<input type="submit" name="score[submit_btn]" value="<?php echo $texts[40] ?>" data-inline="true" data-icon="check" data-theme="a" />
				</p>
				<div id="options-wrapper">
					<div id="optionform_topic_options">
					</div>
					<p class="buttonaction">
						<input type="submit" name="score[submit_btn]" value="<?php echo $texts[37] ?>" data-inline="true" data-icon="check" data-theme="a" />
					</p>
				</div>
				<input type="hidden" id="tx_ifeedback_optionform_topic_id" name="score[topic_id]">
				<input type="hidden" id="tx_ifeedback_optionform_topic_options_i" value="1" name="score[options]">
				
			</form>
		</div>
	</div>
</div>