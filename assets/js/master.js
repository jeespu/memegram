$(document).ready(function () {

	// Sign Up Form
	$(".sign-up, .cancel-btn").on("click", function () {
		$("#sign-form").slideToggle("fast");
		if (window.innerWidth <= 768) {
			$(".nav-item>.sign-up").on("click", function () { 
				$("#sign-form:hidden").slideDown("fast");
				$(".navbar-toggler").click();
			})
		}
	});

	// Add Memes Form
	$(".add-meme").on("click", function () {
		$("#add-meme-form").slideToggle("fast");
		// if (window.innerWidth <= 768) {
		// 	$(".nav-item>.profile-link").on("click ", function () {
		// 		$("add-meme-form:hidden").slideDown("fast");
		// 		$(".navbar-toggler").click();
		// 	})
		// }
	});
	$(".fake-pic-button").on("click", function (ev) {
		ev.preventDefault();	
		$(".pic-input").click();
	})

	$("#login-dropdown").on("click", function (ev) {
		$("#sign-form:visible").slideUp("fast");
	});
	// Prevent login form hiding
	$("#login, #login>form>input").click(function (ev) { 
		ev.stopPropagation();
	})

	$(".meme-img").on("click", function () {
		// console.log($(this).children().attr("src"));
		$("#pop-up").children().attr("src", $(this).children().attr("src"));
		$("#pop-up").fadeIn("fast", function () {
			$(this).css("display", "flex");
		});

	});
	$("#pop-up").on("click", function () {
		$(this).fadeOut("fast");
	});

	// Notification banner
	$(".notification").slideDown("fast").css("display", "flex");
	window.setTimeout(function () {
		$(".notification").slideUp("fast");
	}, 2000);

	// Filter list Effects
	$("#filter>li>a").on({
		mouseover: function () {
			if (!$(this).prev("div").children(".item-solid").hasClass("clicked"))
				$(this).prev("div").children().toggle();
		},
		mouseleave: function () {
			if (!$(this).prev("div").children(".item-solid").hasClass("clicked"))
				$(this).prev("div").children().toggle();
		},
		click: function () { 
			$("#filter>li>a").prev("div").children(".item-solid").hide();
			$("#filter>li>a").prev("div").children(".item-regular").show();
			$("#filter>li>a").prev("div").children(".item-solid").removeClass("clicked");
			$(this).prev("div").children(".item-solid").addClass("clicked");
			$(this).prev("div").children().toggle();
		}
	});

	// Meme-panel Effects
	// $(".meme-panel-item").on({
	// 	mouseover: function () {
	// 		if (!$(this).children(".item-solid").hasClass("clicked"))
	// 			$(this).children().toggle();
	// 	},
	// 	mouseleave: function () {
	// 		if (!$(this).children(".item-solid").hasClass("clicked"))
	// 			$(this).children().toggle();
	// 	},
	// 	click: function () {
	// 		if (!$(this).children(".item-solid").hasClass("clicked")) {
	// 			$(".meme-panel-item").children(".item-solid").hide().removeClass("clicked");
	// 			$(".meme-panel-item").children(".item-regular").show();
	// 			$(this).children(".item-solid").addClass("clicked");
	// 			$(this).children().toggle();
	// 		} else {
	// 			$(this).children(".item-solid").removeClass("clicked");
	// 		}
	// 	}
	// });

	// Toggle Comment Section
	$(".meme-panel-item>.fa-comment").parent().on("click", function (ev) {
		$(this).parents(".meme-panel").next().slideToggle("fast");
	});
	// Resize text-area automatically
	autosize($('textarea'));
	// Submit on enter
	$('textarea').on("keydown", function (ev) {
		//ev.preventDefault();
		if (ev.which === 13) {
			$(this).parent().submit();
		}
	});
	// Delete Comment
	$(".delete-comment").on("click", function (ev) {
		$(this).parents(".comment-container").slideUp("fast");
		var id = $(this).parents(".comment-container").attr("id");
		// console.log(ev)
		$.ajax({
			type: "POST",
			url: "deleteComment.php",
			data: { deleteID: id },
			success: function () {
				console.log("comment deleted");
			}
		});
	});

	// Add Comment
	$(".comment-send").on("click", function addComment() {
		//var loggedUser = <?php echo json_encode($_SESSION['logged_user']) ?>
		var sendBtn = $(this);
		var commentsDiv = $(this).closest(".comments");
		var id = $(this).parents(".meme-container").attr("id"); // Get comment ID
		var commentInput = $(this).prev().val(); // Get input
		// Build string
		var commentHTML = '<comment-container"><div class="comment-author"><strong>' + loggedUser + '</strong></div><div class="row mx-auto"><div class="comment col-10">' + commentInput + '</div></div></div>';
		// String for new comment div
		var newComment = '<div class="comment-container new-comment"><div class="comment-author"><strong>New comment:</strong></div><div class="comment"><div><input type="hidden"><textarea placeholder="comment" maxlength="255"></textarea><button class="orange-btn btn btn-warning btn-sm comment-send">Send</button></div></div></div></div></div>';
		$.ajax({
			type: "POST",
			url: "comment.php",
			data: {
				comment: commentInput,
				postID: id,
			},
			success: function () {
				console.log("comment sent");
				sendBtn.closest(".comment-container").before(commentHTML);
				//commentsDiv.append(newComment);
				//$(".comment-send").one("click", addComment);
				// error: console.log("some error happened?"), mysterious error?
			}	
		});	
		console.log("btn", sendBtn);
		console.log("commentsDiv", commentsDiv);
		console.log("id" + id);
		//console.log("commentInput", commentInput);
		console.log("commentHtml", commentHTML);
		//console.log("newComment", newComment);
		//console.log("loggedUser", loggedUser);
	});

	// Rate meme
	$(".rating").starRating({
		initialRating: 4,
		strokeColor: '#894A00',
		strokeWidth: 10,
		starSize: 25
	});
	$('[data-toggle="tooltip"]').tooltip({
		html: true,
		title: $(".tooltip").html(),
	});

	// Show and hide filters on scroll on small devices
	var scrollPos = 0;
	$(window).on("scroll", function () {
		if ($(window).width() <= 768) {
			// clearTimeout($.data(this, "scrollTimer"));
			var pos = $(this).scrollTop();
			if (pos > scrollPos) { //Scrolling Down
				$.data(this, "scrollTimer", setTimeout(function () {
				$("#filter").slideUp("fast");
				}, 50));
			} else { //Scrolling Up
				$("#filter").slideDown("fast");
			}
			scrollPos = $(this).scrollTop();
		}
	});

	// Disable hover effects on touch
	watchForHover();



	// Infinity scroll
	// $(window).on("scroll", function () {
	// 	var height = $(this).height();
	// 	var maxH = $(document).height() - height;
	// 	if ($(this).scrollTop() + height === $(document).height()) {
	// 		console.log("Welcome to the bottom");
	// 	}
	// });

});

// function ajaxComment(comment, id, btn, commentsDiv, newComment) {
// 	$.ajax({
// 		type: "POST",
// 		url: "comment.php",
// 		data: {
// 			comment: comment,
// 			postID: id,
// 		},
// 		success: function () {
// 			console.log("comment sent");
// 			btn.closest(".comment-container").html(comment);
// 			commentsDiv.append(newComment);
// 		},
// 		// error: console.log("some error happened?"), mysterious error?
// 	});
// }

function watchForHover() {
	var hasHoverClass = false;
	var container = document.body;
	var lastTouchTime = 0;

	function enableHover() {
		// filter emulated events coming from touch events
		if (new Date() - lastTouchTime < 250) return;
		if (hasHoverClass) return;

		container.className += ' hasHover';
		hasHoverClass = true;
	}

	function disableHover() {
		if (!hasHoverClass) return;

		container.className = container.className.replace(' hasHover', '');
		hasHoverClass = false;
	}

	function updateLastTouchTime() {
		lastTouchTime = new Date();
	}

	document.addEventListener('touchstart', updateLastTouchTime, true);
	document.addEventListener('touchstart', disableHover, true);
	document.addEventListener('mousemove', enableHover, true);

	enableHover();
}

// function toggleSolid(ev) {
// 	var regular = $(this).prev("div").children(".item-regular");
// 	var solid = $(this).prev("div").children(".item-solid");
// 	if (regular.is(":visible") || solid.is(":hidden")) {
// 		regular.hide();
// 		solid.fadeIn("fast");
// 	} else {
// 		regular.fadeIn("fast");
// 		solid.hide();
// 	}
// };

// function ajaxComment() { 
// 	$.ajax({
// 		type: "POST",
// 		url: "comment.php",
// 		data: {
// 			comment: commentInput,
// 			postID: id,
// 		},
// 		success: function () {
// 			console.log("comment sent");
// 			sendBtn.closest(".comment-container").html(commentHTML);
// 			// error: console.log("some error happened?"), mysterious error?
// 		}
// 	});
// }