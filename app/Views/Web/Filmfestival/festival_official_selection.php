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

		<form action="" method="post">
			<div class=" uk-grid" data-uk-grid="">
				<div class="uk-width-1-5@m uk-first-column">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<select name="edition" class="uk-select">
								<option value="" disabled="" selected="">Select Edition </option>
								<option value="1">5 Edtion | 2015</option>
								<option value="2">2 Edtion | 2012</option>
							</select>
						</div>
					</div>
				</div>
				<div class="uk-width-1-5@m">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<input class="uk-input uk-form-width-large" id="form-h-datalist" list="datalist" name="name" type="text" placeholder="Name search">
						</div>
					</div>
				</div>
				<div class="uk-width-1-5@m">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<select class="uk-select" name="country">
								<option value="" disabled="" selected="">Select Country </option>
								<option>Afghanistan</option>
							</select>
						</div>
					</div>
				</div>
				<div class="uk-width-1-5@m">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<select class="uk-select" name="project">
								<option disabled="" selected="">Project Type</option>
								<option value="8">Feature</option>
								<option value="7">Short</option>
								<option value="6">Animation</option>
								<option value="5">Music video</option>
								<option value="4">Ad film</option>
								<option value="2">Screenplay</option>
							</select>
						</div>
					</div>
				</div>
				<div class="uk-width-1-5@m">
					<div class="uk-margin uk-height-1-1">
						<div class="uk-form-controls uk-height-1-1">
							<button class="uk-button uk-button-defualt btn-warning uk-height-1-1 uk-width-1-1">
								<i class="fa fa-search"></i> SEARCH
							</button>
							<!-- <button class="uk-button uk-button-defualt btn-warning" name="download_pdf_official_selection"><i class="fa fa-download" aria-hidden="true"></i></button> -->
						</div>
					</div>
				</div>
			</div>
		</form>

		<hr>
		<div class=" uk-grid" data-uk-grid="">
			<div class="uk-width-1-4@m">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin uk-first-column">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin uk-first-column">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-4.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name 2</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin uk-first-column">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin uk-first-column">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
			<div class="uk-width-1-4@m uk-grid-margin">
				<div class="schedule">
					<a href="#"></a>
					<img src="/public/images/list-box-3.jpg" alt="">
					<div class="schedule-details">
						<h3 class="schedule-title">
							<a href="">movie name</a>
						</h3>
						<div class="schedule-list">Crime, Drama, Horror</div>
						<div class="schedule-list">Feature</div>
						<div class="schedule-list">India</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>