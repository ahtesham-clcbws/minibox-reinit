<!-- OFFCANVAS -->
<div id="offcanvas-nav" data-uk-offcanvas="flip: true; overlay: true" class="uk-offcanvas">
	<div class="uk-offcanvas-bar uk-offcanvas-bar-animation uk-offcanvas-slide">
		<button class="uk-offcanvas-close uk-close uk-icon" type="button" data-uk-close=""><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
				<line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>
				<line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>
			</svg></button>
		<ul class="uk-nav uk-nav-default">
			<?= view('Globals/festival_menu') ?>
		</ul>
	</div>
</div>
<!-- /OFFCANVAS -->
<!--HEADER-->
<header>
	<div class="uk-container">
		<nav id="navbar" data-uk-navbar="mode: click;" class="uk-navbar">
			<div class="uk-navbar-left nav-overlay uk-visible@m">
				<a class="uk-visible@s uk-margin-small-right uk-icon" href="https://www.facebook.com/" target="_blank" data-uk-icon="facebook"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path d="M11,10h2.6l0.4-3H11V5.3c0-0.9,0.2-1.5,1.5-1.5H14V1.1c-0.3,0-1-0.1-2.1-0.1C9.6,1,8,2.4,8,5v2H5.5v3H8v8h3V10z">
						</path>
					</svg></a>
				<a class="uk-visible@s uk-margin-small-right uk-icon" href="https://twitter.com/" target="_blank" data-uk-icon="twitter"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path d="M19,4.74 C18.339,5.029 17.626,5.229 16.881,5.32 C17.644,4.86 18.227,4.139 18.503,3.28 C17.79,3.7 17.001,4.009 16.159,4.17 C15.485,3.45 14.526,3 13.464,3 C11.423,3 9.771,4.66 9.771,6.7 C9.771,6.99 9.804,7.269 9.868,7.539 C6.795,7.38 4.076,5.919 2.254,3.679 C1.936,4.219 1.754,4.86 1.754,5.539 C1.754,6.82 2.405,7.95 3.397,8.61 C2.79,8.589 2.22,8.429 1.723,8.149 L1.723,8.189 C1.723,9.978 2.997,11.478 4.686,11.82 C4.376,11.899 4.049,11.939 3.713,11.939 C3.475,11.939 3.245,11.919 3.018,11.88 C3.49,13.349 4.852,14.419 6.469,14.449 C5.205,15.429 3.612,16.019 1.882,16.019 C1.583,16.019 1.29,16.009 1,15.969 C2.635,17.019 4.576,17.629 6.662,17.629 C13.454,17.629 17.17,12 17.17,7.129 C17.17,6.969 17.166,6.809 17.157,6.649 C17.879,6.129 18.504,5.478 19,4.74">
						</path>
					</svg></a>
				<a class="uk-visible@s uk-margin-small-right uk-icon" href="http://instagram.com/" target="_blank" data-uk-icon="instagram"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path d="M13.55,1H6.46C3.45,1,1,3.44,1,6.44v7.12c0,3,2.45,5.44,5.46,5.44h7.08c3.02,0,5.46-2.44,5.46-5.44V6.44 C19.01,3.44,16.56,1,13.55,1z M17.5,14c0,1.93-1.57,3.5-3.5,3.5H6c-1.93,0-3.5-1.57-3.5-3.5V6c0-1.93,1.57-3.5,3.5-3.5h8 c1.93,0,3.5,1.57,3.5,3.5V14z">
						</path>
						<circle cx="14.87" cy="5.26" r="1.09"></circle>
						<path d="M10.03,5.45c-2.55,0-4.63,2.06-4.63,4.6c0,2.55,2.07,4.61,4.63,4.61c2.56,0,4.63-2.061,4.63-4.61 C14.65,7.51,12.58,5.45,10.03,5.45L10.03,5.45L10.03,5.45z M10.08,13c-1.66,0-3-1.34-3-2.99c0-1.65,1.34-2.99,3-2.99s3,1.34,3,2.99 C13.08,11.66,11.74,13,10.08,13L10.08,13L10.08,13z">
						</path>
					</svg></a>
				<a class="uk-visible@s uk-margin-small-right uk-icon" href="http://youtube.com/" target="_blank" data-uk-icon="youtube"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path d="M15,4.1c1,0.1,2.3,0,3,0.8c0.8,0.8,0.9,2.1,0.9,3.1C19,9.2,19,10.9,19,12c-0.1,1.1,0,2.4-0.5,3.4c-0.5,1.1-1.4,1.5-2.5,1.6 c-1.2,0.1-8.6,0.1-11,0c-1.1-0.1-2.4-0.1-3.2-1c-0.7-0.8-0.7-2-0.8-3C1,11.8,1,10.1,1,8.9c0-1.1,0-2.4,0.5-3.4C2,4.5,3,4.3,4.1,4.2 C5.3,4.1,12.6,4,15,4.1z M8,7.5v6l5.5-3L8,7.5z">
						</path>
					</svg></a>
				<a class="uk-visible@s uk-margin-small-right uk-icon" href="https://api.whatsapp.com/send/?phone=917055170325" target="_blank" data-uk-icon="whatsapp"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path d="M16.7,3.3c-1.8-1.8-4.1-2.8-6.7-2.8c-5.2,0-9.4,4.2-9.4,9.4c0,1.7,0.4,3.3,1.3,4.7l-1.3,4.9l5-1.3c1.4,0.8,2.9,1.2,4.5,1.2 l0,0l0,0c5.2,0,9.4-4.2,9.4-9.4C19.5,7.4,18.5,5,16.7,3.3 M10.1,17.7L10.1,17.7c-1.4,0-2.8-0.4-4-1.1l-0.3-0.2l-3,0.8l0.8-2.9 l-0.2-0.3c-0.8-1.2-1.2-2.7-1.2-4.2c0-4.3,3.5-7.8,7.8-7.8c2.1,0,4.1,0.8,5.5,2.3c1.5,1.5,2.3,3.4,2.3,5.5 C17.9,14.2,14.4,17.7,10.1,17.7 M14.4,11.9c-0.2-0.1-1.4-0.7-1.6-0.8c-0.2-0.1-0.4-0.1-0.5,0.1c-0.2,0.2-0.6,0.8-0.8,0.9 c-0.1,0.2-0.3,0.2-0.5,0.1c-0.2-0.1-1-0.4-1.9-1.2c-0.7-0.6-1.2-1.4-1.3-1.6c-0.1-0.2,0-0.4,0.1-0.5C8,8.8,8.1,8.7,8.2,8.5 c0.1-0.1,0.2-0.2,0.2-0.4c0.1-0.2,0-0.3,0-0.4C8.4,7.6,7.9,6.5,7.7,6C7.5,5.5,7.3,5.6,7.2,5.6c-0.1,0-0.3,0-0.4,0 c-0.2,0-0.4,0.1-0.6,0.3c-0.2,0.2-0.8,0.8-0.8,2c0,1.2,0.8,2.3,1,2.4c0.1,0.2,1.7,2.5,4,3.5c0.6,0.2,1,0.4,1.3,0.5 c0.6,0.2,1.1,0.2,1.5,0.1c0.5-0.1,1.4-0.6,1.6-1.1c0.2-0.5,0.2-1,0.1-1.1C14.8,12.1,14.6,12,14.4,11.9">
						</path>
					</svg></a>
			</div>
			<div class="uk-navbar-center nav-overlay">
				<a href="#" class="logo-text uk-navbar-item" title="Logo">
					<div>
						<span class="left-text" id="mylogo" style="font-size: 65px;"> MFF</span>
						<span class="right-text-festival">
							<p id="line1">Mumbai</p>
							<p id="line2">Film</p>
							<p id="line3">Festival</p>
						</span>
						<p class="text-bottom">1<sup>st</sup> Edition | 2022 Mumbai India</p>
					</div>
				</a>
			</div>
			<a href="#" class="logo-text uk-navbar-item" title="Logo">

			</a>
			<div class="uk-navbar-right nav-overlay"><a href="#" class="logo-text uk-navbar-item" title="Logo">
				</a>
				<div class="uk-navbar-item"><a href="#" class="logo-text uk-navbar-item" title="Logo">
					</a><a class="uk-navbar-toggle uk-hidden@m uk-icon uk-navbar-toggle-icon" data-uk-toggle="" data-uk-navbar-toggle-icon="" href="#" aria-expanded="false">
						<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<rect y="9" width="20" height="2"></rect>
							<rect y="3" width="20" height="2"></rect>
							<rect y="15" width="20" height="2"></rect>
						</svg></a>
				</div>
			</div>
			<div class="nav-overlay uk-navbar-left uk-flex-1" hidden="">
				<a class="uk-navbar-toggle uk-icon uk-close" data-uk-close="" data-uk-toggle="target: .nav-overlay; animation: uk-animation-fade" href="#" aria-expanded="true">
					<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
						<line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>
						<line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>
					</svg></a>
			</div>

			<div class="uk-navbar-right nav-overlay uk-visible@m">
				<a class="button" href="#">Early Deadline : 26 Feb 2022</a>

			</div>
		</nav>
	</div>
</header>
<!--/HEADER-->
<!-- NAVIGATION -->
<header id="header" class="uk-section-small uk-visible@m uk-sticky" style="background-color: #fff" data-uk-sticky="show-on-up: true; animation: uk-animation-fade; media: @l">
	<div class="uk-container">
		<nav class="uk-navbar-container uk-navbar-transparent uk-navbar" uk-navbar="">
			<div class="uk-navbar-center">
				<ul class="uk-navbar-nav">
					<?= view('Globals/festival_menu') ?>
				</ul>
			</div>
		</nav>
	</div>
</header>
<div class="uk-sticky-placeholder" style="height: 100px; margin: 0px;" hidden=""></div>