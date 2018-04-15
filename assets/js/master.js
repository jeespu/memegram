$(document).ready(function () {
	
	// TEST REFRESH
	// window.setInterval(function () {
	// 	$('.comments').load("feed.php .comment-container", function () { 
	// 		$('[id]').each(function () {
	// 			var ids = $('[id="' + this.id + '"]');
	// 			// remove duplicate IDs
	// 			if (ids.length > 1 && ids[0] == this) {
	// 				$('#' + this.id).remove();
	// 			}
	// 		});
	// 		console.log("deleted duplicate ids");
	// 	})
	// }, 5000)

	// Enable tooltips
	$(function () {
		$('[data-toggle="tooltip"]').tooltip({
			// Add some delay
			delay: { "show": 1000, "hide": 100 }
		})
	})

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
	// 		$(this).children(".item-regular").toggleClass("far").toggleClass("fas");
	// 	},
	// 	mouseleave: function () {
	// 		$(this).children(".item-regular").removeClass("fas").addClass("far");
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
	// Add Comment
	$(".comment-send").on("click", function addComment() {
		var sendBtn = $(this);
		var commentsDiv = $(this).closest(".comments");
		var id = $(this).parents(".meme-container").attr("id"); // Get comment ID
		var commentInput = $(this).prev().val(); // Get input
		$(this).prev().val("");// Clear textarea
		// Build string
		var commentHTML = '<div class="comment-container"><div class="comment-author"><strong>' + loggedUser + '</strong></div><div class="row mx-auto"><div class="comment col-10">' + commentInput + '</div><div class="delete-comment d-flex align-items-center justify-content-center col-2"><i class="far fa-trash-alt item-regular"></i><i class="fas fa-trash-alt item-solid"></i></div></div></div>';
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
				$(".delete-comment").on("click", deleteComment);
			}
		});
		//console.log("btn", sendBtn);
		//console.log("commentsDiv", commentsDiv);
		//console.log("id" + id);
		//console.log("commentInput", commentInput);
		//console.log("commentHtml", commentHTML);
		//console.log("newComment", newComment);
		//console.log("loggedUser", loggedUser);
	});
	// Delete Comment
	$(".delete-comment").on("click", deleteComment)

	// Rate meme
	$(".meme-panel-item.star").on("click", function () {
		$(this).parents(".meme-panel").prev().slideToggle("fast");
	});


	// Show and hide filters on scroll on small devices
	var scrollPos = 0;
	$(window).on("scroll", function () {
		if ($(window).width() <= 768) {
			clearTimeout($.data(this, "scrollTimer"));
			var pos = $(this).scrollTop();
			if (pos > scrollPos) { //Scrolling Down
				$.data(this, "scrollTimer", setTimeout(function () {
					$("#filter").slideUp("fast");
				}, 20));
			} else { //Scrolling Up
				$.data(this, "scrollTimer", setTimeout(function () {
					$("#filter").slideDown("fast");
				}, 50));
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

function deleteComment() {
	$(this).parents(".comment-container").slideUp("fast");

	var comment = $(this).prev().text();
	var id = $(this).parents(".comment-container").attr("id");
	// console.log(ev)
	$.ajax({
		type: "POST",
		url: "deleteComment.php",
		data: {
			deleteID: id,
			deletedComment: comment,
		},
		success: function () {
			console.log("comment deleted");
		}
	})
};

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