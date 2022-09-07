<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('css') ?>
<style>
	/* .sharingBlock .meks_ess {
        background: #FFF;
        padding: 16px;
        text-align: center;
        margin-bottom: 0;
    } */
	.summary {
		margin-top: 10px;
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
<div class="uk-section-small detail-page-bg">
	<div class="uk-container">
		<div class="uk-text-center uk-grid" uk-grid="masonry: true">

			<?php foreach ($entities as $tKey => $entity) : ?>
				<div class="uk-width-1-3@m">
					<article class="uk-card uk-card-default uk-card-hover uk-card-body uk-padding-remove smallArticle">
						<?php if ($entity['media_type'] === 'image') : ?>
							<a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, $entityType, base64_encode($entity['news_id'])) ?>">
								<!-- <figure style="background-image:url();height: 230px;  background-position: center center;  background-size: cover;  background-repeat: no-repeat;"></figure> -->
								<img src="<?= $entity['media_url'] ?>">
							</a>
						<?php endif; ?>
						<?php if ($entity['media_type'] === 'video') : ?>
							<?php if ($entity['video_type'] === 'youtube') : ?>
								<figure class="videoThumb" style="background-image:url(https://img.youtube.com/vi/<?= $entity['media_url'] ?>/mqdefault.jpg);"></figure>
								<a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, $entityType, base64_encode($entity['news_id'])) ?>">
									<span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon youtubeIcon youtubeThumb"></span>
								</a>
							<?php endif; ?>
							<?php if ($entity['video_type'] === 'vimeo') : ?>
								<figure class="videoThumb" style="background-image:url(https://vumbnail.com/<?= $entity['media_url'] ?>.jpg);"></figure>
								<a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, $entityType, base64_encode($entity['news_id'])) ?>">
									<span uk-icon="icon: play-circle; ratio: 3.5" class="videoIcon vimeoIcon vimeoThumb"></span>
								</a>
							<?php endif; ?>
						<?php endif; ?>

						<!-- <div class="youtube"><a href="#" class="preview"><img src="//img.youtube.com/vi/DsqFL6_Q_cI/mqdefault.jpg" alt="" width="100%"></a></div> -->

						<div class="box-inner-p">
							<div class="box-inner-ellipsis">
								<div style="margin: 0px; padding: 0px; border: 0px;">
									<h2 class="entry-title h3">
										<a href="<?= route_to('festival_filmzine_media_single', $festivalSlug, $entityType, base64_encode($entity['news_id'])) ?>">
											<?= $entity['title'] ?>
										</a>
									</h2>
									<?= !empty($entity['summary']) ? '<p class="uk-text-left summary">' . $entity['summary'] . '</p>' : '' ?>
								</div>
							</div>
						</div>
					</article>
				</div>
			<?php endforeach; ?>

			<!-- <div class="uk-width-1-3@m">
                <article class="uk-card uk-card-default uk-card-hover uk-card-body uk-padding-remove">
                    <div class="youtube"><a href="#" class="preview"><img src="//img.youtube.com/vi/DsqFL6_Q_cI/mqdefault.jpg" alt="" width="100%"></a></div>

                    <div class="box-inner-p">
                        <div class="box-inner-ellipsis">
                            <div style="margin: 0px; padding: 0px; border: 0px;">
                                <h2 class="entry-title h3">
                                    <a href="#">
                                        Are rock concerts really coming back into fashion?
                                    </a>
                                </h2>
                                <p class="uk-text-left">Monotonectally pursue backward-compatible ideas without empowered imperatives. Interactively predomi... </p>
                            </div>
                        </div>
                    </div>
                </article>
            </div> -->

		</div>
	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?= $this->endSection() ?>