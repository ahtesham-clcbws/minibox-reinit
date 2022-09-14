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

	.plan-item-wrap .uk-checkbox.selectAward {
		/* display: none; */
		border: 0;
	}

	.plan-item-wrap .uk-checkbox.selectAward:checked {
		display: inline-block;
	}

	#subTotalBlock,
	#gstBlock,
	#finalAmountBlock,
	#chooseAwardsDiv,
	#ShortAwardsDiv,
	#FeatureAwardsDiv {
		display: none;
	}

	#subTotalBlock,
	#gstBlock,
	#finalAmountBlock {
		font-weight: bold;
		display: block;
	}

	#totalProjectPricePrefix,
	#totalProjectPrice,
	#taxProjectPricePrefix,
	#taxProjectPrice,
	#finalProjectPricePrefix,
	#finalProjectPrice {
		display: inline-block;
	}

	#totalProjectPrice,
	#taxProjectPrice,
	#finalProjectPrice {
		width: 70px;
	}
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
				<form id="submitForm" method="post">
					<!-- Personal Details -->
					<h4>Personal Details</h4>
					<div class="uk-grid-small" uk-grid>
						<div class="uk-margin uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s uk-margin-top">
							<label class="uk-form-label" for="submitter_name">Submitter Name</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Submitter Name" name="name" id="submitter_name" required>
							</div>
						</div>
						<div class="uk-margin uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="email_id">Email Id</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="email" placeholder="Email Id" name="email" id="email_id" required>
							</div>
						</div>
						<div class="uk-margin uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="hormobileizontal">Mobile </label>
							<div class="uk-form-controls">
								<input class="uk-input" type="tel" placeholder="Mobile" name="mobile" id="mobile" required>
							</div>
						</div>
						<div class="uk-margin uk-width-1-4@l uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="country">Country</label>
							<div class="uk-form-controls">
								<select name="country" class="uk-select select2" data-placeholder="Select Country" data-allow-clear="true" id="country" required>
									<option value="" selected="" disabled=""></option>
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
								<input class="uk-input" type="text" placeholder="Movie Name" name="movie_name" id="movie_name" required>
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="director">Director</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="Director" name="director" id="director" required>
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="movie_preview_link">Movie preview link</label>
							<div class="uk-form-controls">
								<input class="uk-input" type="url" placeholder="vimeo, google drive, youtube etc | optional" name="movie_preview_link" id="movie_preview_link">
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="password">Movie Password <small>(if required)</small></label>
							<div class="uk-form-controls">
								<input class="uk-input" type="text" placeholder="if any | optional" name="movie_password" id="password">
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
							<label class="uk-form-label" for="duration">Duration <small>(in minutes)</small></label>
							<div class="uk-form-controls">
								<input class="uk-input" type="number" placeholder="Duration " name="duration" id="duration" required>
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="debut_film">Is this your Debut film</label>
							<div class="uk-form-controls">
								<select name="debut_film" class="uk-select select2" data-placeholder="" data-allow-clear="true" id="debut_film" required>
									<option value="" selected="" disabled=""></option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</div>
						</div>
						<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
							<label class="uk-form-label" for="language">Language </label>
							<div class="uk-form-controls">
								<select name="language" class="uk-select select2" id="language" data-placeholder="Select an langugage" data-allow-clear="true" required>
									<option value="" selected="" disabled=""></option>
									<?php foreach (getLanguages() as $language) : ?>
										<option value="<?= $language['id'] ?>"><?= $language['name'] ?> (<?= $language['native_name'] ?>)</option>
									<?php endforeach; ?>
								</select>
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
						<div class="deadlinesBlocks" id="userOccupationBlock">
							<h4>Occupation</h4>
							<div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
								<b>You are ! </b>
								<label class="uk-radio-label"><input class="uk-radio" type="radio" name="occupation" onchange="calculateAwardsData()" value="professional" required> Professional</label>
								<label class="uk-radio-label"><input class="uk-radio" type="radio" name="occupation" onchange="calculateAwardsData()" value="student" required> Student</label>
							</div>
						</div>
						<div class="deadlinesBlocks projectTypeDiv">
							<label class="uk-form-label">Select type of Project</label>
							<div class="uk-form-controls uk-width-1-1">
								<select class="uk-select uk-width-1-1 select2" name="project" data-placeholder="Feature / Short ?" data-allow-clear="true" id="selectProjectType">
									<option selected="" value="" disabled=""></option>
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
					<input class="uk-hidden" hidden value="<?= $currency ?>" name="currency" id="festival_currency">
					<input class="uk-hidden" hidden value="<?= $festival_details['deadlines']['show']['deadline'] ?>" name="festival_deadline" id="festival_deadline">
					<div class="uk-hidden" hidden id="deadline_data"><?= json_encode($festival_details['deadlines']['show']) ?></div>
					<div class="uk-margin-top" id="chooseAwardsDiv">
						<div class="strip-set">
							<p>Select <span id="projectTypeName"></span>Awards</p>
						</div>
						<?php foreach ($typesOfAwards as $typesOfAward) : ?>
							<?php if ($festival_details[strtolower($typesOfAward) . '_awards']) : ?>
								<div id="<?= $typesOfAward ?>AwardsDiv">
									<?php foreach ($festival_details[strtolower($typesOfAward) . '_awards_prices'] as $key => $awardType) : ?>
										<?php if ($awardType['award_count'] > 0) : ?>
											<input class="uk-hidden" hidden id="award<?= $typesOfAward ?>Pricestudent<?= $key ?>" value="<?= $awardType['prices'][strtolower($currency)]['student'] ?>">
											<input class="uk-hidden" hidden id="award<?= $typesOfAward ?>Priceprofessional<?= $key ?>" value="<?= $awardType['prices'][strtolower($currency)]['professional'] ?>">
											<input class="uk-hidden" hidden id="award<?= $typesOfAward ?>Name<?= $key ?>" value="<?= $awardType['award_name'] ?>">
											<div class="plan-item-wrap">
												<div uk-grid class="uk-grid-collapse" key="<?= $key ?>">
													<div class="uk-width-1-5@m uk-width-1-2">
														<div class="plan-image">
															<img src="<?= $awardType['award_image'] ?>" alt="Img">
														</div>
													</div>
													<div class="uk-width-4-5@m uk-width-1-2 plan-item plan-content">
														<h3 class="plan-title uk-margin-remove">
															<label class="m-0">
																<?= strtoupper($awardType['award_name']) ?> AWARDS
																<input class="uk-checkbox uk-form-large selectAward<?= $typesOfAward ?> parentAward<?= $typesOfAward ?>" onchange="calculateAwardsData()" key="<?= $key ?>" id="parentAward<?= $typesOfAward ?><?= $key ?>" subawardsclass="subAward<?= $typesOfAward ?>Selection<?= $key ?>" awardId="<?= $awardType['award_id'] ?>" type="checkbox" value="<?= $awardType['award_name'] ?>" name="award[<?= strtolower($typesOfAward) ?>][<?= $awardType['award_id'] ?>][award]">
															</label>
														</h3>
														<div class="plan-price uk-margin-bottom">
															Student: <?= $currency_symbol ?>&nbsp;<?= $awardType['prices'][strtolower($currency)]['student'] ?><?= $gst_note ?> | Professional: <?= $currency_symbol ?>&nbsp;<?= $awardType['prices'][strtolower($currency)]['professional'] ?><?= $gst_note ?>&nbsp;&nbsp;&nbsp;&nbsp;
															<?php
															// if ($currency == 'INR') {
															// 	echo '<br/>';
															// 	echo '<b>Prices Including GST</b>&nbsp;&nbsp;&nbsp;&nbsp;';
															// }
															?>
														</div>
														<ul class="plan-information">
															<?php foreach ($awardType['awards'] as $aKey => $award) : ?>
																<li class="uk-display-inline-block">
																	<label class="m-0 subAward subAward<?= $typesOfAward ?><?= $key ?>" key="<?= $key ?>">
																		<input class="uk-checkbox subAward<?= $typesOfAward ?>Selection<?= $key ?>" type="checkbox" value="<?= $award['name'] ?>" name="award[<?= strtolower($typesOfAward) ?>][<?= $awardType['award_id'] ?>][sub_awards][]">
																		<?= $award['name'] ?>
																	</label>
																</li>
															<?php endforeach; ?>
														</ul>
													</div>
												</div>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
						<div id="totalPricingDivNotFixed"></div>
						<div class="strip-set sticky_element" id="totalPricingDiv">
							<div uk-grid>
								<div class="uk-width-2-3@m">
									Fee
								</div>
								<div class="uk-width-1-3@m uk-text-right">
									<span id="subTotalBlock">
										<span id="totalProjectPricePrefix">Total: </span>
										<?= $currency_symbol ?> <span id="totalProjectPrice">0</span>
									</span>
									<span id="gstBlock">
										<span id="taxProjectPricePrefix">GST 18%: </span>
										<span id="taxProjectPrice"></span>
									</span>
									<span id="finalAmountBlock">
										<span id="finalProjectPricePrefix">Final Amount: </span>
										<?= $currency_symbol ?> <span id="finalProjectPrice">0</span>
									</span>
								</div>
							</div>
						</div>
						<textarea class="uk-hidden" name="totalPricingArray" id="totalPricingArray"></textarea>
						<input class="uk-hidden" hidden name="project_type" id="project_type" value="">
						<textarea class="uk-hidden" id="awardsPricingArrayShort"><?= json_encode($festival_details['short_awards_prices']) ?></textarea>
						<textarea class="uk-hidden" id="awardsPricingArrayFeature"><?= json_encode($festival_details['feature_awards_prices']) ?></textarea>
						<!-- Rules -->
						<div class="uk-margin" uk-grid>
							<div class="uk-width-1-2@m">
								<label class="m-0">
									<input type="hidden" id="gateway" hidden name="gateway" value="<?= $gateway ?>">
									<input class="uk-checkbox" type="checkbox" id="rulesAndRgulations" name="rules" required>
									I agree with the rules and regulations. <a href="#festivalRules" uk-toggle>Read Rules</a>
								</label>
							</div>
							<div class="uk-width-1-2@m uk-text-right">
								<div class="uk-text-right uk-width-1-1">
									<div id="showOtherGatewayOptions"></div>
									<button class="uk-button uk-button-primary btn-all-page" type="submit" id="mainSubmitButton">Submit</button>
								</div>
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
	$(document).ready(function() {
		$('.select2').select2();
	});
	var selectProjectType = $('#selectProjectType');
	var deadline_data = JSON.parse($('#deadline_data').html());
	var currency = $('#festival_currency').val();
	var currencyLower = currency.toLowerCase();

	// var currencySymbol = '€';
	// if (currency == 'INR') {
	// 	currencySymbol = '₹';
	// }

	var totalProjectPricePrefix = $('#totalProjectPricePrefix');
	var totalProjectPrice = $('#totalProjectPrice');

	var taxProjectPricePrefix = $('#taxProjectPricePrefix');
	var taxProjectPrice = $('#taxProjectPrice');

	var finalProjectPricePrefix = $('#finalProjectPricePrefix');
	var finalProjectPrice = $('#finalProjectPrice');

	var totalPricingArray = $('#totalPricingArray');

	var selectedAwardsArray = $('#selectedAwardsArray');
	var selectedCategoriesArray = $('#selectedCategoriesArray');

	selectProjectType.on('select2:select', function() {
		const userType = $("input[type='radio'][name='occupation']:checked").val();
		const typeOfAward = selectProjectType.find('option:selected').attr("data_type");
		var project_type = $('#project_type');
		console.log(typeOfAward);
		project_type.val(typeOfAward);
		if (userType) {
			// console.log(typeOfAward);
			$('#projectTypeName').html(typeOfAward + ' ');
			var formData = {
				projectType: typeOfAward,
				getAwardsdata: 'true'
			};
			if (typeOfAward == 'Short') {
				$('#ShortAwardsDiv').show();
			} else {
				$('#ShortAwardsDiv').hide();
			}
			if (typeOfAward == 'Feature') {
				$('#FeatureAwardsDiv').show();
			} else {
				$('#FeatureAwardsDiv').hide();
			}
			$('#chooseAwardsDiv').show();
			calculateAwardsData();
		} else {
			alert('', 'Please Select Occupation before selecting project type.', 'warning').then(() => {
				selectProjectType.val(null).trigger('change');
				$("input[type='radio'][name='occupation']").focus();
				$('#userOccupationBlock').focus();
			})
		}
	})
	$('.subAward').on('click', function(ev) {
		const typeOfAward = selectProjectType.find('option:selected').attr("data_type");
		const key = $(this).attr('key')
		const parentAward = $('#parentAward' + typeOfAward + key);
		var checkingArray = [];
		const selection = 'subAward' + typeOfAward + 'Selection' + key;
		// console.log(selection);
		// console.log($('.' + selection));
		$('.' + selection).each(function(index, element) {
			// const checkbox = $(element).children('.uk-checkbox');
			// console.log(this);
			if (this.checked) {
				checkingArray.push("true");
				// alert('', 'checkbos true')
			} else {
				checkingArray.push("false");
			}
			// $(element).prop('disabled', false);
		});
		// console.log(checkingArray);
		if (checkingArray.includes('true')) {
			parentAward.prop('checked', true);
		} else {
			parentAward.prop('checked', false);
		}
		// checkIfAwardsSelected();
		calculateAwardsData();
	})

	// if some awards has selected && the screen not on the OR above the totalPricingDiv then ID (totalPricingDiv) has the class of fixed_element else not
	function checkIfAwardsSelected() {
		const typeOfAward = selectProjectType.find('option:selected').attr("data_type");
		console.log($('.parentAward' + typeOfAward).length)
		return true;
	}

	function calculateAwardsData() {
		const typeOfAward = selectProjectType.find('option:selected').attr("data_type");
		const userType = $("input[type='radio'][name='occupation']:checked").val();
		var totalPrice = 0;

		var selectedAwards = [];
		var selectedCategories = '';

		const userTypeLower = userType.toLowerCase();

		// var deadlineName = deadline_dataname

		// console.log(festival_currency);
		// console.log(deadline_data);

		var totalAwards = 0;
		$('.parentAward' + typeOfAward).each(function(index, element) {
			if (this.checked) {
				const key = $(this).attr('key');
				const awardPrice = parseInt($('#award' + typeOfAward + 'Price' + userType + key).val());
				const awardName = $('#award' + typeOfAward + 'Name' + key).val();

				totalPrice += awardPrice;
				totalAwards += 1;

				var awardId = $(this).attr('awardId');
				selectedAwards.push(awardId);
			}
		})

		if (totalPrice > 0) {
			// totalProjectPrice.insertBefore(currencySymbol + '');
			totalProjectPrice.html(totalPrice + '.00');

			var finalPrice = 0;
			var taxValue = 0;
			if (currency == 'INR') {
				finalPrice = calculateFinalWithGst(totalPrice);
				taxValue = calculateGst(totalPrice);
			} else {
				finalPrice = totalPrice;
				taxValue = 0;
			}

			// finalProjectPrice.insertBefore(currencySymbol + '');
			taxProjectPrice.html(taxValue);
			finalProjectPrice.html(finalPrice);

			var totalArray = {
				awards: selectedAwards,
				total: totalPrice,
				final: finalPrice,
				tax: taxValue,
			};
			totalPricingArray.val(JSON.stringify(totalArray));

			totalAmountsShow();
		} else {
			totalProjectPrice.html('');
			finalProjectPrice.html('');
			totalPricingArray.val('');
			totalAmountsHide();
		}
	}

	function calculateFinalWithGst(amount) {
		var a = amount / 100;
		var b = a * 18;
		var c = amount + b;
		return c;
	}

	function calculateGst(amount) {
		var a = amount / 100;
		var b = a * 18;
		return b;
	}

	function totalAmountsShow() {
		if (currency == 'INR') {
			var array = ["subTotalBlock", "gstBlock", "finalAmountBlock"];
		} else {
			var array = ["subTotalBlock", "finalAmountBlock"];
		}
		array.forEach(element => {
			$('#' + element).show();
		});
	}

	function totalAmountsHide() {
		var array = ["subTotalBlock", "gstBlock", "finalAmountBlock"];
		array.forEach(element => {
			$('#' + element).hide();
		});
	}
	// $(window).scroll(function() {
	// 	if ($('#totalPricingDivNotFixed').visible(true) && checkIfAwardsSelected()) {
	// 		changeFixedTotoalBar(true);
	// 		// console.log('totalPricingDivNotFixed visible')
	// 	} else {
	// 		changeFixedTotoalBar(false);
	// 	}
	// });

	// function changeFixedTotoalBar(bool = false) {
	// 	if (bool) {
	// 		if (!$('#totalPricingDiv').hasClass('fixed_element')) {
	// 			$('#totalPricingDiv').addClass('fixed_element');
	// 		}
	// 	} else {
	// 		if ($('#totalPricingDiv').hasClass('fixed_element')) {
	// 			$('#totalPricingDiv').removeClass('fixed_element');
	// 		}
	// 	}
	// }
	$('#submitForm').submit(function(ev) {
		ev.preventDefault();
		const typeOfAward = selectProjectType.find('option:selected').attr("data_type");
		var formData = new FormData($(this)[0]);
		formData.append('submitForm', 'true');
		console.log(Array.from(formData));
		calculateAwardsData();
		<?php if ($gateway == 'other') : ?>
			if ($('#othergateway').val() == 'paypal') {
				initPayPal();
			}
			return;
		<?php endif; ?>
		// return;
		// console.log(Array.from(formData))
		// return;
		$.ajax({
			url: '',
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response) {
				// console.log(response);
				try {
					data = JSON.parse(response);
					console.log(data);
					if (data.success == true) {
						orderData = data.data.order;
						responseData = data.data.response;
						// return;
						alert('', data.message, 'success').then(() => {
							// console.log(data.data);
							// return;
							if ('<?= getUserCountry() ?>' == 'IN') {
								razorpaySubmit(responseData.id, orderData.package_amount, orderData.name, orderData.email, orderData.mobile, orderData.product_name);
							}
						});
					} else {
						console.log(response);
						alert(data.message, 'Error', 'error');
					}
				} catch (e) {
					console.log(e);
					alert('Undefined error, please try after some time.', 'Error', 'error');
				}
			},
			error: function(error) {

			}
		})
	})
</script>
<?= $this->endSection() ?>