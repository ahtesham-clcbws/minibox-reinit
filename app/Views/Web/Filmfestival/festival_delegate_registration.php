<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('content') ?>
<style>
	.uk-table tfoot {
		font-size: inherit;
	}

	.uk-table tfoot tr td {
		font-weight: bold;
		color: #fff;
		background: grey;
	}

	/* Chrome, Safari, Edge, Opera */
	.ticket_numbers::-webkit-outer-spin-button,
	.ticket_numbers::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	/* Firefox */
	.ticket_numbers {
		-moz-appearance: textfield;
		text-align: center;
		border: none;
		max-width: 50px;
		padding: 0;
	}

	.totalFooter .ticket_numbers {
		background: transparent;
		color: #fff;
		font-size: 18px;
	}

	.ticket_counter {
		min-width: 110px;
	}

	* {
		-webkit-user-select: none;
		/* Safari */
		-ms-user-select: none;
		/* IE 10 and IE 11 */
		user-select: none;
		/* Standard syntax */
	}

	#fullPackageJson,
	#packageCounts,
	.fullTicketDetails {
		display: none;
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

			<form method="post" id="submitForm">
				<div class="uk-grid-small" uk-grid>
					<div class="uk-margin uk-width-1-3@m uk-width-1-2@s uk-margin-top">
						<label class="uk-form-label" for="form-horizontal-text">Name of the Delegate</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" name="name" placeholder="Name of the Delegate" required>
						</div>
					</div>
					<div class="uk-margin uk-width-1-3@m uk-width-1-2@s">
						<label class="uk-form-label" for="form-horizontal-text">Movie Name</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" name="movie_name" placeholder="Movie Name" required>
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
						<label class="uk-form-label" for="form-horizontal-text">College/Company</label>
						<div class="uk-form-controls">
							<input class="uk-input" type="text" name="organization" placeholder="College/Company">
						</div>
					</div>

					<div class="uk-margin uk-width-2-3@m uk-width-1-1@s">
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
				</div>
				<hr>
				<div class="uk-margin uk-width-1-1">
					<div id="feeTable">
						<h3>Delegate Packages:</h3>
						<span id="packageCounts"><?= count($allPackages) ?></span>
						<div class="uk-margin uk-overflow-auto">
							<table class="uk-table Particulars">
								<thead>
									<tr>
										<th scope="col">Particulars</th>
										<th scope="col">Fee (per delegate)</th>
										<th scope="col">No. of Tickets</th>
										<th scope="col" class="uk-text-right">Total Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($allPackages as $key => $package) : ?>
										<tr>
											<td>
												<input type="hidden" hidden name="package[<?= $key ?>][id]" value="<?= $package['id'] ?>">
												<label><?= $package['details'] ?></label>
												<input type="hidden" hidden name="package[<?= $key ?>][details]" value="<?= $package['details'] ?>">
											</td>
											<td>
												<?= $package['currency_symbol'] ?> <span class="ticket_amount" id="ticket_amount<?= $key ?>" key="<?= $key ?>"><?= $package['fee'] ?></span>
												<input type="hidden" hidden name="package[<?= $key ?>][amount]" value="<?= $package['fee'] ?>">
											</td>
											<td class="uk-padding-remove-top">
												<div class="ticket_counter">
													<icon class="ticketDecrease" key="<?= $key ?>">
														<i class="fa-solid fa-minus"></i>
													</icon>
													<input type="number" class="ticket_numbers" readonly id="ticket_numbers<?= $key ?>" name="package[<?= $key ?>][tickets]" value="0">
													<icon class="ticketIncrease" key="<?= $key ?>">
														<i class="fa-solid fa-plus"></i>
													</icon>
												</div>
											</td>
											<td class="uk-text-right uk-padding-remove-top">
												<input type="number" class="ticket_numbers" id="ticket_total<?= $key ?>" name="package[<?= $key ?>][total]" value="0">
												<span class="fullTicketDetails" id="fullTicketDetails<?= $key ?>" key="<?= $key ?>"><?= json_encode($package) ?></span>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<?php if ($gateway == 'razorpay') : ?>
										<tr class="totalFooter" id="gstFooter">
											<td colspan="2"></td>
											<td class="uk-text-center">GST 18%</td>
											<td class="uk-text-right"><?= $currency_symbol ?> <input type="number" class="ticket_numbers" id="taxGstInput" name="tax_gst" value="0"></td>
										</tr>
									<?php endif; ?>
									<tr class="totalFooter">
										<td colspan="2"></td>
										<td class="uk-text-center">Tickets <input type="number" class="ticket_numbers" id="grandTotalTickets" name="package_tickets" value="0"></td>
										<td class="uk-text-right"><?= $currency_symbol ?> <input type="number" class="ticket_numbers" id="grandTotal" name="package_amount" value="0"></td>
									</tr>
								</tfoot>
							</table>
							<input type="hidden" id="gateway" hidden name="gateway" value="<?= $gateway ?>">
						</div>
					</div>
				</div>
				<div class="uk-text-right uk-width-1-1">
					<div id="showOtherGatewayOptions"></div>
					<button class="uk-button uk-button-primary" type="submit" id="mainSubmitButton">Submit</button>
				</div>
			</form>

		</div>
	</div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
	var grandTotal = 0;
	var grandTotalTickets = 0;
	// getAllData();
	$('.ticketDecrease').on('click', function(event) {
		event.stopPropagation();
		event.stopImmediatePropagation();

		var counterId = '#ticket_numbers' + $(this).attr('key');
		var oldValue = parseInt($(counterId).val());
		if (oldValue >= 1) {
			var newValueSingle = oldValue - 1;
			$(counterId).val(newValueSingle);
		}
		getAllData();
	})
	$('.ticketIncrease').on('click', function(event) {
		event.stopPropagation();
		event.stopImmediatePropagation();

		var counterId = '#ticket_numbers' + $(this).attr('key');
		var oldValue = parseInt($(counterId).val());
		var newValueSingle = oldValue + 1;
		$(counterId).val(newValueSingle);

		getAllData();
	})

	function getAllData() {
		var totalPackages = parseInt($('#packageCounts').html());
		var totalJson = [];
		for (let index = 0; index < totalPackages; index++) {
			var tickets = $('#ticket_numbers' + index);

			var element = $('#fullTicketDetails' + index);
			var detailsJson = JSON.parse(element.html());
			var totalAmount = detailsJson.fee * parseInt(tickets.val());
			$('#ticket_total' + index).val(totalAmount);

			detailsJson.total = totalAmount;
			detailsJson.tickets = parseInt(tickets.val());
			totalJson[index] = detailsJson;
			element.html(JSON.stringify(detailsJson));
		}
		var totalAmountJson = {
			tickets: 0,
			amount: 0
		}
		totalJson.forEach(package => {
			totalAmountJson['tickets'] += parseInt(package.tickets);
			totalAmountJson['amount'] += parseInt(package.total);
		})
		var fullJson = {
			packages: totalJson,
			total: totalAmountJson,
		}
		grandTotal = totalAmountJson.amount;
		grandTotalTickets = totalAmountJson.tickets;

		<?php if ($gateway == 'razorpay') { ?>
			var singlePercent = totalAmountJson.amount / 100;
			var gstAmount = singlePercent * 18;
			totalAmountJson.amount = totalAmountJson.amount + gstAmount;
			$('#taxGstInput').val(gstAmount);
		<?php }; ?>

		$('#grandTotal').val(totalAmountJson.amount);
		$('#grandTotalTickets').val(totalAmountJson.tickets);

		console.log(fullJson);
	}

	$('#submitForm').submit(function(e) {
		e.preventDefault();
		if (grandTotal == 0 || grandTotalTickets == 0) {
			alert('Please choose tickets before cubmitting.', 'Error', 'error');
			return;
		}
		<?php if ($gateway == 'other') : ?>
			if ($('#othergateway').val() == 'paypal') {
				initPayPal();
			}
			return;
		<?php endif; ?>
		var formData = new FormData($(this)[0]);
		formData.append('submitForm', 'true');
		// console.log(Array.from(formData));
		// return;
		$.ajax({
			url: '',
			type: 'post',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response, textStatus, jqXHR) {
				// console.log(response);
				var data = {};
				try {
					data = JSON.parse(response);
					console.log(data.data);
					if (data.success == true) {
						orderData = data.data.order;
						responseData = data.data.response;
						// return;
						alert('', data.message, 'success').then(() => {
							// console.log(data.data);
							if ('<?= getUserCountry() ?>' == 'IN') {
								razorpaySubmit(responseData.id, orderData.package_amount, orderData.name, orderData.email, orderData.mobile, orderData.product_name);
							}
						});
					} else {
						alert(data.message, 'Error', 'error');
					}
				} catch (e) {
					console.log(e);
					alert('Undefined error, please try after some time.', '', 'error');
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Server error', 'Error', 'error');
			},
		})
	})
</script>
<?= $this->endSection() ?>