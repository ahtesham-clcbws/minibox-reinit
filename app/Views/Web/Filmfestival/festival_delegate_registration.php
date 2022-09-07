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

			<form class="uk-grid-small" method="post" id="submitForm" uk-grid>
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
											<td><label><?= $package['details'] ?></label></td>
											<td><?= $package['currency_symbol'] ?> <span class="ticket_amount" id="ticket_amount<?= $key ?>" key="<?= $key ?>"><?= $package['fee'] ?></span></td>
											<td class="uk-padding-remove-top">
												<div class="ticket_counter">
													<icon class="ticketDecrease" key="<?= $key ?>">
														<i class="fa-solid fa-minus"></i>
													</icon>
													<span class="ticket_numbers" id="ticket_numbers<?= $key ?>" key="<?= $key ?>">0</span>
													<icon class="ticketIncrease" key="<?= $key ?>">
														<i class="fa-solid fa-plus"></i>
													</icon>
												</div>
											</td>
											<td class="uk-text-right">
												<span class="ticket_total" id="ticket_total<?= $key ?>" key="<?= $key ?>"></span>
												<span class="fullTicketDetails" id="fullTicketDetails<?= $key ?>" key="<?= $key ?>"><?= json_encode($package) ?></span>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2"></td>
										<td class="uk-text-center">Tickets <span id="grandTotalTickets">0</span></td>
										<td class="uk-text-right"><?= $currency_symbol ?> <span id="grandTotal">0</span></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				<input id="fullPackageJson" value="" name="fullPackageJson">
				<button class="uk-button uk-button-primary btn-all-page" id="rzp-button">Submit</button>
			</form>

		</div>
	</div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
	var grandTotal = 0;
	var grandTotalTickets = 0;
	getAllData();
	$('.ticketDecrease').on('click', function(event) {
		event.stopPropagation();
		event.stopImmediatePropagation();

		var counterId = '#ticket_numbers' + $(this).attr('key');
		var oldValue = parseInt($(counterId).html());
		if (oldValue >= 1) {
			var newValueSingle = oldValue - 1;
			$(counterId).html(newValueSingle);
		}
		getAllData();
	})
	$('.ticketIncrease').on('click', function(event) {
		event.stopPropagation();
		event.stopImmediatePropagation();

		var counterId = '#ticket_numbers' + $(this).attr('key');
		var oldValue = parseInt($(counterId).html());
		var newValueSingle = oldValue + 1;
		$(counterId).html(newValueSingle);

		getAllData();
	})

	function getAllData() {
		var totalPackages = parseInt($('#packageCounts').html());
		var totalJson = [];
		for (let index = 0; index < totalPackages; index++) {
			var tickets = $('#ticket_numbers' + index);
			// tickets.html(parseInt(tickets.html())+1);

			var element = $('#fullTicketDetails' + index);
			var detailsJson = JSON.parse(element.html());
			var totalAmount = detailsJson.fee * parseInt(tickets.html());
			$('#ticket_total' + index).html(totalAmount);

			detailsJson.total = totalAmount;
			detailsJson.tickets = parseInt(tickets.html());
			totalJson[index] = detailsJson;
			element.html(JSON.stringify(detailsJson));
		}
		var totalAmountJson = {
			tickets: 0,
			amount: 0
		}
		totalJson.forEach(package => {
			totalAmountJson['totalTickets'] += package.tickets;
			totalAmountJson['totalAmount'] += package.total;
		})
		var fullJson = {
			packages: totalJson,
			total: totalAmountJson,
		}
		grandTotal = totalAmountJson.amount;
		grandTotalTickets = totalAmountJson.tickets;
		$('#grandTotal').html(totalAmountJson.amount);
		$('#grandTotalTickets').html(totalAmountJson.tickets);

		$('#fullPackageJson').val(JSON.stringify(fullJson));
		console.log(fullJson);
	}

	function getSingleTicketDetails(index, tickets) {
		var element = $('#fullTicketDetails' + index);
		var detailsJson = JSON.parse(element.html());
		var totalAmount = detailsJson.fee * tickets;
		detailsJson.total = totalAmount;
		detailsJson.tickets = tickets;

		element.html(JSON.stringify(detailsJson))
		console.log(detailsJson);
	}


	$('#submitForm').submit(function(e) {
		e.preventDefault();
		if (grandTotal == 0 || grandTotalTickets == 0) {
			alert('Please choose tickets before cubmitting.', 'Error', 'error');
			return;
		}
		var formData = new FormData($(this)[0]);
		formData.append('submitForm', 'true');
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
							console.log(data.data);
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