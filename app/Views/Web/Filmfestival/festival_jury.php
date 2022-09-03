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
		<form action="" method="post" class="uk-margin-bottom" id="festivalYearForm">
			<div class=" uk-grid" data-uk-grid="">
				<div class="uk-width-1-4@m uk-first-column">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<select name="selectedYear" class="uk-select" onchange="selectFestivalYear()">
								<option value="" disabled="" selected="">Select Edition </option>
								<?php foreach ($festival_editions as $key => $edition) : ?>
									<option value="<?= $edition ?>" <?= $selectedYear == $edition ? 'selected' : '' ?>>Edtion <?= count($festival_editions) - $key ?> | <?= $edition ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<!-- <div class="uk-width-1-4@m">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<input type="hidden" value="1" name="offselection">
							<button class="btn btn-warning"><i class="fa fa-search"></i> &nbsp; SEARCH &nbsp; &nbsp;</button>
						</div>
					</div>
				</div> -->
			</div>
		</form>
		<div class="uk-grid" uk-grid>

			<?php if (count($juryMembers)) : ?>
				<?php foreach ($juryMembers as $key => $member) : ?>
					<div class="uk-width-1-3@m uk-width-1-1@s">
						<div class="gt-name-item">
							<div class="gt-photo" style="background-image:url(<?= $member['image'] ? $member['image'] : DEFAULTPROFILEPIC ?>);">
								<div class="details-box">
									<a href="<?= route_to('festival_jury_details', $festivalSlug, base64_encode($member['id'])) ?>"></a>
									<p><?= $member['about'] ?></p>
								</div>
							</div>
							<div class="gt-details uk-text-center">
								<div class="gt-title">
									<a href="<?= route_to('festival_jury_details', $festivalSlug, base64_encode($member['id'])) ?>"><?= $member['first_name'] . ' ' . $member['last_name'] ?></a>
								</div>
								<div class="gt-jobs gt-align-center">
									<a href="<?= route_to('festival_jury_details', $festivalSlug, base64_encode($member['id'])) ?>"><?= $member['profession'] ?></a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="uk-text-center uk-width-1-1 uk-padding-large">
					No Juries found
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
<script>
	function selectFestivalYear(){
		$('#festivalYearForm').submit();
	}
</script>
<?= $this->endSection() ?>