<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('css') ?>
<style>
	.about-text-title {
		padding-top: 10%;
	}

	.gridlove-box {
		box-shadow: none !important;
	}

	.about-section-shadow {
		min-height: 528px;
	}

	.socicon-facebook {
		background-color: #3b5998;
	}

	.socicon-twitter {
		background-color: #55acee;
	}

	.socicon-instagram {
		background: #d6249f;
		background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
	}

	.socicon-whatsapp {
		background-color: #25D366;
	}

	.gridlove-author-links a {
		text-align: center;
		color: #FFF;
		width: 40px;
		border-radius: 50%;
		padding: 10px 0;
		font-size: 16px;
		margin: 0 3px 2px;
		vertical-align: middle;
		transition: all .2s ease-in-out;
	}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<div class="uk-section about-section-shadow">
	<div class="cover-shadow"></div>
	<div class="uk-section-small  uk-padding-remove-bottom  uk-padding-remove-top">
		<div class="team-details-top">
			<div class="uk-container">
				<div class="uk-grid" uk-grid="">
					<div class="uk-width-1-3@m">
						<img src="<?= $jury['image'] ?>" alt="<?= $jury['first_name'] . ' ' . $jury['last_name'] ?>" class="team-photo-img">
					</div>
					<div class="uk-width-2-3@m">
						<div class="team-details">
							<ul class="team-details-list"><?= $jury['profession'] ?></ul>
							<h2><?= $jury['first_name'] . ' ' . $jury['last_name'] ?></h2>
							<p><?= $jury['about'] ?></p>
							<div class="gridlove-author-links ">
								<a href="javascript:void(0);" class="socicon-facebook" uk-icon="facebook" title="facebook" aria-hidden="true" data-title="MiniBoxOffice" data-sharer="facebook" data-url="<?= $actual_link ?>"><span></span></a>
								<a href="javascript:void(0);" class="socicon-twitter" uk-icon="twitter" title="twitter" aria-hidden="true" data-title="MiniBoxOffice" data-sharer="twitter" data-url="<?= $actual_link ?>"><span></span></a>
								<a href="javascript:void(0);" class="socicon-instagram" uk-icon="instagram" title="instagram" data-title="MiniBoxOffice" data-sharer="instagram" data-url="<?= $actual_link ?>"><span></span></a>
								<a href="javascript:void(0);" class="socicon-whatsapp" uk-icon="whatsapp" title="whatsapp" aria-hidden="true" data-title="MiniBoxOffice" data-sharer="whatsapp" data-url="<?= $actual_link ?>"><span></span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="uk-section-small uk-section-default">
	<div class="uk-container">
		<h3 class="about-text-title"><?= $jury['title'] ?></h3>
		<p><?= $jury['content'] ?></p>
	</div>
</section>

<section class="uk-section-small">
	<div class="uk-container">
		<div class="uk-grid" uk-grid="">
			<?php if ($jury['gallery'] && count($jury['gallery'])) : ?>
				<div class="uk-width-1-2@m">
					<div class="uk-child-width-1-3@m uk-grid-small uk-grid" uk-grid="" uk-lightbox="animation: slide">
						<?php foreach ($jury['gallery'] as $gallery) : ?>
							<div class="uk-grid-margin">
								<a class="uk-inline" href="<?= $gallery['image'] ?>">
									<img src="<?= $gallery['image'] ?>">
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($jury['youtube']) : ?>
				<div class="uk-width-1-2@m">
					<article class="gridlove-post gridlove-post-a gridlove-box">
						<div class="entry-image">
							<iframe src="https://www.youtube.com/embed/<?= $jury['youtube'] ?>" width="100%" height="350" frameborder="0" uk-video="" uk-responsive="" class="uk-responsive-width" allow="encrypted-media;"></iframe>
						</div>
					</article>
				</div>
			<?php endif; ?>
			<?php if ($jury['vimeo']) : ?>
				<div class="uk-width-1-2@m">
					<article class="gridlove-post gridlove-post-a gridlove-box">
						<div class="entry-image">
							<iframe src="https://player.vimeo.com/video/<?= $jury['vimeo'] ?>?api=1&amp;player_id=1" width="100%" height="350" frameborder="0" uk-video="" uk-responsive="" class="uk-responsive-width"></iframe>
						</div>
					</article>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?= $this->endSection() ?>


<?= $this->section('js') ?>
<?= $this->endSection() ?>