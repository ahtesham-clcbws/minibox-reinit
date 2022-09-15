<!DOCTYPE html>

<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mini Box Office</title>
	<!-- CSS FILES -->
	<?= $this->renderSection('css') ?>
	<script>
		var defaultProfilePic = '/public/images/avatar.jpg';
		var placeholder2 = '/public/images/placeholder2.jpg';
		var commonFunctions = '<?= route_to('commonFunctions') ?>';
	</script>
	<link rel="stylesheet" type="text/css" href="/public/css/uikit.min.css">
	<link rel="stylesheet" type="text/css" href="/public/css/style.css">
	<style>
		.spinnerActivated {
			overflow: hidden;
		}

		#customLoader {
			position: fixed;
			height: 100vh;
			width: 100%;
			top: 0;
			left: 0;
			background: #3d3d3d87;
			z-index: 9999999;
			display: none;
		}

		#customLoader .loaderBlock {
			position: relative;
			height: 100%;
			width: 100%;
		}
		#customLoader .loaderBlock .loaderBlockInner {
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			position: absolute;
		}
	</style>
	<div id="customLoader">
		<div class="loaderBlock">
			<div class="loaderBlockInner">
				<span uk-spinner="ratio: 4.5" style="color: yellow;"></span>
			</div>
		</div>
	</div>
	<?php if (isset($loadSelect2) && $loadSelect2 == true) : ?>
		<link href="/public/libs/select2/select2.min.css" rel="stylesheet" />
	<?php endif; ?>

	<?= $this->renderSection('css') ?>

</head>

<body>
	<?= view('Globals/main_header') ?>

	<?= $this->renderSection('content') ?>

	<?= view('Globals/main_footer') ?>

	<div id="youtubeModal" class="uk-modal-container" uk-modal>
		<div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
			<button class="uk-modal-close-outside" type="button" uk-close></button>
			<iframe id="youtubeModalIframe" src="" width="1280" height="720" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen uk-video uk-responsive></iframe>
		</div>
	</div>

	<div id="vimeoModal" class="uk-modal-container" uk-modal>
		<div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
			<button class="uk-modal-close-outside" type="button" uk-close></button>
			<iframe id="vimeoModalIframe" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen width="1280" height="720" uk-video uk-responsive></iframe>
		</div>
	</div>
	<!-- JS FILES -->
	<script defer src="/public/libs/fontawesome/js/all.js"></script>
	<?= view('Globals/load_global_libraries') ?>
	
	<?php if (isset($optionalJs) && $optionalJs == true) {
		echo view('Globals/load_extra_libraries'); ?>
		<script>
			$('.youtube').lazyTube({
				targetHandlers: {
					// Create your function here, its name must match the data-target attribute
					magnificPopup: function(options, params) {
						// Here you'll get two parameters, options and params:
						//  - options is a hash with the specified options for the .lazyTube call
						//  - params is a hash with the extracted data-* attributes (such as width, height, autoplay, etc.)
						// 	$.magnificPopup.open({
						// 		items: [{
						// 			src: 'https://www.youtube.com/watch/?v=' + params.id,
						// 			type: 'iframe'
						// 		}]
						// 	});
						// As you can see, we're just using magnificPopup's API to launch the video
					}
				}
			});

			$('.vimeo').lazyTube({

				thumbnailCode: function(el, id, thumbnail) {
					return '<img src="https://i.vimeocdn.com/video/' + el.data('thumbnail') + '.jpg" alt="" />';
				},
				targetHandlers: {
					// Create your function here, its name must match the data-target attribute
					magnificPopup: function(options, params) {
						// Here you'll get two parameters, options and params:
						//  - options is a hash with the specified options for the .lazyTube call
						//  - params is a hash with the extracted data-* attributes (such as width, height, autoplay, etc.)
						// 	$.magnificPopup.open({
						// 		items: [{
						// 			src: 'https://player.vimeo.com/video/' + params.id,
						// 			type: 'iframe'
						// 		}]

						// 	});
						// console.log('https://player.vimeo.com/video/' + params.id);

						// As you can see, we're just using magnificPopup's API to launch the video
					}
				}

			});
		</script>
	<?php } ?>
	<script type="text/javascript" src="/public/libs/jquery.visible.js"></script>
	<?php if (isset($loadSelect2) && $loadSelect2 == true) : ?>
		<script src="/public/libs/select2/select2.min.js"></script>
	<?php endif; ?>
	<?= isset($paymentAssets) && $paymentAssets == true ? view('Globals/load_payment_libraries') : '' ?>
	<script src="/public/js/custom.js"></script>
	<?= $this->renderSection('js') ?>

</body>

</html>