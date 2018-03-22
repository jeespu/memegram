$(document).ready(function () {


	var signForm = $("#sign-form");
	$(".sign-up, .cancel-btn").on("click", function () {
		signForm.slideToggle("fast");
		signForm.addClass("toggled");
	});

	$("#login").on("click", function () {
		if (signForm.hasClass("toggled")) {
			signForm.slideUp("fast");
		}
	});

	// Add memes test
	$("#test-btn").on("click", function () {
		$(".meme-container").html('<img class="meme-img" src="https://fthmb.tqn.com/onZS-nRlttC_o-4JSQEXImdfL3E=/768x0/filters:no_upscale()/success-56a9fd1f3df78cf772abee09.jpg">');
	})

	$(window).on("scroll", function () {
		var height = window.innerHeight;
		if (window.pageYOffset >= height) {
			console.log("Welcome to the bottom");
			$(".meme-row:last-of-type").css("display", "none");
		}
	})

});