<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('css') ?>
<style>
	.gt-photo {
		height: 380px;
		width: 100%;
		background-position: center center;
		background-size: cover;
		background-repeat: no-repeat;
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

		<div class="uk-grid" uk-grid>

			<?php if (count($teamMembers)) : ?>
				<?php foreach ($teamMembers as $key => $member) : ?>
					<div class="uk-width-1-3@m uk-width-1-1@s">
						<div class="gt-name-item">
							<div class="gt-photo" style="background-image:url(<?= $member['image'] ? $member['image'] : DEFAULTPROFILEPIC ?>);">
								<div class="details-box">
									<p><?= $member['about'] ?></p>
								</div>
							</div>
							<div class="gt-details uk-text-center">
								<div class="gt-title">
									<?= $member['first_name'] . ' ' . $member['last_name'] ?>
								</div>
								<div class="gt-jobs gt-align-center">
									<?= $member['profession'] ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="uk-text-center uk-width-1-1 uk-padding-large">
					No team members found
				</div>
			<?php endif; ?>
			<!-- <div class="uk-width-1-4@m uk-width-1-2@s">
				<div class="uk-card uk-card-default">
					<div class="uk-card-media-top">
						<img src="/public/images/list-box-6.jpg" width="1800" height="1200" alt="">
					</div>
					<div class="uk-card-body uk-text-center">
						<h3 class="uk-card-title">Media Top</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
					</div>
				</div>

			</div> -->

		</div>

	</div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>