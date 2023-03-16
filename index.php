<?php
include 'lib/Session.php';
Session::init();
include 'lib/Database.php';
include 'helpers/Format.php';
include 'config/config.php';

spl_autoload_register(function($class){
	include_once "classes/".$class.".php";
});

$db = new Database();
$fm = new Format();
$pd = new Product();
$cat = new Category();

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" https="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script https="cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script https="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script https="unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <title>Admin Panel</title>
</head>
<body>
    <!-- /* Please ❤ this if you like it! 😊 */ -->

<!-- Portfolio Section Start -->
<section class="portfolio overflow-hidden">
	<div class="container">
		<div class="row">
			<!-- Portfolio Section Heading -->
			<div class="portfolio__heading text-center col-12">
				<h1 class="portfolio__title fw-bold mb-5">Our Portfolio</h1>
			</div>
			<!-- Portfolio Navigation Buttons List -->
			<div class="col-12">
				<ul class="portfolio__nav nav justify-content-center mb-4">
				<?php 
             $getFpd = $cat->getCat();
			 if ($getFpd) {
				while ($result = $getFpd->fetch_assoc()) {
		?>
					<li class="nav-item">
						<button class="portfolio__nav__btn position-relative bg-transparent border-0 active" data-filter="*">All</button>
					</li>
					<li class="nav-item">
						<button class="portfolio__nav__btn position-relative bg-transparent border-0" data-filter="?catId=<?php echo $result['catId'];?>"><?php echo $result['catName'];?></button>
				</li>
					<?php }} ?>
				</ul>
			</div>
		</div>
		<!-- Portfolio Cards Container -->
		<?php 
             $getFpd = $pd->getFeatured();
			 if ($getFpd) {
				while ($result = $getFpd->fetch_assoc()) {
		?>
		<div class="row grid">
			<div class="grid-item col-lg-4 col-sm-6 vehicle">
				<a href="" class="portfolio__card position-relative d-inline-block w-100">
					<img src="admin/<?php echo $result['image']; ?>" alt="Random Image" class="w-100">
				</a>
			</div>
			<?php }} ?>
		</div>
	</div>
</section>
<!-- Portfolio Section End -->
<script>
(function ($) {
	"use strict";

	$(window).on("load", function () {
		isotopeInit();
	});

	/* Isotope Init */
	function isotopeInit() {
		$(".grid").isotope({
			itemSelector: ".grid-item",
			layoutMode: "fitRows",
			masonry: {
				isFitWidth: true
			}
		});

		// filter items on button click
		$(".portfolio__nav__btn").on("click", function () {
			var filterValue = $(this).attr("data-filter");
			$(".grid").isotope({ filter: filterValue });

			// Toggle active class on button click
			$(".portfolio__nav__btn").removeClass("active");
			$(this).addClass("active");
		});
	}
	
})(jQuery);
</script>
</body>
</html>