<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('css') ?>
<style>
	.inner-text h4 {
		font-size: 24px;
		color: #004080;
	}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<section class="about-section uk-section-small about-section-shadow" style="background-image:url(/public/images/pages-background.webp)">
	<div class="cover-shadow"></div>
	<div class="uk-container heading-section">
		<div class="uk-position-center">
			<h2><?= $pageName; ?></h2>
		</div>
	</div>
</section>

<?= view('Components/pageData'); ?>

<section class="uk-section-small">
	<div class="uk-container inner-text">

		<?php foreach ($festival_editions as $edition) : ?>
			<?php if (isset($pressNews[$edition]) && count($pressNews[$edition])) : ?>
				<div class="press-list">
					<h4 class="uk-text-bold m-0"><?= $edition ?></h4>
					<ul class="uk-list-striped uk-list ">
						<?php foreach ($pressNews[$edition] as $press) : ?>
							<li>
								<a href="<?= $press['url'] ?>" target="_blank"><?= $press['title'] ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
	function selectFestivalYear() {
		$('#festivalYearForm').submit();
	}
</script>
<?= $this->endSection() ?>