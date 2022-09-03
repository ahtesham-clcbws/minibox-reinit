<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('content') ?>

<!-- HERO -->
<section class="about-section uk-section-small about-section-shadow" style="background-image:url(/public/images/pages-background.webp)">
	<div class="cover-shadow"></div>
	<div class="uk-container heading-section">
		<div class="uk-position-center">
			<h2><?= $pageName; ?></h2>
		</div>
	</div>
</section>

<?= view('Components/pageData'); ?>

<section class="service-sec uk-section-small">

	<div class="uk-container">
		<div class="service-border-section">

			<div class="uk-position-relative uk-visible-toggle uk-light uk-slider uk-slider-container" tabindex="-1" uk-slider="">

				<ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m" style="transform: translate3d(0px, 0px, 0px);">
					<li tabindex="-1" class="uk-active">
						<div class="service-box service-box-first">
							<div class="service-box-icon service-svg-icon">
								<i class="<?= $pagedata['icon1'] ?>"></i>
							</div>
							<h3><?= $pagedata['icon_title1'] ?></h3>
							<p><?= $pagedata['icon_content1'] ?></p>
						</div>
					</li>
					<li tabindex="-1" class="uk-active">
						<div class="service-box">
							<div class="service-box-icon service-svg-icon">
								<i class="<?= $pagedata['icon2'] ?>"></i>
							</div>
							<h3><?= $pagedata['icon_title2'] ?></h3>
							<p><?= $pagedata['icon_content2'] ?></p>
						</div>
					</li>
					<li tabindex="-1" class="uk-active">
						<div class="service-box">
							<div class="service-box-icon service-svg-icon">
								<i class="<?= $pagedata['icon3'] ?>"></i>
							</div>
							<h3><?= $pagedata['icon_title3'] ?></h3>
							<p><?= $pagedata['icon_content3'] ?></p>
						</div>
					</li>
					<li tabindex="-1" class="uk-active">
						<div class="service-box">
							<div class="service-box-icon service-svg-icon">
								<i class="<?= $pagedata['icon4'] ?>"></i>
							</div>
							<h3><?= $pagedata['icon_title4'] ?></h3>
							<p><?= $pagedata['icon_content4'] ?></p>
						</div>
					</li>

				</ul>

			</div>

		</div>
	</div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>