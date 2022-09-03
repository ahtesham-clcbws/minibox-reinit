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

<div class="uk-section-small uk-background-default">
	<div class="uk-container">
		<div class="uk-card uk-card-default uk-card-body">

			<form class="uk-grid-small" method="post" id="submitForm" uk-grid>

				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
					<label class="uk-form-label" for="form-horizontal-text">Name of the Volunteer</label>
					<div class="uk-form-controls">
						<input class="uk-input" type="text" name="name" placeholder="Name of the volunteer" required>
					</div>
				</div>
				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
					<label class="uk-form-label" for="form-horizontal-text">E-mail</label>
					<div class="uk-form-controls">
						<input class="uk-input" type="email" name="email" placeholder="E-mail" required>
					</div>
				</div>
				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
					<label class="uk-form-label" for="form-horizontal-text">Whatsapp Number</label>
					<div class="uk-form-controls">
						<input class="uk-input" type="tel" name="whatsapp" placeholder="Whatsapp Number" required>
					</div>
				</div>
				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
					<label class="uk-form-label" for="form-horizontal-text">Mobile Number</label>
					<div class="uk-form-controls">
						<input class="uk-input" type="tel" name="mobile" placeholder="Mobile Number" required>
					</div>
				</div>

				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
					<label class="uk-form-label" for="form-horizontal-text">Address </label>
					<div class="uk-form-controls">
						<input class="uk-input" name="address" placeholder="Address" required>
					</div>
				</div>
				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
					<label class="uk-form-label" for="form-horizontal-text">Country</label>
					<div class="uk-form-controls">
						<select name="country" class="uk-select" autocomplete="off" id="selectCountry" required>
							<option value="" selected="" disabled="">Select Country</option>
							<?php foreach (getAllCountries() as $kkey => $country) : ?>
								<option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
					<label class="uk-form-label" for="form-horizontal-text">State</label>
					<div class="uk-form-controls">
						<select name="state" class="uk-select" autocomplete="off" id="selectState" required>
							<option value="" selected="" disabled="">Select State</option>
						</select>
					</div>
				</div>
				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
					<label class="uk-form-label" for="form-horizontal-text">City</label>
					<div class="uk-form-controls">
						<select name="city" class="uk-select" autocomplete="off" id="selectCity" required>
							<option value="" selected="" disabled="">Select City</option>
						</select>
					</div>
				</div>
				<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
					<label class="uk-form-label" for="form-horizontal-text">PIN</label>
					<div class="uk-form-controls">
						<input class="uk-input" type="number" minlength="5" maxlength="7" name="pin" placeholder="PIN" required>
					</div>
				</div>
				<div class="uk-margin uk-width-1-1">
					<button class="uk-button uk-button-primary btn-all-page" id="rzp-button">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
	// alert('Success', 'Successfully logged in').then((result) => {
	// })
	$('#submitForm').submit(function(e) {
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		formData.append('submitVolunteer', 'true');
		console.log(Array.from(formData));
		// return;
		$.ajax({
			url: '',
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response, textStatus, jqXHR) {
				console.log(response);
				var data = {};
				try {
					data = JSON.parse(response);
					if (data.success == true) {
						alert('', data.message, 'success').then(() => {
							window.location.href = '<?= route_to('festival_details', $festivalSlug) ?>';
						});
					} else {
						alert(data.message, 'Error', 'error');
					}
				} catch (e) {
					console.log(e);
					alert('Undefined error, please try after some time.', 'Error', 'error');
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Server error', 'Error', 'error');
			},
		})
	})
</script>
<?= $this->endSection() ?>