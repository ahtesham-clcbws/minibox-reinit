<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('content') ?>
<style>
	.active-2 {
		border: 5px solid #d8b069 !important;
	}

	.deadline:hover {
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

	.deadlinesBlocks:not(:last-child) {
		border-right: 1px solid #e5e5e5;
	}

	.projectTypeDiv {
		padding: 0 25px;
	}

	@media only screen and (max-width: 956px) {
		.projectTypeDiv {
			padding: 0;
		}

		.deadlinesBlocks:not(:last-child) {
			border-right: none;
			border-bottom: 1px solid #e5e5e5;
			padding-bottom: 15px;
			margin-bottom: 15px;
		}
	}

	.plan-item-wrap .plan-content {
		text-align: left;
	}

	.plan-item-wrap:hover .uk-checkbox:checked,
	.plan-item-wrap:hover .uk-radio:checked {
		background-color: #3d3d3d;
	}

	/* #chooseAwardsDiv {
		display: none;
	} */
</style>
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
			<?php if ($festival_details['deadlines']['show']['id'] == 'opening_date') : ?>
				<h2>
					Entries Not started yet!<br />
					Please came after <?= date('F d, Y', strtotime($festival_details['deadlines']['show']['deadline'])) ?>
				</h2>
			<?php elseif ($festival_details['deadlines']['show']['id'] == 'event_date') : ?>
				<h2>
					New Entries is Over,<br />
					Please Wait for next festival.
				</h2>
			<?php else : ?>
				<form id="awardSelectionForm" method="post">
					<!-- Personal Details -->
					<h4>Personal Details</h4>
					<div class="uk-grid-small" uk-grid>
						<div class="uk-margin uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s uk-margin-top">
							<label class="uk-form-label" for="submitter_name">Submitter Name</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Submitter Name" name="submitter_name" id="submitter_name">
							</div>
						</div>
						<div class="uk-margin uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="email_id">Email Id</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="email" placeholder="Email Id" name="email_id" id="email_id">
							</div>
						</div>
						<div class="uk-margin uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="hormobileizontal">Mobile </label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Mobile" name="mobile" id="mobile">
							</div>
						</div>
						<div class="uk-margin uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="country">Country</label>
							<div class="uk-form-controls">
								<select name="country" class="uk-select" autocomplete="off" id="country" required>
									<option value="" selected="" disabled="">Select Country</option>
									<?php foreach (getAllCountries() as $kkey => $country) : ?>
										<option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<!-- Movie Details -->
					<h4>Movie Details</h4>
					<div class="uk-grid-small" uk-grid>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
							<label class="uk-form-label" for="movie_name">Movie Name</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Movie Name" name="movie_name" id="movie_name">
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="director">Director</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Director" name="director" id="director">
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="movie_preview_link">Movie preview link</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="vimeo, google drive, youtube etc | optional" name="movie_preview_link" id="movie_preview_link">
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="password">Password</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="if any | optional" name="password" id="password">
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="producer">Producer</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Producer" name="producer" id="producer">
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="production_company">Production Company </label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="write independent incase no company " name="production_company" id="production_company">
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="duration">Duration</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Duration " name="duration" id="duration">
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="debut_film">Is this your Debut film</label>
							<div class="uk-form-controls">
								<select name="debut_film" class="uk-select" autocomplete="off" id="debut_film" required>
									<option value="" selected="" disabled=""></option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="language">Language </label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Language " name="language" id="language">
							</div>
						</div>
						<div class="uk-margin uk-width-1-1">
							<label class="uk-form-label" for="synopsis">Synopsis</label>
							<div class="uk-form-controls">
								<textarea class="uk-textarea" rows="5" placeholder="Synopsis" name="synopsis" id="synopsis"></textarea>
							</div>
						</div>
					</div>
					<hr>
					<!-- Project Type -->
					<div class="uk-grid-collapse uk-child-width-1-3@m uk-width-1-1" uk-grid>
						<div class="deadlinesBlocks">
							<h4>Occupation</h4>
							<div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
								<b>You are ! </b>
								<label class="uk-radio-label"><input class="uk-radio" type="radio" name="occupation" value="professional" required> Professional</label>
								<label class="uk-radio-label"><input class="uk-radio" type="radio" name="occupation" value="student" required> Student</label>
							</div>
						</div>
						<div class="deadlinesBlocks projectTypeDiv">
							<label class="uk-form-label">Select Project</label>
							<div class="uk-form-controls uk-width-1-1">
								<select class="uk-select uk-width-1-1" name="project" id="selectProjectType">
									<option selected="" value="" disabled="">Select type of Project</option>
									<?php foreach ($allProjectTypes as $key => $projectType) : ?>
										<?php if (in_array($projectType['id'], $festival_details['project_types']) && in_array($projectType['type'], $typesOfAwards)) : ?>
											<option value="<?= $projectType['id'] ?>" data_type="<?= $projectType['type'] ?>"><?= $projectType['name'] ?></option>
										<?php endif; ?>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="deadlinesBlocks">
							<div class="uk-width-1-1 uk-text-right@m">
								<h4 class="uk-margin-remove" style="color: #d8b069;"><?= $festival_details['deadlines']['show']['name'] ?> - <?= date('d F, Y', strtotime($festival_details['deadlines']['show']['deadline'])) ?></h4>
								<a uk-toggle="target: #festivalDeadlineCanvasContainer" href="#">View All Dates</a>
							</div>
						</div>
					</div>
					<div class="uk-margin-top" id="chooseAwardsDiv">
						<div class="strip-set">
							<p>Select Awards</p>
						</div>

						<?php if ($festival_details['short_awards']) : ?>
							<div uk-grid class="uk-grid-collapse" id="ShortAwardsDiv">
								<?php foreach ($festival_details['short_awards_prices'] as $key => $awardType) : ?>
									<?php if ($awardType['award_count'] > 0) : ?>
										<div class="uk-width-1-4 plan-item-wrap" key="<?= $key ?>">
											<input class="uk-hidden" hidden id="awardPriceType<?= $key ?>" value="" name="award[short][<?= $key ?>][currency]">
											<input class="uk-hidden" hidden id="" value="" name="">
											<input class="uk-hidden" hidden value="<?= $awardType['award_id'] ?>" id="awardId<?= $key ?>" name="award[short][<?= $key ?>][award_id]">
											<input class="uk-hidden" hidden type="radio" value="yes" id="awardIdRadio" name="award[short][<?= $key ?>][award_selected]">
											<input class="uk-hidden" hidden type="radio" value="no" id="awardIdRadio" name="award[short][<?= $key ?>][award_selected]">
											<div class="" id="projectCatItem<?= $key ?>">
												<div class="plan-item ">
													<h3 class="plan-title uk-margin-remove"><?= strtoupper($awardType['award_name']) ?></h3>
													<div class="plan-price uk-text-right uk-margin-right">
														Student: <?= $currency_symbol ?>&nbsp;<?= $awardType['prices'][strtolower($currency)]['student'] ?>&nbsp;&nbsp;&nbsp;&nbsp;<br />
														Professional: <?= $currency_symbol ?>&nbsp;<?= $awardType['prices'][strtolower($currency)]['professional'] ?>&nbsp;&nbsp;&nbsp;&nbsp;
														<?php
														// if ($currency == 'INR') {
														// 	echo '<br/>';
														// 	echo '<b>Prices Including GST</b>&nbsp;&nbsp;&nbsp;&nbsp;';
														// }
														?>
													</div>

													<div class="plan-image">
														<img src="<?= $awardType['award_image'] ?>" alt="Img">
													</div>
													<div class="plan-content">
														<ul class="plan-information">
															<?php foreach ($awardType['awards'] as $aKey => $award) : ?>
																<li>
																	<label class="m-0">
																		<input class="uk-checkbox subAwardSelection<?= $key ?>" type="checkbox" value="<?= $award['name'] ?>" id="rulesAndRgulations" name="award[short][<?= $key ?>][award_names][]">
																		<?= $award['name'] ?>
																	</label>
																</li>
															<?php endforeach; ?>
														</ul>
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<?php if ($festival_details['feature_awards']) : ?>
						<?php endif; ?>
						<div class="strip-set">
							<div uk-grid>
								<div class="uk-width-3-4">
									Total Fee
								</div>
								<div class="uk-width-1-4 uk-text-right">
									<span id="totalProjectPrice"> <strong>&nbsp; </strong></span>
								</div>
							</div>
						</div>
						<!-- Rules -->
						<div class="uk-margin" uk-grid>
							<div class="uk-width-1-2@m">
								<label class="m-0">
									<input class="uk-checkbox" type="checkbox" id="rulesAndRgulations" name="">
									I agree with the rules and regulations. <a href="#festivalRules" uk-toggle>Read Rules</a>
								</label>
							</div>
							<div class="uk-width-1-2@m uk-text-right">
								<button class="uk-button uk-button-primary btn-all-page" type="submit">Submit</button>
							</div>
						</div>
					</div>
				</form>
			<?php endif; ?>
		</div>
	</div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
	$('#selectProjectType').on('change', function() {
		var element = $(this).find('option:selected');
		var type = element.attr("data_type");
		console.log(type);
		var formData = {
			projectType: type,
			getAwardsdata: 'true'
		};
		$('#chooseAwardsDiv').show();
	})
	$('.plan-item-wrap').on('click', function(ev) {
		console.log('item clicked')
	})

	$('#awardSelectionForm').submit(function(ev) {
		ev.preventDefault();
		var formData = new FormData($(this)[0]);
		console.log(Array.from(formData))
	})
</script>
<?= $this->endSection() ?>