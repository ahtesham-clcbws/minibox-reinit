<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('content') ?>
<style>
	.schedule-card-media {
		box-shadow: 0 0px 7px rgb(0 0 0 / 16%);
		height: 280px;
		width: 100%;
		background-position: center center;
		background-size: cover;
		background-repeat: no-repeat;
	}

	.schedule-card-body {
		position: relative;
		padding-top: 40px;
	}

	.schedule-card-year {
		position: absolute;
		top: -50px;
		font-size: 70px;
		font-weight: 700;
		font-family: "Josefin Sans", sans-serif !important;
		color: #fff !important;
		text-shadow: 0 0 20px rgb(0 0 0 / 76%);
		width: 100%;
	}
</style>

<section class="about-section uk-section-small about-section-shadow" style="background-image:url(/public/images/pages-background.webp)">
	<div class="cover-shadow"></div>
	<div class="uk-container heading-section">
		<div class="uk-position-center">
			<h2><?= $pageName; ?></h2>
		</div>
	</div>
</section>

<?= view('Components/pageData'); ?>
<?php if (count($festivalSchedules)) : ?>
	<section class="service-sec uk-section-small">
		<div class="uk-container">
			<div class="">
				<div class="uk-grid" uk-grid="">
					<?php foreach ($festivalSchedules as $key => $schedule) : ?>
						<div class="uk-width-1-4@m uk-grid-margin">

							<div class="uk-card uk-card-default schedule-card">
								<div class="uk-card-media-top schedule-card-media" style="background-image:url(<?= $schedule['image'] ?>);">
									<!-- <img src="" width="1800" height="1200" alt=""> -->
								</div>
								<div class="uk-card-body schedule-card-body uk-padding-small">
									<h3 class="uk-card-title uk-text-right schedule-card-year"><?= $schedule['festival_year'] ?></h3>
									<p><?= $schedule['title'] ?></p>
								</div>
								<div class="uk-card-footer uk-padding-remove">
									<div class="uk-button-group uk-width-1-1">
										<button class="uk-button uk-button-primary uk-width-1-2">View</button>
										<button class="uk-button uk-button-secondary uk-width-1-2">Download</button>
									</div>
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