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

<div class="uk-section-small detail-page-bg">
	<div class="uk-container">
		<div class="row">
			<div class="col-md-12">
				<div class="gridlove-box box-inner-p-bigger entry-content">
					<form class="uk-form-horizontal" id="SignupForm" action="verify" method="post" onsubmit="return false" name="myForm">
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Name of the Volunteer</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" name="name" placeholder="Name of the volunteer">
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Country</label>
							<div class="uk-form-controls">
								<select name="countryId" class="uk-select" autocomplete="off" id="selectCountry">
									<option value="" selected="" disabled="">Select Country</option>
									<?php foreach (getAllCountries() as $kkey => $country) : ?>
										<option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">State</label>
							<div class="uk-form-controls">
								<select name="stateId" class="uk-select" autocomplete="off" id="selectState">
									<option value="" selected="" disabled="">Select State</option>
								</select>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">City</label>
							<div class="uk-form-controls">
								<select name="cid" class="uk-select" autocomplete="off" id="selectCity">
									<option value="" selected="" disabled="">Select City</option>
								</select>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">PIN</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" name="pin" placeholder="PIN">
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">E-mail</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" name="email" placeholder="E-mail">
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Address </label>
							<div class="uk-form-controls">
								<textarea class="uk-textarea" rows="5" name="address" placeholder="Address"></textarea>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Whatsapp Number</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" name="wanumber" placeholder="Whatsapp Number">
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Mobile Number</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" name="monumber" placeholder="Mobile Number">
							</div>
						</div>
						<button class="uk-button uk-button-primary btn-all-page" id="rzp-button">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>