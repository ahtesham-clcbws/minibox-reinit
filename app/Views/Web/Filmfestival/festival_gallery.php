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
	<div class="uk-container">

		<div class="uk-child-width-1-4@m gallery-grid" uk-grid uk-lightbox="animation: slide">
			<?php foreach ($gallery as $key => $image) : ?>
				<div class="gallery-item uk-margin-small-bottom">
					<div class="uk-card uk-card-default uk-card-hover">
						<div class="uk-card-body uk-padding-small">
							<a class="uk-inline" href="<?= $image['image'] ?>" data-caption="<?= $image['caption'] ?>">
								<img src="<?= $image['image'] ?>" width="1800" height="1200" alt="">
							</a>
							<div class="gallery-details">
								<a href="<?= $image['image'] ?>" data-caption="<?= $image['caption'] ?>"><?= $image['caption'] ?></a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>

		</div>

	</div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script>
	$('.gallery-grid').isotope({
		// options
		itemSelector: '.gallery-item',
		layoutMode: 'masonry'
	});
</script>
<?= $this->endSection() ?>