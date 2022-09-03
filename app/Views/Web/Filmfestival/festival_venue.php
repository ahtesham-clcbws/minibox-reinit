<?= $this->extend('Layouts/Web/film_festival') ?>

<?= $this->section('css') ?>
<style>
	.timeline {
		display: flex;
		margin: 0 auto;
		flex-wrap: wrap;
		flex-direction: column;
		max-width: 700px;
		position: relative;
	}

	.timeline__content-title {
		font-weight: normal;
		font-size: 66px;
		margin: -10px 0 0 0;
		transition: 0.4s;
		padding: 0 10px;
		box-sizing: border-box;
		color: #fff;
	}

	.timeline__content-desc {
		margin: 0;
		/* font-size: 15px; */
		box-sizing: border-box;
		/* color: rgba(255, 255, 255, 0.7); */
		/* font-weight: normal; */
		/* line-height: 25px; */
	}

	.timeline:before {
		position: absolute;
		left: 50%;
		width: 2px;
		height: 100%;
		margin-left: -1px;
		content: "";
		top: 30px;
		/* background: rgba(255, 255, 255, 0.07); */
	}

	@media only screen and (max-width: 767px) {
		.timeline:before {
			left: 40px;
		}
	}

	.timeline-item {
		padding: 40px 0;
		opacity: 0.3;
		filter: blur(2px);
		transition: 0.5s;
		box-sizing: border-box;
		width: calc(50% - 40px);
		display: flex;
		position: relative;
		transform: translateY(-80px);
	}

	.timeline-item:before {
		content: attr(data-text);
		letter-spacing: 3px;
		width: 100%;
		position: absolute;
		/* color: rgba(255, 255, 255, 0.5); */
		font-size: 15px;
		border-left: 2px solid rgba(0, 0, 0);
		top: 70px;
		margin-top: -5px;
		padding-left: 15px;
		opacity: 0;
		right: calc(-100% - 56px);
	}

	.timeline-item:nth-child(even) {
		align-self: flex-end;
	}

	.timeline-item:nth-child(even):before {
		right: auto;
		text-align: right;
		left: calc(-100% - 56px);
		padding-left: 0;
		border-left: none;
		border-right: 2px solid rgba(255, 255, 255, 0.5);
		padding-right: 15px;
	}

	.timeline-item--active {
		opacity: 1;
		transform: translateY(0);
		filter: blur(0px);
	}

	.timeline-item--active:before {
		top: 50%;
		transition: 0.3s all 0.2s;
		opacity: 1;
	}

	.timeline-item--active .timeline__content-title {
		margin: -50px 0 0 0;
		text-shadow: 3px 3px 12px black;
		font-weight: 700;
		/* -webkit-text-stroke: 2px #fff; */
		/* -webkit-text-fill-color: transparent; */
	}

	@media only screen and (max-width: 767px) {
		.timeline-item {
			align-self: baseline !important;
			width: 100%;
			padding: 0 30px 150px 80px;
		}

		.timeline-item:before {
			left: 10px !important;
			padding: 0 !important;
			top: 50px;
			text-align: center !important;
			width: 60px;
			border: none !important;
		}

		.timeline-item:last-child {
			padding-bottom: 40px;
		}
	}

	.timeline__img {
		max-width: 100%;
		box-shadow: 0 10px 15px rgba(0, 0, 0, 0.4);
	}

	.timeline-container {
		width: 100%;
		position: relative;
		padding: 80px 0;
		transition: 0.3s ease 0s;
		/* background-attachment: fixed; */
		/* background-size: cover; */
	}

	.timeline-container:before {
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		/* background: rgba(99, 99, 99, 0.8); */
		content: "";
	}

	.timeline-header {
		width: 100%;
		text-align: center;
		margin-bottom: 80px;
		position: relative;
	}

	.timeline-header__title {
		/* color: #fff; */
		font-size: 46px;
		font-weight: normal;
		margin: 0;
	}

	.timeline-header__subtitle {
		/* color: rgba(255, 255, 255, 0.5); */
		font-size: 16px;
		letter-spacing: 5px;
		margin: 10px 0 0 0;
		font-weight: normal;
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
<div class="venue-timeline">

<?= view('Components/pageData'); ?>

	<div class="timeline-container" id="timeline-1">
		<!-- <div class="timeline-header about-section">
			<h2 class="">Venue's</h2>
			<h2 class="timeline-header__title"></h2>
			<h3 class="timeline-header__subtitle">FATHER OF THE TURKS</h3>
		</div> -->
		<div class="timeline">

			<?php foreach ($venues as $key => $item) : ?>
				<div class="timeline-item" data-text="<?= strtoupper($item['title']) ?>">
					<div class="timeline__content"><img class="timeline__img" src="<?= $item['image'] ?>" />
						<h2 class="timeline__content-title"><?= $item['festival_year'] ?></h2>
						<span class="timeline__content-desc"><?= $item['content'] ?></span>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
	(function($) {
		$.fn.timeline = function() {
			var selectors = {
				id: $(this),
				item: $(this).find(".timeline-item"),
				activeClass: "timeline-item--active",
				// img: ".timeline__img"
			};
			selectors.item.eq(0).addClass(selectors.activeClass);
			// selectors.id.css(
			// 	"background-image",
			// 	"url(" +
			// 	selectors.item
			// 	.first()
			// 	.find(selectors.img)
			// 	.attr("src") +
			// 	")"
			// );
			var itemLength = selectors.item.length;
			$(window).scroll(function() {
				var max, min;
				var pos = $(this).scrollTop();
				selectors.item.each(function(i) {
					min = $(this).offset().top;
					max = $(this).height() + $(this).offset().top;
					var that = $(this);
					if (i == itemLength - 2 && pos > min + $(this).height() / 2) {
						selectors.item.removeClass(selectors.activeClass);
						selectors.id.css(
							"background-image",
							"url(" +
							selectors.item
							.last()
							.find(selectors.img)
							.attr("src") +
							")"
						);
						selectors.item.last().addClass(selectors.activeClass);
					} else if (pos <= max - 40 && pos >= min) {
						selectors.id.css(
							"background-image",
							"url(" +
							$(this)
							.find(selectors.img)
							.attr("src") +
							")"
						);
						selectors.item.removeClass(selectors.activeClass);
						$(this).addClass(selectors.activeClass);
					}
				});
			});
		};
	})(jQuery);

	$("#timeline-1").timeline();
</script>
<?= $this->endSection() ?>