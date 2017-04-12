<div class="logocust" style="background-color: #EEE">
	<img src="<?php echo $hotel['logo']; ?>"></div>
<div data-role="navbar" class="nav-glyphish-example">
	<ul>
	<?php foreach ($sections as $section): ?>
		<li>
			<a href="#page<?php echo $section['id'] ?>" class="category_link moreicon" id="f<?php echo $section['id'] ?>" data-icon="custom">
				<?php echo $section['name'] ?>
				<span class="outer-counter ratingsum_wrap<?php echo $section['id'] ?>" style="visibility: hidden">
					<span class="inner-counter ratingsum_wrap<?php echo $section['id'] ?>" style="visibility: hidden">
						<span class="badge-counter ratingsum_wrap<?php echo $section['id'] ?>" style="visibility: hidden">
							<span class="ratingsum_span<?php echo $section['id'] ?>" style="visibility: hidden"> <b>0</b>
							</span>
						</span>
					</span>
				</span>
			</a>
		</li>
	<?php endforeach ?>
	</ul>
</div>