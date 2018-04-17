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
	if (window.innerWidth > 768) {
		$(function () {
			$('[data-toggle="tooltip"]').tooltip({
				// Add some delay
				delay: { "show": 1000, "hide": 100 }
			})
		})
	}

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
	$(".meme-panel-item>.fa-comment").parent().on("click", showComments);
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
	$(".comment-send").on("click", addComment);
	// Delete Comment
	$(".delete-comment").one("click", deleteComment)

	// Rate meme
	$(".meme-panel-item.star").on("click", showStars);


	// Show and hide filters on scroll on small devices
	var scrollPos = 0;
	$(window).on("scroll", function () {
		if ($(window).width() <= 768) {
			clearTimeout($.data(this, "scrollTimer"));
			var pos = $(this).scrollTop();
			if (pos > scrollPos && pos > 0) { //Scrolling Down
				//$.data(this, "scrollTimer", setTimeout(function () {
					$("#filter").slideUp("fast");
				//}, 150));
			} else { //Scrolling Up
				$.data(this, "scrollTimer", setTimeout(function () {
					$("#filter").slideDown("fast");
				}, 150));
			}
			scrollPos = $(this).scrollTop();
		}
	});

	$("#top-rated").on("click", function () { 
		console.log("Re-ordering");
		$(".meme-row").fadeOut();
		$("#loader").show();
		$(".meme-row").load("orderFeed.php", function () { 
			// Reattach event handlers
			reattachHandlers();
		});
	})

	// Disable hover effects on touch
	watchForHover();

});

function addComment() {
		var sendBtn = $(this);
		var commentsDiv = $(this).closest(".comments");
		var id = $(this).parents(".meme-container").attr("id"); // Get postID
		var commentInput = $(this).prev().val(); // Get input
		$(this).prev().val("");// Clear textarea
		// Build string
		var commentHTML = '<div class="comment-container slide-down"><div class="comment-author"><strong>' + loggedUser + '</strong></div><div class="row mx-auto"><div class="comment col-10">' + commentInput + '</div><div class="delete-comment d-flex align-items-center justify-content-center col-2"><i class="far fa-trash-alt item-regular"></i><i class="fas fa-trash-alt item-solid"></i></div></div></div>';
		$.ajax({
			type: "POST",
			url: "comment.php",
			data: {
				comment: commentInput,
				postID: id,
			},
			dataType: 'json',
			success: function (data) {
				console.log("comment sent with id " + data.lastCommentID);
				sendBtn.closest(".comment-container").before(commentHTML);
				sendBtn.closest(".comment-container").prev(".comment-container").attr("id", data.lastCommentID);
				$(".delete-comment").one("click", deleteComment);
			}
		});
		//console.log("btn", sendBtn);
		//console.log("commentsDiv", commentsDiv);
		//console.log("id" + id);
		//console.log("commentInput", commentInput);
		//console.log("commentHtml", commentHTML);
		//console.log("newComment", newComment);
		//console.log("loggedUser", loggedUser);
	}

function showComments() {
	$(this).parents(".meme-panel").next().slideToggle("fast");
}

function showStars() { 
	$(this).parents(".meme-panel").prev().slideToggle("fast");
}

function deleteComment() {
	$(this).parents(".comment-container").slideUp("fast");

	//var comment = $(this).prev().text();
	var id = $(this).parents(".comment-container").attr("id");
	// console.log(ev)
	$.ajax({
		type: "POST",
		url: "deleteComment.php",
		data: {
			deleteID: id,
			//deletedComment: comment,
		},
		success: function () {
			console.log("comment deleted");
		}
	})
};

function reattachHandlers() { 
	// Remove previous handlers
	$(".meme-img").off("click");
	$(".meme-panel-item>.fa-comment").parent().off("click", showComments);
	$(".comment-send").off("click", addComment);
	$(".meme-panel-item.star").off("click", showStars);
	// Reattach  handlers
	$(".comment-send").on("click", addComment);
	$(".delete-comment").one("click", deleteComment)
	$(".meme-panel-item>.fa-comment").parent().on("click", showComments);
	$(".meme-img").on("click", function () {
		$("#pop-up").children().attr("src", $(this).children().attr("src"));
		$("#pop-up").fadeIn("fast", function () {
			$(this).css("display", "flex");
		});
	});
	$(".ratings").starRating({
		//initialRating: $(this).attr("id"),
		useFullStars: true,
		strokeColor: '#351b5d',
		strokeWidth: 0,
		starSize: 25,
		starShape: 'rounded',
		hoverColor: '#f58928',
		activeColor: '#f58928',
		ratedColor: '#f07408',
		// useGradient: true,
		starGradient: {
			start: '#f58928',
			end: '#f07408'
		},
		callback: function (currentRating, $el) {
			var id = $el.parents(".meme-container").attr("id");
			//console.log($el);
			$.ajax({
				type: "POST",
				url: "rate.php",
				data: {
					rating: currentRating,
					postID: id,
				},
				//dataType: 'json',
				success: function () {
					console.log("Rated: " + currentRating + " stars to post ID " + id);
					//$el.attr("data-rating", data.avgRating)
				}
			});
		},
	})
	$(".meme-panel-item.star").on("click", showStars);
}

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