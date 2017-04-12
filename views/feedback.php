<div data-role="page" id="feedback">
	<div data-role="header">
	<a href="#" data-rel="back" data-icon="arrow-l"><?php echo $texts[3] ?></a>
		<h1 class="header" id="ratingFormHeader"><?php echo $texts[5] ?></h1>
	</div>
	<div data-role="content" style="text-align: center;">
		<div class="contentbody popup">
			<form action="/score" method="POST" id="tx_ifeedback_ratingform" data-ajax="false">
				<h2 class="question" id="ratingform_topic_description"></h2>
				<input type="hidden" id="backing6" name="score[star_rating]" value="0" />
				<span id="value6" class="ratinglabel"></span>
				<br />
				<div id="rateit6" class="rateit bigstars"></div>
				<br />
				<script type="text/javascript">
					$(function () { $('#rateit6').rateit({ max: 5, step: 1, resetable: false, min: 0, starwidth: 50, starheight: 50, backingfld: '#backing6' }); });
				</script>
				<input type="hidden" id="ta-a_placeholder" value="<?php echo $texts[25] ?>" />
				<input type="hidden" id="comment_required_at_value" value="2" />
				<br />
				<textarea name="score[comment]" id="textarea-comment" style="display:none;"></textarea>
				<textarea name="score[ratingcomment]" id="textarea-a"></textarea>
				<input type="hidden" id="tx_ifeedback_ratingform_topic_id" name="score[topic_id]">
				<p class="buttonaction">
					<input type="submit" name="score[submit_btn]" value="<?php echo $texts[37] ?>" data-inline="true" data-icon="check" data-theme="a" />
				</p>
			</form>
		</div>
	</div>
</div>