<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('css') ?>
<?php if (isUserLogin() && getFilmEditAuth($movie['user_email'])) : ?>
	<style>
		#customLoader {
			display: block;
		}

		.active-2 {
			border: 5px solid #d8b069 !important;
		}

		.uk-checkbox:checked,
		.uk-radio:checked {
			background-color: #d8b069;
		}

		.uk-checkbox:checked:focus,
		.uk-radio:checked:focus {
			background-color: #d8b069;
		}

		.uk-radio-label {
			cursor: pointer;
		}

		.uk-input,
		.uk-select,
		.uk-textarea {
			background-color: #ffffff !important;
			box-shadow:
				5px 5px 10px rgba(0, 0, 0, 0.07),
				100px 100px 80px rgba(0, 0, 0, 0.035);
			/* box-shadow:
				12.5px 12.5px 10px rgba(0, 0, 0, 0.07),
				100px 100px 80px rgba(0, 0, 0, 0.035); */
		}

		.uk-input.disabled,
		.uk-select.disabled,
		.uk-textarea.disabled,
		.uk-input:disabled,
		.uk-select:disabled,
		.uk-textarea:disabled {
			background-color: #f5f5f5 !important;
			box-shadow: none;
			/* box-shadow:
				5px 5px 10px rgba(0, 0, 0, 0.07),
				100px 100px 80px rgba(0, 0, 0, 0.035); */

		}

		.uk-input:focus,
		.uk-select:focus,
		.uk-textarea:focus {
			box-shadow: none;
			/* box-shadow:
				5px 5px 10px rgba(0, 0, 0, 0.07),
				100px 100px 80px rgba(0, 0, 0, 0.035); */

		}

		.uk-input:not(input),
		.uk-select:not(input),
		.uk-textarea:not(input) {
			line-height: inherit;
			min-height: 47px;
		}

		.uk-form-controls .select2-selection {
			background-color: #ffffff !important;
			box-shadow:
				5px 5px 10px rgba(0, 0, 0, 0.07),
				100px 100px 80px rgba(0, 0, 0, 0.035);
		}

		.uk-subnav-pill>li>a {
			background-color: grey !important;
		}

		.uk-subnav-pill>.uk-active>a {
			background-color: #d8b069 !important;
			color: #fff !important;
		}
	</style>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (isUserLogin() && getFilmEditAuth($movie['user_email'])) : ?>
	<section class="about-section uk-section-small about-section-shadow" style="background-image:url(/public/images/pages-background.webp)">
		<div class="cover-shadow"></div>
		<div class="uk-container heading-section">
			<div class="uk-position-center">
				<h2><?= $pageName; ?></h2>
			</div>
		</div>
	</section>

	<div class="uk-section-small uk-background-default">
		<div class="uk-container">
			<div class="uk-card uk-card-default uk-card-body">
				<ul uk-tab="animation: uk-animation-fade" id="entryFormTitles">
					<li id="step1" class="<?= $openedStep == 'noSteps' ? 'uk-active' : ($openedStep == 'step1' ? 'uk-active' : '') ?>">
						<a href="#">Title & Details <span uk-icon="icon: <?= $movie['step1'] == 'open' ? 'file-edit' : ($movie['step1'] == 'completed' ? 'check' : 'lock') ?>"></span></a>
					</li>
					<li id="step2" class="<?= $openedStep == 'step2' ? 'uk-active' : '' ?>">
						<a href="#">Basic Info <span uk-icon="icon: <?= $movie['step2'] == 'open' ? 'file-edit' : ($movie['step2'] == 'completed' ? 'check' : 'lock') ?>"></span></a>
					</li>
					<li id="step3" class="<?= $openedStep == 'step3' ? 'uk-active' : '' ?>">
						<a href="#">Banner & Videos <span uk-icon="icon: <?= $movie['step3'] == 'open' ? 'file-edit' : ($movie['step3'] == 'completed' ? 'check' : 'lock') ?>"></span></a>
					</li>
					<li id="step4" class="<?= $openedStep == 'step4' ? 'uk-active' : '' ?>">
						<a href="#">Major Casts <span uk-icon="icon: <?= $movie['step4'] == 'open' ? 'file-edit' : ($movie['step4'] == 'completed' ? 'check' : 'lock') ?>"></span></a>
					</li>
					<li id="step5" class="<?= $openedStep == 'step5' ? 'uk-active' : '' ?>">
						<a href="#">Casts & Crews <span uk-icon="icon: <?= $movie['step5'] == 'open' ? 'file-edit' : ($movie['step5'] == 'completed' ? 'check' : 'lock') ?>"></span></a>
					</li>
					<li id="step6" class="<?= $openedStep == 'step6' ? 'uk-active' : '' ?>">
						<a href="#">Other Specs <span uk-icon="icon: <?= $movie['step6'] == 'open' ? 'file-edit' : ($movie['step6'] == 'completed' ? 'check' : 'lock') ?>"></span></a>
					</li>
				</ul>

				<ul class="uk-switcher uk-margin">
					<!-- Title & Some Details -->
					<li class="" id="step1Tab">
						<form id="step1Form" method="post">
							<div class="uk-grid-small" uk-grid>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="title">Movie Name / Title</label>
									<div class="uk-form-controls">
										<?php if (in_array('title', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['title'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Movie Name" value="<?= $movie['title'] ?>" name="title" id="title" required>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
									<label class="uk-form-label" for="project">Project Type</label>
									<div class="uk-form-controls">
										<div class="uk-input disabled"><?= $movie['project'] ?></div>
									</div>
								</div>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
									<label class="uk-form-label" for="film_status">Film Status</label>
									<div class="uk-form-controls">
										<?php if (in_array('film_status', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['film_status'] ?></div>
										<?php else : ?>
											<select name="film_status" class="uk-select select2" id="film_status" data-placeholder="Select film status" data-allow-clear="true" required>
												<option value="" selected="" disabled=""></option>
												<?php foreach (getFilmStatus() as $filmstatus) : ?>
													<option <?= $movie['film_status'] == $filmstatus['name'] ? 'selected' : '' ?> value="<?= $filmstatus['name'] ?>"><?= $filmstatus['name'] ?> (<?= $filmstatus['info'] ?>)</option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
									<label class="uk-form-label" for="year">Year <small><small>(Released / Completed)</small></small></label>
									<div class="uk-form-controls">
										<?php if (in_array('year', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['year'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="number" minlength="4" maxlength="4" min="1999" max="<?= date('Y') ?>" placeholder="Year" name="year" id="year" value="<?= $movie['year'] ?>" required>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
									<label class="uk-form-label" for="director">Country</label>
									<div class="uk-form-controls">
										<?php if (in_array('country', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= getWorldName($movie['country']) ?></div>
										<?php else : ?>
											<select name="country" class="uk-select select2" data-placeholder="Select Country" data-allow-clear="true" id="country" required>
												<option value="" selected="" disabled=""></option>
												<?php foreach (getAllCountries() as $kkey => $country) : ?>
													<option <?= $movie['country'] == $country['id'] ? 'selected' : '' ?> value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<hr>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
									<label class="uk-form-label" for="budget_currency">Budget Currency</label>
									<div class="uk-form-controls">
										<?php if (in_array('budget_currency', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['budget_currency'] ?></div>
										<?php else : ?>
											<select name="budget_currency" class="uk-select select2" data-placeholder="Select Currency" data-allow-clear="true" id="budget_currency" required>
												<option value="" selected="" disabled=""></option>
												<?php foreach ($currencies as $kkey => $budget_currency) : ?>
													<option <?= $movie['budget_currency'] == $budget_currency['value'] ? 'selected' : '' ?> value="<?= $budget_currency['value'] ?>"><?= $budget_currency['value'] ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
									<label class="uk-form-label" for="budget_amount">Budget</label>
									<div class="uk-form-controls">
										<?php if (in_array('budget_amount', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['budget_amount'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="number" placeholder="Budget Amount" value="<?= $movie['budget_amount'] ?>" name="budget_amount" id="budget_amount" required>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="">
								<button class="uk-button uk-button-primary btn-all-page" type="submit">Save & Continue</button>
							</div>

						</form>
					</li>
					<!-- Basic Info -->
					<li class="" id="step2Tab">
						<form id="step2Form" method="post">
							<div class="uk-grid-small" uk-grid>

								<div class="uk-margin uk-width-1-4@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="director">Director</label>
									<div class="uk-form-controls">
										<?php if (in_array('director', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['director'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Movie Name" value="<?= $movie['director'] ?>" name="director" id="director" required>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-4@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="production_company">Production Company</label>
									<div class="uk-form-controls">
										<?php if (in_array('production_company', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['production_company'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Movie Name" value="<?= $movie['production_company'] ?>" name="production_company" id="production_company" required>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-6@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="duration">Duration <small>(In Minutes)</small></label>
									<div class="uk-form-controls">
										<?php if (in_array('duration', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['duration'] ?> minutes / <small><?= getHoursFromMinutes($movie['duration']) ?></small></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Movie Name" value="<?= $movie['duration'] ?>" name="duration" id="duration" required>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-6@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="debut_film">Debut Film</label>
									<div class="uk-form-controls">
										<?php if (in_array('debut_film', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['debut_film'] ?></div>
										<?php else : ?>
											<select name="debut_film" class="uk-select select2" id="debut_film" data-placeholder="Select" data-allow-clear="true" required>
												<option value="" selected="" disabled=""></option>
												<option <?= $movie['debut_film'] == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
												<option <?= $movie['debut_film'] == 'No' ? 'selected' : '' ?> value="No">No</option>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-6@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="color">Color</label>
									<div class="uk-form-controls">
										<?php if (in_array('color', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['color'] == 'Yes' ? 'Color Film' : 'Black & White Film' ?></div>
										<?php else : ?>
											<select name="color" class="uk-select select2" id="color" data-placeholder="Select" data-allow-clear="true" required>
												<option value="" selected="" disabled=""></option>
												<option <?= $movie['color'] == 'Yes' ? 'selected' : '' ?> value="Yes">Color Film</option>
												<option <?= $movie['color'] == 'No' ? 'selected' : '' ?> value="No">Black & White</option>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-2@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="genres">Genres</label>
									<div class="uk-form-controls">
										<?php if (in_array('genres', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-input disabled">
												<?php foreach (json_decode($movie['genres']) as $key => $genre) : ?>
													<span class="commaAfter"><?= $genre ?></span>
												<?php endforeach; ?>
											</div>
										<?php else : ?>
											<select name="genres[]" multiple class="uk-select select2multiple" id="genres" data-placeholder="Select Genres" data-allow-clear="true" required>
												<?php foreach ($genres as $key => $genre) : ?>
													<option <?= in_array($genre['value'], json_decode($movie['genres'])) ? 'selected' : '' ?> value="<?= $genre['value'] ?>"><?= $genre['value'] ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-2@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="certificates">Certificates/Rating</label>
									<div class="uk-form-controls">
										<?php if (in_array('certificates', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-input disabled">
												<?php foreach (json_decode($movie['certificates']) as $key => $certificate) : ?>
													<span class="commaAfter"><?= $certificate ?></span>
												<?php endforeach; ?>
											</div>
										<?php else : ?>
											<select name="certificates[]" multiple class="uk-select select2multiple" id="certificates" data-placeholder="Select certificate" data-allow-clear="true" required>
												<?php foreach ($certificates as $key => $certificate) : ?>
													<option <?= in_array($certificate['value'], json_decode($movie['certificates'])) ? 'selected' : '' ?> value="<?= $certificate['value'] ?>"><?= $certificate['value'] ?></option>
												<?php endforeach; ?>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-2@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="synopsis">Synopsis</label>
									<div class="uk-form-controls">
										<?php if (in_array('synopsis', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-textarea disabled"><?= $movie['synopsis'] ?></div>
										<?php else : ?>
											<textarea class="uk-textarea" rows="5" placeholder="Synopsis" name="synopsis" id="synopsis"><?= $movie['synopsis'] ?></textarea>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-2@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="storyline">Storyline</label>
									<div class="uk-form-controls">
										<?php if (in_array('storyline', $disabledInputs) || $movie['step2'] == 'locked') : ?>
											<div class="uk-textarea disabled"><?= $movie['storyline'] ?></div>
										<?php else : ?>
											<textarea class="uk-textarea" rows="5" placeholder="Storyline" name="storyline" id="storyline"><?= $movie['storyline'] ?></textarea>
										<?php endif; ?>
									</div>
								</div>

							</div>
							<div class="">
								<button class="uk-button uk-button-primary btn-all-page" type="submit">Save & Continue</button>
							</div>

						</form>
					</li>
					<!-- Banner & Videos -->
					<li class="" id="step3Tab">
						<form id="step3Form" method="post">
							<div class="uk-grid-small" uk-grid>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="title">Movie Name / Title</label>
									<div class="uk-form-controls">
										<?php if (in_array('title', $disabledInputs) || $movie['step3'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['title'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Movie Name" value="<?= $movie['title'] ?>" name="title" id="title3" required>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="">
								<button class="uk-button uk-button-primary btn-all-page" type="submit">Save & Continue</button>
							</div>

						</form>
					</li>
					<!-- Major Casts -->
					<li class="" id="step4Tab">
						<form id="step4Form" method="post">
							<div class="uk-grid-small" uk-grid>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="title">Movie Name / Title</label>
									<div class="uk-form-controls">
										<?php if (in_array('title', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['title'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Movie Name" value="<?= $movie['title'] ?>" name="title" id="title4" required>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="">
								<button class="uk-button uk-button-primary btn-all-page" type="submit">Save & Continue</button>
							</div>

						</form>
					</li>
					<!-- Casts & Crews -->
					<li class="" id="step5Tab">
						<form id="step5Form" method="post">
							<div class="uk-grid-small" uk-grid>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="title">Movie Name / Title</label>
									<div class="uk-form-controls">
										<?php if (in_array('title', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['title'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Movie Name" value="<?= $movie['title'] ?>" name="title" id="title5" required>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="">
								<button class="uk-button uk-button-primary btn-all-page" type="submit">Save & Continue</button>
							</div>

						</form>
					</li>
					<!-- Other Specs -->
					<li class="" id="step6Tab">
						<form id="step6Form" method="post">
							<div class="uk-grid-small" uk-grid>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="title">Movie Name / Title</label>
									<div class="uk-form-controls">
										<?php if (in_array('title', $disabledInputs) || $movie['step1'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['title'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Movie Name" value="<?= $movie['title'] ?>" name="title" id="title6" required>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="">
								<button class="uk-button uk-button-primary btn-all-page" type="submit">Save & Continue</button>
							</div>

						</form>
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php else : ?>
	<div class="uk-section-small uk-section-default">
		<div class="uk-container">
			<h4 class="uk-heading-line uk-text-bold uk-text-center uk-animation-slide-bottom-medium">
				<span>
					Locked Movie Submission
				</span>
			</h4>
			<?php if (session()->get('authorizationWarning')) : ?>
				<div class="uk-width-1-1">
					<div class="uk-alert-danger uk-position-center" uk-alert style="max-width: 700px;">
						<a class="uk-alert-close" uk-close></a>
						<p>You are not authorized to Edit/Update this movie/tite.</p>
					</div>
				</div>
			<?php endif ?>

			<div class="gridlove-box box-inner-p-bigger entry-content">
				<form class="uk-form-horizontal SignupForm" id="SignupForm" action="" method="post">
					<input name="login" value="true" class="uk-invisible">
					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">Email Id</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="email" placeholder="Email Id" name="email">
						</div>
					</div>
					<div class="uk-margin">
						<label class="uk-form-label" for="form-horizontal-text">Password</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="password" placeholder="Password" name="password">
						</div>
					</div>
					<div class="uk-margin uk-text-center">
						<button type="submit" class="uk-button uk-button-primary btn-all-page">Continue</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php session()->remove('authorizationWarning') ?>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?php if (isUserLogin() && getFilmEditAuth($movie['user_email'])) : ?>
	<script>
		$(document).ready(function() {
			$('.select2multiple').select2();
		});
		$('#step1Form').submit(function(ev) {
			ev.preventDefault();
		});
		$('#step2Form').submit(function(ev) {
			ev.preventDefault();
		});
		$('#step3Form').submit(function(ev) {
			ev.preventDefault();
		});
		$('#step4Form').submit(function(ev) {
			ev.preventDefault();
		});
		$('#step5Form').submit(function(ev) {
			ev.preventDefault();
		});
		$('#step6Form').submit(function(ev) {
			ev.preventDefault();
		});
	</script>
<?php else : ?>
	<script>
		$('.SignupForm').submit(function(e) {
			e.preventDefault();
			// $.ajaxSetup({});
			var formData = new FormData($(this)[0]);
			console.log(Array.from(formData));
			$.ajax({
				url: '<?= route_to('login') ?>',
				type: 'post',
				contentType: false,
				processData: false,
				data: formData,
				success: function(response) {
					var data = JSON.parse(response);
					if (data.success) {
						var role = data.user_data.role;
						console.log(data);
						Toast.fire({
							icon: 'success',
							title: 'Signed in successfully'
						}).then((result) => {
							window.location.href = window.location.hash;
						})
						// alert('Success', 'Successfully logged in').then((result) => {
						// 	// location.reload();
						// 	window.location.href = window.location.hash;
						// })
					} else {
						var errorMessage = data.message ? data.message : 'Error logging in';
						alert('Error', errorMessage, 'error').then((result) => {
							// return locatop
						})
					}
				},
				error: function(error) {
					console.log(error);
					alert('Error', 'There is some error into the server. Please try again later.', 'error');
				},
			});
		})
	</script>
<?php endif; ?>
<script>
	$(window).bind("load", function() {
		stopLoader();
	});
</script>
<?= $this->endSection() ?>