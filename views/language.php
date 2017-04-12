<div data-role="page" id="languages">
	<div data-role="header">
		<a href="#" data-rel="back" data-icon="arrow-l"><?php echo $texts[3] ?></a>
		<h1 class="header"><?php echo $texts[6] ?></h1>
	</div>
	<div data-role="content">
		<div class="contentbody">
			<h2><?php echo $texts[7] ?></h2>
			<ul id="ul_langselect" data-role="listview" data-inset="true">
			<?php foreach ($languages as $lang): ?>
				
				<li data-icon="false" class="li_lng">
					<a href="<?php echo $lang['id'] ?>" data-ajax="false">
						<img src="<?php echo $lang['flag'] ?>" class="ui-li-icon"><?php echo $lang['name'] ?></a>
				</li>
			<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>