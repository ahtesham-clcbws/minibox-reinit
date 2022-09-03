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

<section class="uk-section-small">
	<div class="uk-container">
		<div class=" ">
			<div class="uk-grid" uk-grid>
				<div class="uk-width-3-5">
					<div class="uk-card uk-card-default">
						<div class="uk-card-body">
							<h3>We’re happy to hear from you and help you with your entry.</h3>
							<form class="uk-grid-small" method="post" id="submitForm" uk-grid>
								<div class="uk-margin uk-width-1-1 uk-margin-top">
									<label class="uk-form-label" for="form-horizontal-text">Your Name</label>
									<div class="uk-form-controls">
										<input class="uk-input" id="form-horizontal-text" name="name" type="text" placeholder="Your Name" required="">
									</div>
								</div>
								<div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
									<label class="uk-form-label" for="form-horizontal-text">Email ID</label>
									<div class="uk-form-controls">
										<input class="uk-input" id="form-horizontal-text" name="email" type="email" placeholder="Email ID" required="">
									</div>
								</div>
								<div class="uk-margin uk-width-1-2@m uk-width-1-1@s">
									<label class="uk-form-label" for="form-horizontal-text">Mobile</label>
									<div class="uk-form-controls">
										<input class="uk-input" id="form-horizontal-text" name="phone" type="tel" placeholder="Mobile" required="">
									</div>
								</div>
								<div class="uk-margin uk-width-1-1">
									<label class="uk-form-label" for="form-horizontal-text">Message</label>
									<div class="uk-form-controls">
										<textarea class="uk-textarea" rows="5" name="message" placeholder="Message"></textarea>
									</div>
								</div>
								<div class="uk-margin uk-width-1-1">
									<div class="uk-form-controls">
										<button class="uk-button uk-button-primary btn-all-page">Submit</button>
										<!-- <button class="uk-button uk-button-default">Submit</button> -->
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
				<div class="uk-width-2-5">

					<div class="uk-card uk-card-default">
						<div class="uk-card-body">

							<h3>Contact Details</h3>
							<div class="contact-item">
								<span>Organizer Name :</span>
								<p>City Goverment</p>
							</div>
							<div class="contact-item">
								<span>Phone:</span>
								<p> <a href="tel:+91 9988776655">+91 9988776655</a></p>
							</div>
							<div class="contact-item">
								<span>Email:</span>
								<p> <a href="mailto:xyz@example.com">xyz@example.com</a></p>
							</div>
							<div class="contact-item">
								<span>Website:</span>
								<p> <a href="https://example.com" target="_blank">https://example.com</a></p>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>