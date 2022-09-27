<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('css') ?>
<style>
	.gt-details {
		overflow: hidden;
	}

	.gt-title:hover a {
		color: #d8b069;
	}

	.gt-title:hover {
		background: none;
	}

	.gt-title {
		background: #d8b069;
		text-align: center;
		border: #d8b069 2px solid;
		width: 100%;
		padding: 12px 0;
	}

	.gt-title a {
		color: #fff;
	}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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

		<form action="" method="get">
			<div class=" uk-grid" data-uk-grid="">
				<div class="uk-width-1-5@m uk-first-column">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<select name="edition" class="uk-select">
								<option value="" disabled="" selected="">Select Edition </option>
								<?php foreach ($festival_editions as $key => $festival_edition) : ?>
									<option <?= isset($_GET['edition']) && @$_GET['edition'] == $festival_edition ? 'selected' : '' ?> value="<?= $festival_edition ?>"><?= ordinal(count($festival_editions) - $key) ?> Edtion | <?= $festival_edition ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="uk-width-1-5@m">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<input class="uk-input uk-form-width-large" id="form-h-datalist" list="datalist" name="title" type="text" placeholder="Name search">
						</div>
					</div>
				</div>
				<div class="uk-width-1-5@m">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<select class="uk-select" name="country">
								<option value="" disabled="" selected="">Select Country </option>
								<?php foreach (getAllCountries() as $key => $country) : ?>
									<option <?= isset($_GET['country']) && @$_GET['country'] == $country['id'] ? 'selected' : '' ?> value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="uk-width-1-5@m">
					<div class="uk-margin">
						<div class="uk-form-controls">
							<select class="uk-select" name="genre">
								<option disabled="" selected="">Select Genre</option>
								<?php foreach (getGenres() as $key => $genre) : ?>
									<option <?= isset($_GET['genre']) && @$_GET['genre'] == $genre['value'] ? 'selected' : '' ?> value="<?= $genre['value'] ?>"><?= $genre['value'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="uk-width-1-5@m">
					<div class="uk-margin uk-height-1-1">
						<div class="uk-form-controls uk-height-1-1">
							<button class="uk-button uk-button-defualt btn-warning uk-height-1-1 uk-width-1-1" type="submit">
								<i class="fa fa-search"></i> SEARCH
							</button>
							<!-- <button class="uk-button uk-button-defualt btn-warning" name="download_pdf_official_selection"><i class="fa fa-download" aria-hidden="true"></i></button> -->
						</div>
					</div>
				</div>
			</div>
			<?php if (isset($_GET['edition']) || isset($_GET['title']) || isset($_GET['country']) || isset($_GET['genre'])) : ?>
				<div class="uk-margin-small-top searchBadges uk-child-width-1-2" uk-grid>
					<div class="uk-text-left@m uk-text-right@s">
						<?php if (isset($_GET['edition']) && trim($_GET['edition']) && !empty($_GET['edition'])) : ?>
							<span class="uk-badge searchTerm" searchType="edition"><?= $_GET['edition'] ?> Edition <span uk-icon="icon: close"></span></span>
						<?php endif; ?>
						<?php if (isset($_GET['title']) && trim($_GET['title']) && !empty($_GET['title'])) : ?>
							<span class="uk-badge searchTerm" searchType="title"><?= $_GET['title'] ?> <span uk-icon="icon: close"></span></span>
						<?php endif; ?>
						<?php if (isset($_GET['country']) && trim($_GET['country']) && !empty($_GET['country'])) : ?>
							<span class="uk-badge searchTerm" searchType="country"><?= getWorldName($_GET['country']) ?> <span uk-icon="icon: close"></span></span>
						<?php endif; ?>
						<?php if (isset($_GET['genre']) && trim($_GET['genre']) && !empty($_GET['genre'])) : ?>
							<span class="uk-badge searchTerm" searchType="genre"><?= $_GET['genre'] ?> <span uk-icon="icon: close"></span></span>
						<?php endif; ?>
					</div>
					<div class="uk-text-right">
						<span class="uk-badge">Clear All <span onclick="clearAllSearch()" uk-icon="icon: close"></span></span>
					</div>
				</div>
			<?php endif; ?>
		</form>

		<hr>
		<div class=" uk-grid" data-uk-grid="">
			<?php if (count($movies)) : ?>
				<?php foreach ($movies as $key => $movie) : ?>
					<div class="uk-width-1-4@m">
						<div class="schedule">
							<a href="<?= route_to('festival_official_selection_details', $festivalSlug, base64_encode($movie['id'])) ?>"></a>
							<img src="<?= $movie['poster'] ?>" alt="<?= $movie['title'] ?>">
							<div class="schedule-details">
								<h3 class="schedule-title">
									<a href=""><?= $movie['title'] ?></a>
								</h3>
								<div class="schedule-list">
									<?php
									$genresArray = (array)json_decode($movie['genres'], true);
									shuffle($genresArray);
									foreach ($genresArray as $key => $genre) {
										if ($key < 3) { ?>
											<span class="commaSeparated"><?= $genre ?></span>
										<?php } else { ?>
											<span class="commaSeparatedDotes"> ...</span>
									<?php }
									} ?>
								</div>
								<div class="schedule-list"><?= getWorldName($movie['country']) ?></div>
							</div>
						</div>
						<div class="gt-details">
							<div class="gt-title">
								<a href="javascript:void(0);">
									<?php if (trim($movie['awardName']) && !empty($movie['awardName'])) : ?>
										<?= $movie['awardName'] ?>
									<?php else : ?>
										Unknown
									<?php endif; ?>
								</a>
							</div>
						</div>

					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="uk-width-1-1 uk-text-center" style="padding: 50px;">
					<h2>No results found, please your search or try again later</h2>
				</div>
			<?php endif; ?>
		</div>

		<?= $pager->links('paginate', 'uikit_pagination') ?>

	</div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
	$('.searchTerm').on('click', function(ev) {
		const searchType = $(this).attr('searchType');

		let url = new URL(window.location.href);
		let params = new URLSearchParams(url.search);

		// Delete the foo parameter.
		params.delete(searchType); //Query string is now: 'bar=2'

		// console.log(url);
		// console.log(window.location.href);

		// var newUrl = location.pathname + location.search.replace(/[\?&]searchType=[^&]+/, '').replace(/^&/, '?')
		var newUrl = window.location.pathname + '?' + params + window.location.hash;
		// console.log(newUrl);

		window.location = newUrl;
	})

	function clearAllSearch() {
		var newUrl = window.location.pathname + window.location.hash;
		window.location = newUrl;
	}
</script>
<?= $this->endSection() ?>