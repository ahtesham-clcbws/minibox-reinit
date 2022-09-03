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
	<?php if (isset($loadSelect2) && $loadSelect2 == true) : ?>
		<link href="/public/libs/select2/select2.min.css" rel="stylesheet" />
	<?php endif; ?>

	<?= $this->renderSection('css') ?>

</head>

<body>
	<?= view('Globals/main_header') ?>
	<?= $this->renderSection('content') ?>

	<?= view('Globals/main_footer') ?>

	<!-- JS FILES -->
	<script defer src="/public/libs/fontawesome/js/all.js"></script>
	<?= view('Globals/load_global_libraries') ?>
	<?php
	if (isset($optionalJs) && $optionalJs == true) {
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
	<script src="/public/js/custom.js"></script>
	<?= $this->renderSection('js') ?>

</body>

</html>