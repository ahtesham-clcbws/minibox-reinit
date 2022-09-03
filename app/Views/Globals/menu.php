<?php if (getFooter(getUri()->getSegment(1))) : ?>
			<?= view('Globals/festival_menu') ?>
<?php else : ?>
			<?= view('Globals/main_menu') ?>
<?php endif; ?>