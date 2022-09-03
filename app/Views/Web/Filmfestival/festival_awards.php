<?= $this->extend('Layouts/Web/film_festival') ?>

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
<?php if (count($festivalAwards)) : ?>
	<section class="service-sec uk-section-small">
		<div class="uk-container">
			<div class="">
				<div class="uk-grid" uk-grid="">
					<?php foreach ($festivalAwards as $key => $award) : ?>
						<div class="uk-width-1-4@m uk-grid-margin">
							<div class="uk-text-center p-0">
								<div class="awards-box">
									<div class="service-box-icon ">
										<img src="<?= $award['image'] ?>" alt="<?= $award['title'] ?>">
									</div>
									<div class="awards-box-con">
										<h3><?= $award['title'] ?></h3>
										<p><?= $award['content'] ?></p>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>