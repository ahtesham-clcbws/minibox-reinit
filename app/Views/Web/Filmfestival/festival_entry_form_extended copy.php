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
		.uk-select select2,
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
		.uk-select select2.disabled,
		.uk-textarea.disabled,
		.uk-input:disabled,
		.uk-select select2:disabled,
		.uk-textarea:disabled {
			background-color: #f5f5f5 !important;
			box-shadow: none;
			/* box-shadow:
				5px 5px 10px rgba(0, 0, 0, 0.07),
				100px 100px 80px rgba(0, 0, 0, 0.035); */

		}

		.uk-input:focus,
		.uk-select select2:focus,
		.uk-textarea:focus {
			box-shadow: none;
			/* box-shadow:
				5px 5px 10px rgba(0, 0, 0, 0.07),
				100px 100px 80px rgba(0, 0, 0, 0.035); */

		}

		.uk-input:not(input),
		.uk-select select2:not(input),
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

		.uk-card:hover img {
			transform: none;
		}

		.submitButton {
			margin-top: 25px;
		}

		.previewBox {
			position: relative;
		}

		.previewBox input,
		.previewBox button {
			position: absolute;
			bottom: 5px;
			right: 5px;
		}

		.previewBox input {
			max-width: 235px;
			/* border-top-right-radius: 0;
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0; */
		}

		.winner-item {
			position: relative;
		}

		.winner-item .castIcon {
			position: absolute;
			top: 5px;
			right: 5px;
			padding: 5px;
			width: 17px;
			height: 17px;
			border-radius: 50%;
			background-color: #f0506e;
			color: #fff;
			margin: 0;
			text-align: center;
			padding-top: 6px;
			padding-bottom: 4px;
			cursor: pointer;
		}

		.winner-item .editIcon {
			right: 35px;
			background-color: #009cff;
		}

		#castAndCrewBlock li .uk-accordion-title {
			padding: 7px;
			background: #e6e6e6;
		}

		#castAndCrewBlock>:nth-child(n+2) {
			margin-top: 0;
			border-top: solid 1px rgb(205 205 205);
		}

		.uk-form-small.uk-select,
		.crew-input {
			box-shadow: inset 5px 5px 10px rgb(0 0 0 / 7%), inset 100px 100px 80px rgb(0 0 0 / 4%);
			border-radius: 8px;
			padding: 4px 15px !important;
			/* min-height: inherit !important; */
			min-height: 28px !important;
		}

		.uk-form-small.uk-select:focus,
		.crew-input:focus {
			box-shadow: 5px 5px 10px rgb(0 0 0 / 7%), 100px 100px 80px rgb(0 0 0 / 4%);
		}

		#castAndCrewBlock .uk-accordion-content {
			margin-top: 0;
			padding: 25px;
		}

		#castAndCrewBlock .uk-button-group button:first-child {
			border-top-left-radius: 8px;
			border-bottom-left-radius: 8px;
		}

		#castAndCrewBlock .uk-button-group button:last-child {
			border-top-right-radius: 8px;
			border-bottom-right-radius: 8px;
		}

		/* #castAndCrewBlock .crewIcon {
			width: 30px;
			height: 30px;
			border-radius: 50%;
			background-color: #f0506e;
			color: #000;
			margin: 0;
			text-align: center;
			cursor: pointer;
			line-height: 28px;
		}
		#castAndCrewBlock .editIcon {
			background-color: #009cff;
			color: #fff;
		} */
		#entryFormTitles li a span svg {
			margin-top: -4px;
		}

		.winner-cast-list .addNew .winner-profile {
			display: flex;
			align-items: center;
			color: #00350f;
			flex-direction: column;
			cursor: pointer;
		}

		.winner-cast-list .addNew,
		.winner-cast-list .addNew .addCastIcon {
			cursor: pointer;
		}

		.dataTables_filter .uk-form-small.uk-input {
			display: inline-block;
			width: max-content !important;
		}

		.dt-material.mdc-data-table {
			width: 100%;
		}

		.dt-material.mdc-data-table .pagination {
			margin: inherit !important;
			display: inherit !important;
			text-align: inherit !important;
		}
	</style>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (isUserLogin() && getFilmEditAuth($movie['user_email'])) : ?>
	<!-- major cast modal -->
	<div id="addMajorCastModal" class="uk-flex-top" uk-modal>
		<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<h2 class="uk-modal-title">Major Cast</h2>
		</div>
	</div>
	<!-- other information modal -->
	<div id="addOtherInfoModal" class="uk-flex-top" uk-modal>
		<form class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" id="addOtherInfoForm">
			<button class="uk-modal-close-default" type="button" uk-close></button>
			<h2 class="uk-modal-title">
				<span id="addInfoTitle">Add</span>
			</h2>
			<div class="uk-child-width-1-2@m" uk-grid>
				<div>
					<label class="uk-form-label">Name</label>
					<div class="uk-form-controls" id="nameInputBlock"></div>
				</div>
				<div>
					<label class="uk-form-label">Attribute <span id="attributeExtraText"></span></label>
					<div class="uk-form-controls" id="attributeInputBlock"></div>
				</div>
			</div>
			<input type="hidden" class="uk-hidden" value="0" name="id" id="infoIdInput">
			<input type="hidden" class="uk-hidden" value="" name="type" id="infoTypeInput">
			<div class="uk-width-1-1 uk-text-right">
				<button class="uk-button uk-button-danger submitButton" type="submit">Save</button>
			</div>
		</form>
	</div>
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
						<a href="#">Title & Details <?= getEntryFormHeaderIcon($movie['step1']) ?></a>
					</li>
					<li id="step2" class="<?= $openedStep == 'step2' ? 'uk-active' : '' ?>">
						<a href="#">Basic Info <?= getEntryFormHeaderIcon($movie['step2']) ?></a>
					</li>
					<li id="step3" class="<?= $openedStep == 'step3' ? 'uk-active' : '' ?>">
						<a href="#">Banner & Videos <?= getEntryFormHeaderIcon($movie['step3']) ?></a>
					</li>
					<li id="step4" class="<?= $openedStep == 'step4' ? 'uk-active' : '' ?>">
						<a href="#">Major Casts <?= getEntryFormHeaderIcon($movie['step4']) ?></a>
					</li>
					<li id="step5" class="<?= $openedStep == 'step5' ? 'uk-active' : '' ?>">
						<a href="#">Crews <?= getEntryFormHeaderIcon($movie['step5']) ?></a>
					</li>
					<li id="step6" class="<?= $openedStep == 'step6' ? 'uk-active' : '' ?>">
						<a href="#">Other Specs <?= getEntryFormHeaderIcon($movie['step6']) ?></a>
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
								<button class="uk-button uk-button-danger submitButton" type="submit">Save & Continue</button>
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
											<select name="genres[]" multiple class="uk-select select2 " id="genres" data-placeholder="Select Genres" data-allow-clear="true" required>
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
											<select name="certificates[]" multiple class="uk-select select2 " id="certificates" data-placeholder="Select certificate" data-allow-clear="true" required>
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
								<button class="uk-button uk-button-danger submitButton" type="submit">Save & Continue</button>
							</div>

						</form>
					</li>
					<!-- Banner & Videos -->
					<li class="" id="step3Tab">
						<form id="step3Form" method="post">

							<div class="uk-grid-small" uk-grid>
								<div class="uk-margin uk-width-1-4@m uk-width-1-1@s uk-margin-top previewBox">
									<?php if (in_array('poster', $disabledInputs) || $movie['step3'] == 'locked') : ?>
										<img src="<?= $movie['poster'] ? $movie['poster']  : '/public/images/movie-poster.png' ?>" class="uk-width-1-1 uk-height-1-1">
									<?php else : ?>
										<img src="/public/images/movie-poster.png" class="uk-width-1-1 uk-height-1-1" id="posterPreview">
										<input class="uk-input" type="file" name="poster" id="poster" onchange="imageRatioValidation('poster', 543, 362, 'posterPreview', '/public/images/movie-poster.png')">
									<?php endif; ?>
								</div>
								<div class="uk-margin uk-width-3-4@m uk-width-1-1@s uk-margin-top previewBox">
									<?php if (in_array('banner', $disabledInputs) || $movie['step3'] == 'locked') : ?>
										<img src="<?= $movie['banner'] ? $movie['banner']  : '/public/images/entry-form-banner.png' ?>" class="uk-width-1-1 uk-height-1-1">
									<?php else : ?>
										<img src="/public/images/entry-form-banner.png" class="uk-width-1-1 uk-height-1-1" id="bannerPreview">
										<input class="uk-input" type="file" name="banner" id="banner" onchange="imageRatioValidation('banner', 519, 1211, 'bannerPreview', '/public/images/entry-form-banner.png')">
									<?php endif; ?>
								</div>

								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="distribution">Distribution</label>
									<div class="uk-form-controls">
										<?php if (in_array('distribution', $disabledInputs) || $movie['step3'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['distribution'] ?></div>
										<?php else : ?>
											<select name="distribution" class="uk-select select2" id="distribution" data-placeholder="Select Distribution" data-allow-clear="true" required>
												<option value="" selected="" disabled=""></option>
												<option <?= $movie['distribution'] == 'Available' ? 'selected' : '' ?> value="Available">Available</option>
												<option <?= $movie['distribution'] == 'Un-Available' ? 'selected' : '' ?> value="Un-Available">Un-Available</option>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="trailer_type">Trailer From</label>
									<div class="uk-form-controls">
										<?php if (in_array('trailer', $disabledInputs) || $movie['step3'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['trailer_type'] ?></div>
										<?php else : ?>
											<select name="trailer_type" class="uk-select select2" id="trailer_type" data-placeholder="Select Type" data-allow-clear="true" required>
												<option value="" selected="" disabled=""></option>
												<option <?= $movie['trailer_type'] == 'youtube' ? 'selected' : '' ?> value="youtube">YouTube</option>
												<option <?= $movie['trailer_type'] == 'vimeo' ? 'selected' : '' ?> value="vimeo">Vimeo</option>
											</select>
										<?php endif; ?>
									</div>
								</div>
								<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
									<label class="uk-form-label" for="trailer">Trailer ID</label>
									<div class="uk-form-controls">
										<?php if (in_array('trailer', $disabledInputs) || $movie['step3'] == 'locked') : ?>
											<div class="uk-input disabled"><?= $movie['trailer'] ?></div>
										<?php else : ?>
											<input class="uk-input" type="text" placeholder="Trailer ID" onchange="parseVideoUrl()" maxlength="200" value="<?= $movie['trailer'] ?>" name="trailer" id="trailer" required>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="">
								<button class="uk-button uk-button-danger submitButton" type="submit">Save & Continue</button>
							</div>

						</form>
					</li>
					<!-- Major Casts -->
					<li class="" id="step4Tab">
						<form id="step4Form" method="post">
							<div class="winner-cast-list uk-grid-small uk-child-width-1-4@s" uk-grid="">

								<div>
									<div class="winner-item">
										<div class="winner-profile">
											<div class="winner-photo">
												<img width="100" height="100" src="/public/images/cast-1.webp" class="attachment-noxe-thumbnail-2 size-noxe-thumbnail-2 winner-lazy-load loaded" alt="crew4 name" loading="lazy" data-ll-status="loaded">
											</div>
											<div class="winner-title">
												<span class="winner-subtitle">Actor</span>
												<span class="winner-name">crew4 name</span>
											</div>
										</div>
										<span class="castIcon editIcon text-primary" uk-icon="icon: file-edit; ratio: 0.7"></span>
										<span class="castIcon deleteIcon text-danger" uk-icon="icon: trash; ratio: 0.7"></span>
									</div>
								</div>

								<div>
									<div class="winner-item addNew" uk-toggle="target: #addMajorCastModal">
										<div class="winner-profile">
											<span class="addCastIcon" uk-icon="icon: plus-circle; ratio: 3.3"></span>
										</div>
									</div>
								</div>

							</div>
							<div class="">
								<button class="uk-button uk-button-danger submitButton" type="submit">Submit for review & Continue</button>
							</div>

						</form>
					</li>
					<!-- Crews (producers / writers / composers / cinematographers / editors) -->
					<li class="" id="step5Tab">
						<form id="step5Form" method="post">
							<ul uk-accordion="multiple: true;" id="castAndCrewBlock">

								<li class="uk-open">
									<a class="uk-accordion-title" href="#">Producers</a>
									<div class="uk-accordion-content">
										<table class="movieInfoTable" dataType="producers" id="producersTable">
											<thead>
												<tr>
													<th></th>
													<th>Name</th>
													<th>Occupation (Attribute)</th>
													<th class="uk-text-right uk-width-small">
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</li>

								<li class="uk-open">
									<a class="uk-accordion-title" href="#">Writers</a>
									<div class="uk-accordion-content">
										<table class="movieInfoTable mdl-data-table" dataType="writers" id="writersTable">
											<thead>
												<tr>
													<th></th>
													<th>Name</th>
													<th>Attribute</th>
													<th class="uk-text-right uk-width-small">
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</li>

								<li class="uk-open">
									<a class="uk-accordion-title" href="#">Composers</a>
									<div class="uk-accordion-content">
										<table class="movieInfoTable mdl-data-table" dataType="composers" id="composersTable">
											<thead>
												<tr>
													<th></th>
													<th>Name</th>
													<th>Attribute (usually empty)</th>
													<th class="uk-text-right uk-width-small">
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</li>

								<li class="uk-open">
									<a class="uk-accordion-title" href="#">Cinematographers</a>
									<div class="uk-accordion-content">
										<table class="movieInfoTable mdl-data-table" dataType="cinematographers" id="cinematographersTable">
											<thead>
												<tr>
													<th></th>
													<th>Name</th>
													<th>Attribute (usually empty)</th>
													<th class="uk-text-right uk-width-small">
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</li>

								<li class="uk-open">
									<a class="uk-accordion-title" href="#">Editors</a>
									<div class="uk-accordion-content">
										<table class="movieInfoTable mdl-data-table" dataType="editors" id="editorsTable">
											<thead>
												<tr>
													<th></th>
													<th>Name</th>
													<th>Attribute (usually empty)</th>
													<th class="uk-text-right uk-width-small">
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</li>

							</ul>
							<div class="">
								<button class="uk-button uk-button-danger submitButton" type="submit">Submit for review & Continue</button>
							</div>

						</form>
					</li>
					<!-- Other Specs (sound mix / aspect ratio / languages) -->
					<li class="" id="step6Tab">
						<form id="step6Form" method="post">
							<ul uk-accordion="multiple: true;" id="castAndCrewBlock">

								<li class="uk-open">
									<a class="uk-accordion-title" href="#">Sound Mix</a>
									<div class="uk-accordion-content">
										<table class="movieInfoTable mdl-data-table" dataType="sound_mix" id="sound_mixTable">
											<thead>
												<tr>
													<th></th>
													<th>Name</th>
													<th>Attribute</th>
													<th class="uk-text-right uk-width-small">
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</li>

								<li class="uk-open">
									<a class="uk-accordion-title" href="#">Aspect Ratio</a>
									<div class="uk-accordion-content">
										<table class="movieInfoTable mdl-data-table" dataType="aspect_ratio" id="aspect_rationTable">
											<thead>
												<tr>
													<th></th>
													<th>Name</th>
													<th>Attribute</th>
													<th class="uk-text-right uk-width-small">
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</li>

								<li class="uk-open">
									<a class="uk-accordion-title" href="#">Languages <small>(All languages used in this film)</small></a>
									<div class="uk-accordion-content">
										<table class="movieInfoTable mdl-data-table" dataType="languages" id="languagesTable">
											<thead>
												<tr>
													<th></th>
													<th>Name</th>
													<th>Attribute</th>
													<th class="uk-text-right uk-width-small">
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</li>

							</ul>
							<div class="">
								<button class="uk-button uk-button-danger submitButton" type="submit">Submit for Review</button>
							</div>

						</form>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- test table -->

	<!-- <table class="movieInfoTable" dataType="languages" id="languagesTable">
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<th>Attribute</th>
				<th class="uk-text-right uk-width-small">
					<div class="uk-button-group">
						<button class="uk-button uk-button-primary uk-button-small" title="Add another"><span uk-icon="icon: plus-circle;"></span></button>
					</div>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>
				</td>
				<td>
					<div class="crew-input uk-input"></div>
				</td>
				<td class="uk-text-right uk-width-small">
					<div class="uk-button-group">
						<button class="uk-button uk-button-secondary uk-button-small" title="Remove This"><span uk-icon="icon: file-edit;"></span></button>
						<button class="uk-button uk-button-danger uk-button-small" title="Remove This"><span uk-icon="icon: trash;"></span></button>
					</div>
				</td>
			</tr>
		</tbody> -->
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
	<link rel="stylesheet" type="text/css" href="/public/libs/DataTables/datatables.min.css" media="all">
	<!-- <link rel="stylesheet" type="text/css" href="/public/libs/DataTables/dataTables.uikit.min.css" media="all"> -->
	<link rel="stylesheet" type="text/css" href="/public/libs/material-components-web.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="/public/libs/DataTables/dataTables.material.min.css" media="all">
	<!-- <link rel="stylesheet" type="text/css" href="/public/libs/DataTables/dataTables.bootstrap5.min.css" media="all"> -->
	<script type="text/javascript" src="/public/libs/DataTables/datatables.min.js"></script>
	<script type="text/javascript" src="/public/libs/DataTables/dataTables.material.min.js"></script>
	<!-- <script type="text/javascript" src="/public/libs/DataTables/dataTables.uikit.min.js"></script> -->
	<!-- <script type="text/javascript" src="/public/libs/DataTables/dataTables.bootstrap5.min.js"></script> -->
	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});
	</script>
	<!-- datatables functions: create, reload and others -->
	<script>
		function createDataTable(tableId, tableType) {
			// const tableName = tableId+tableType;
			var myTable = new DataTable('#' + tableId, {
				paging: true,
				pagingType: 'first_last_numbers',
				ordering: false,
				// "bFilter": false,
				// dom: dom_normal,
				// lengthChange: false,
				fixedHeader: true,
				lengthMenu: [
					[5, 10, 15, 20, -1],
					[5, 10, 15, 20, "Show All"]
				],
				autoWidth: false,
				columnDefs: [{
					targets: ['_all'],
					className: 'mdc-data-table__cell',
				}],
				bProcessing: true,
				serverSide: true,
				ajax: {
					url: "", // json datasource
					type: "post",
					data: {
						order: [{
							dir: 'desc'
						}],
						other_info_data: tableType
					},
					deferRender: true,
				},
				columns: [{
						"title": "#",
						render: function(data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1;
						}
					},

					{
						data: "name",
						name: "name",
						className: "nk-tb-col tb-col-md",
					},
					{
						data: "attribute",
						name: "attribute",
						className: "nk-tb-col tb-col-md",
					},
					{
						data: "actions",
						name: "actions",
						className: "nk-tb-col tb-col-md",
					}
				],
				fnInitComplete: function(oSettings, json) {
					datatableCustomButtons(tableId, tableType);
				}
			});
		}

		function tableReload(tableId) {
			// $('#' + tableId).DataTable().ajax.reload(null, false);
			$('#' + tableId).DataTable().ajax.reload();
		}
	</script>
	<!-- datatables -->
	<script>
		var movieInfoTables = $('.movieInfoTable');
		movieInfoTables.each(function() {
			var tableId = $(this).attr('id');
			var tableType = $(this).attr('dataType');
			createDataTable(tableId, tableType);
		});

		function datatableCustomButtons(tableId, tableType) {
			// console.log(tableId)
			var tableButtons = document.getElementById(tableId + '_filter');
			// console.log(tableButtons)
			var button = document.createElement('button');

			var icon = document.createElement('span');
			// icon.classList.add('text-danger');
			// icon.style.fontSize = '18px';
			// icon.classList.add('ni');
			// icon.classList.add('ni-trash-fill');
			icon.setAttribute('uk-icon', 'plus-circle');

			button.setAttribute('type', 'button');
			button.setAttribute('id', 'deleteButton');
			button.setAttribute('onclick', 'addInfoItem("' + tableType + '")');

			button.classList.add('btn');
			// button.classList.add('btn-sm');

			button.classList.add('mdc-button');
			button.classList.add('mdc-button--raised');
			button.classList.add('mdc-button--primary');
			button.classList.add('uk-margin-right');

			button.setAttribute('type', 'submit');
			button.setAttribute('title', 'Add ' + tableType);
			button.setAttribute('tabindex', '0');
			button.setAttribute('aria-controls', 'datatable');
			button.appendChild(icon);
			tableButtons.prepend(button);
		}
	</script>
	<!-- imageRatioValidation / parseVideoUrl / add-remove-update & submit (InfoItem) -->
	<script>
		async function imageRatioValidation(inputId, maxHeight, maxWidth, previewId = null, defaultImage) {
			let validated = true;
			var fileUpload = $("#" + inputId)[0];
			// var fileUpload = event.target;
			var regex = new RegExp(/\.(jpe?g|png|bmp)$/i);
			if (regex.test(fileUpload.value.toLowerCase())) {
				//Check whether HTML5 is supported.
				if (typeof(fileUpload.files) != "undefined") {
					//Initiate the FileReader object.
					var reader = new FileReader();
					//Read the contents of Image File.
					reader.readAsDataURL(fileUpload.files[0]);
					reader.onload = function(e) {
						//Initiate the JavaScript Image object.
						var image = new Image();
						//Set the Base64 string return from FileReader as source.
						image.src = e.target.result;
						image.onload = function await () {
							//Determine the Height and Width.
							var height = this.height;
							// console.log(height);
							var width = this.width;
							// console.log(width);

							// console.log('this');
							// console.log(this.src);

							if (height < maxHeight || width < maxWidth) {
								alert('', "Height and Width must be minimum " + maxHeight + 'x' + maxWidth + " pixels", 'error');
								validated = false;

								resetImageInput(inputId);
							} else {
								// ratio calculation
								const ratio = parseFloat(maxHeight > maxWidth ? maxHeight / maxWidth : maxWidth / maxHeight).toFixed(2);
								// console.log('ratio ', ratio);
								const newRatio = parseFloat(height > width ? height / width : width / height).toFixed(2);
								// console.log('newRatio ', newRatio);
								// ratio calculation
								if (numberToFloat(ratio) === numberToFloat(newRatio)) {
									// previewImage(event, previewId);
									$('#' + previewId).attr('src', this.src);
								} else {
									alert('', "Please maintain the aspect ratio of the image, it will be minimum size of " + maxHeight + 'x' + maxWidth + " pixels", 'error');
									validated = false;
									$('#' + previewId).attr('src', defaultImage);

									resetImageInput(inputId);
								}
							}

						};
					}
				} else {
					alert('', "This browser does not support HTML5.", 'error');
					validated = false;
					resetImageInput(inputId);
				}
			} else {
				alert('', "Please select a valid Image file.", 'error');
				validated = false;
				resetImageInput(inputId);
			}
			if (!validated) {
				resetImageInput(inputId);
			}
			return validated;
		}
		const trailer_url = $('#trailer');
		const trailer_type = $('#trailer_type');

		function parseVideoUrl() {
			var urltype = trailer_type.val();
			if (urltype) {
				var videoId = videoUrlGetID(urltype);
				trailer_url.val(videoId);
			} else {
				alert('', 'Please select where id trailer hosted, On Youtube or Vimeo?. Before adding trailer link.', 'warning');
				trailer_url.val('');
			}
		}

		function videoUrlGetID(type) {
			var getId = null;
			var url = trailer_url.val();
			if (type == 'youtube') {
				getId = youtube_parser(url);
			} else {
				getId = vimeo_parser(url);
			}
			// console.log(getId);
			return getId;
		}

		var nameInputBlock = $('#nameInputBlock'),
			attributeInputBlock = $('#attributeInputBlock'),
			attributeExtraText = $('#attributeExtraText'),
			infoIdInput = $('#infoIdInput'),
			infoTypeInput = $('#infoTypeInput'),
			defaultNameValue = null,
			defaultAttrValue = null;

		function addInfoItem(type, edit = false, itemId = 0, ItemName = null, itemAttr = null) {
			$('#addInfoTitle').html('Add');
			infoTypeInput.val(type);
			attributeExtraText.html('');

			if (edit) {
				infoIdInput.val(itemId);
				defaultNameValue = ItemName;
				defaultAttrValue = itemAttr;
			} else {
				infoIdInput.val(0);
				defaultNameValue = null;
				defaultAttrValue = null;
			}

			if (type === 'producers') {
				$('#addInfoTitle').html('Add Producer');

				$.ajax({
					url: '',
					data: {
						get_producers_type_data: 'get_producers_type_data'
					},
					type: 'post',
					success: function(response) {
						// console.log(response);
						let selectListOption = [];
						var parsedResponse = JSON.parse(response);
						var responseData = parsedResponse.data

						var input = getInput(['crew-input', 'uk-input'], [{
							value: 'text',
							name: 'type'
						}, {
							value: 'name',
							name: 'name'
						}, {
							value: 'required',
							name: 'required'
						}], defaultNameValue);
						nameInputBlock.html(input);
						responseData.forEach(list => {
							let optionData = {
								value: list.value,
								text: list.value
							};
							selectListOption.push(optionData);
						});
						var selectInput = getSelectInput(['crew-input', 'uk-select'], [{
							value: 'attribute',
							name: 'name'
						}, {
							value: 'required',
							name: 'required'
						}, {
							value: 'producers_type',
							name: 'id'
						}], selectListOption, defaultAttrValue);
						attributeInputBlock.html(selectInput);

						UIkit.modal('#addOtherInfoModal').show();
					}
				})
			}
			if (type === 'writers' || type === 'composers' || type === 'cinematographers' || type === 'editors') {
				var title = type === 'writers' ? 'Writer' : (type === 'composers' ? 'Composer' : (type === 'cinematographers' ? 'Cinematographer' : (type === 'editors' ? 'Editor' : '')));
				$('#addInfoTitle').html('Add ' + title);
				attributeExtraText.html('(usually empty)');
				var nameInput = getInput(['crew-input', 'uk-input'], [{
					value: 'text',
					name: 'type'
				}, {
					value: 'name',
					name: 'name'
				}, {
					value: 'required',
					name: 'required'
				}], defaultNameValue);
				nameInputBlock.html(nameInput);
				var attrInput = getInput(['crew-input', 'uk-input'], [{
					value: 'text',
					name: 'type'
				}, {
					value: 'attribute',
					name: 'name'
				}], defaultAttrValue);
				attributeInputBlock.html(attrInput);
				UIkit.modal('#addOtherInfoModal').show();
			}
			if (type === 'sound_mix') {
				$('#addInfoTitle').html('Add Sound Mix');

				$.ajax({
					url: '',
					data: {
						get_sound_mix_data: 'get_sound_mix_data'
					},
					type: 'post',
					success: function(response) {
						// console.log(response);
						var parsedResponse = JSON.parse(response);
						var soundMixData = parsedResponse.data.sound_mixs
						var soundMixAttrData = parsedResponse.data.sound_mix_attributes

						let selectListOption = [];
						soundMixData.forEach(list => {
							let optionData = {
								value: list.value,
								text: list.value
							};
							selectListOption.push(optionData);
						});
						var selectInput1 = getSelectInput(['crew-input', 'uk-select'], [{
							value: 'name',
							name: 'name'
						}, {
							value: 'required',
							name: 'required'
						}, {
							value: 'sounds_list',
							name: 'id'
						}], selectListOption, defaultNameValue);
						nameInputBlock.html(selectInput1);

						// $('#sounds_list').select2();

						selectListOption = [];
						soundMixAttrData.forEach(list => {
							let optionData = {
								value: list.value,
								text: list.value
							};
							selectListOption.push(optionData);
						});
						var selectInput = getSelectInput(['crew-input', 'uk-select'], [{
							value: 'attribute',
							name: 'name'
						}, {
							value: 'sounds_list_attribute',
							name: 'id'
						}], selectListOption, defaultAttrValue);
						attributeInputBlock.html(selectInput);

						// $('#sounds_list_attribute').select2();

						UIkit.modal('#addOtherInfoModal').show();
					}
				})
			}
			if (type === 'aspect_ratio') {
				$('#addInfoTitle').html('Add Aspect Ratio');

				$.ajax({
					url: '',
					data: {
						get_aspect_ratio_data: 'get_aspect_ratio_data'
					},
					type: 'post',
					success: function(response) {
						// console.log(response);
						let selectListOption = [];
						var parsedResponse = JSON.parse(response);
						var responseData = parsedResponse.data
						responseData.forEach(list => {
							let optionData = {
								value: list.value,
								text: list.value
							};
							selectListOption.push(optionData);
						});
						var selectInput = getSelectInput(['crew-input', 'uk-select'], [{
							value: 'name',
							name: 'name'
						}, {
							value: 'required',
							name: 'required'
						}, {
							value: 'aspect_ratio_list',
							name: 'id'
						}], selectListOption, defaultNameValue);
						nameInputBlock.html(selectInput);

						var input = getInput(['crew-input', 'uk-input'], [{
							value: 'text',
							name: 'type'
						}, {
							value: 'attribute',
							name: 'name'
						}], defaultAttrValue);
						attributeInputBlock.html(input);
						// $('#aspect_ratio_list').select2();

						UIkit.modal('#addOtherInfoModal').show();
					}
				})
			}
			if (type === 'languages') {
				$('#addInfoTitle').html('Add Language');
				let selectListOption = [];

				const allLanguages = JSON.parse('<?= json_encode(getLanguages()) ?>');

				allLanguages.forEach(list => {
					let optionData = {
						value: list.name,
						text: list.name
					};
					selectListOption.push(optionData);
				});

				var selectInput = getSelectInput(['crew-input', 'uk-select'], [{
					value: 'name',
					name: 'name'
				}, {
					value: 'required',
					name: 'required'
				}, {
					value: 'languages_selection',
					name: 'id'
				}], selectListOption, defaultNameValue);
				nameInputBlock.html(selectInput);
				// $('#languages_selection').select2();

				var input = getInput(['crew-input', 'uk-input'], [{
					value: 'text',
					name: 'type'
				}, {
					value: 'attribute',
					name: 'name'
				}], defaultAttrValue);
				attributeInputBlock.html(input);

				UIkit.modal('#addOtherInfoModal').show();
			}
		}

		function deleteInfoItem(type, id) {
			var tableId = type + 'Table';

			var nameOfTheEntity = ''
			if (type === 'producers' || type === 'writers' || type === 'composers' || type === 'cinematographers' || type === 'editors' || type === 'languages') {
				nameOfTheEntity = type.toUpperCase();
			}
			if (type === 'sound_mix') {
				nameOfTheEntity = 'SOUND MIX';
			}
			if (type === 'aspect_ratio') {
				nameOfTheEntity = 'ASPECT RATIO';
			}

			alert('This action will not revert back, as it will delete the item from your (' + nameOfTheEntity + ') list.', 'Are you sure!', 'warning', 'text', 'Yes', true).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: '',
						type: 'post',
						// contentType: false,
						// processData: false,
						data: {
							deleteMovieData: id
						},
						success: function(response) {
							var data = JSON.parse(response);
							if (data.success) {
								// console.log(data);
								Toast.fire({
									icon: 'success',
									title: 'Deleted Successfully'
								});
							} else {
								var errorMessage = data.message ? data.message : 'Error logging in';
								alert('Error', errorMessage, 'error').then((result) => {})
							}
						},
						error: function(error) {
							console.log(error);
							alert('Error', 'There is some error into the server. Please try again later.', 'error');
						},
						complete: function(response) {
							setTimeout(() => {
								tableReload(tableId);
								setTimeout(() => {
									stopLoader();
								}, 250);
							}, 250);
						}
					});
				} else {
					Toast.fire({
						icon: 'success',
						title: 'Good choice! You saved a day'
					});
				}
			})

		}

		function getInput(classes, attributes, defaultValue = null) {
			var input = document.createElement('input');
			classes.forEach(elClass => {
				input.classList.add(elClass);
			});
			attributes.forEach(attr => {
				input.setAttribute(attr.name, attr.value);
			});
			if (defaultValue) {
				input.setAttribute('value', defaultValue);
			}
			return input;
		}

		function getSelectInput(classes, attributes, optionsList, defaultValue = null) {
			// console.log(attributes);
			var select = document.createElement('select');
			classes.forEach(elClass => {
				select.classList.add(elClass);
			});
			attributes.forEach(attribute => {
				select.setAttribute(attribute.name, attribute.value);
			});
			// select.setAttribute('autocomplete', 'new_');
			let option = document.createElement("option");
			option.value = '';
			option.text = '';
			select.add(option, null);
			optionsList.forEach(opt => {
				let option = document.createElement("option");
				option.value = opt.value;
				option.text = opt.text;
				if (defaultValue && defaultValue == opt.value) {
					option.setAttribute('selected', 'selected');
				}
				select.add(option);
			});
			return select;
		}

		$('#addOtherInfoForm').submit(function(ev) {
			startLoader();
			ev.preventDefault();
			var formData = new FormData($(this)[0]);
			// console.log(Array.from(formData));
			formData.append('addMovieData', 'other');
			var tableId = formData.get('type') + 'Table';
			// console.log(formData.get('type'));
			// return;
			$.ajax({
				url: '',
				type: 'post',
				contentType: false,
				processData: false,
				data: formData,
				success: function(response) {
					var data = JSON.parse(response);
					if (data.success) {
						// console.log(data);
						Toast.fire({
							icon: 'success',
							title: 'Added Successfully'
						});
					} else {
						var errorMessage = data.message ? data.message : 'Error logging in';
						alert('Error', errorMessage, 'error').then((result) => {})
					}
				},
				error: function(error) {
					console.log(error);
					alert('Error', 'There is some error into the server. Please try again later.', 'error');
				},
				complete: function(response) {
					setTimeout(() => {
						tableReload(tableId);
						setTimeout(() => {
							UIkit.modal('#addOtherInfoModal').hide();
							setTimeout(() => {
								stopLoader();
							}, 250);
						}, 250);
					}, 250);
				}
			});
		})
		UIkit.util.on('#addOtherInfoModal', 'hide', function() {
			nameInputBlock.html('');
			attributeInputBlock.html('');
			$('#infoIdInput').val(0);
			$('#infoTypeInput').val('');
		})
	</script>
	<script>
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
						startLoader();
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
	if (document.readyState == 'complete') {
		stopLoader();
	} else {
		document.onreadystatechange = function() {
			if (document.readyState === "complete") {
				stopLoader();
			}
		}
	}
</script>
<?= $this->endSection() ?>

<!-- Classic Ratio (2:3) Horizontall -->
<!-- maximum -->
<!-- 562x843 -->
<!-- minimum -->
<!-- 362x543 -->
<!-- Cinemascope Ratio (21:9) -->
<!-- maximum -->
<!-- 1407x603 -->
<!-- minimum -->
<!-- 1211x519 -->