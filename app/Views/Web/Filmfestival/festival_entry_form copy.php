<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('content') ?>
<style>
	.active-2 {
		border: 5px solid #d8b069 !important;
	}

	.deadline:hover {
		border: 5px solid #d8b069 !important;
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
			<form id="SignupForm" method="post">
				<div class="uk-margin-medium-top">
					<ul class="uk-flex-center" uk-tab>
						<li class="uk-active"><a href="#">Center</a></li>
						<li><a href="#">Item</a></li>
						<li><a href="#">Item</a></li>
					</ul>
				</div>

				<h3> <span class="circle uk-hidden">1 </span> Personal Details </h3>
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
				<h3><span class="circle uk-hidden">2 </span> Movie Details</h3>
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


				<h3> <span class="circle uk-hidden"> 3 </span> Deadline and Category </h3>
				<div class="uk-margin">
					<!-- <label class="uk-form-label" for="occupation">Occupation </label> -->
					<div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
						<label>Occupation</label>
						<label><input class="uk-checkbox" type="checkbox" value="professional" required> Professional</label>
						<label><input class="uk-checkbox" type="checkbox" value="students" required> Student</label>
					</div>
				</div>
				<hr>
				<h3>Entry Deadline</h3>
				<div class="uk-margin Entry-Deadline">
					<div class="uk-grid">
						<div class="uk-width-1-4@m">
							<div class="deadline border ">
								<p>
									Early Deadline </p>
								12 Apr 2022
							</div>
						</div>
						<div class="uk-width-1-4@m">
							<div class="deadline border ">
								<p>
									Regular Deadline </p>
								30 Jun 2022
							</div>
						</div>
						<div class="uk-width-1-4@m">
							<div class="deadline border ">
								<p>
									Late Deadline </p>
								10 Jul 2022
							</div>
						</div>
						<div class="uk-width-1-4@m">
							<div class="deadline border active-2">
								<p>
									Extended Deadline </p>
								22 Oct 2022
							</div>
						</div>
					</div>
					<input type="hidden" value="" name="deadline">
					<input type="hidden" value="" name="deadlinedate">
				</div>
				<hr>
				<div class="uk-margin" id="projecttab">
					<label class="uk-form-label" for="selectMe">Select Project</label>
					<div class="uk-form-controls">
						<select class="uk-select" name="project" id="selectMe" data-host="http://sky360.in/mini_box_office/" data-deadindex="4" data-dir="http://sky360.in/mini_box_office/mini@1357admin/img/filmfestival/">
							<option selected="" value="" disabled="">Select type of Project</option>
							<option value="13">Feature Film (61 min to 180 min) </option>
							<option value="12">Feature Documentary (61 min to 180 min) </option>
							<option value="11">Feature Animation (61 min to 180 min) </option>
							<option value="8">Feature Animation (61 min to 180 min) </option>
							<option value="7">Short Film (1 m to 60 min) </option>
							<option value="6">Short Documentary (1 m to 60 min) </option>
							<option value="5">Short Animation (1 m to 60 min) </option>
							<option value="4">Short Short Music Video (up to 10 min) </option>
							<option value="3">Short Ad Film (up to 4 min) </option>
							<option value="2">Screenplay Short </option>
							<option value="1">Screenplay Feature </option>
						</select>
					</div>
				</div>
				<!-- Rules -->
				<!-- <div class="uk-margin">
					<div class="uk-width-1-2@s">
						<label class="m-0">
							<input class="uk-checkbox" type="checkbox" id="rulesAndRgulations" name=""> I agree with the rules and regulations. <a href="rules.php" target="_blank">Read Rules</a></label>
					</div>
				</div> -->
			</form>
		</div>
	</div>
</div>


<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>