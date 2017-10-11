$(function () {
	
	var separator = ":SEPARATOR:",
		$stars = $(".mainform .js-stars > .star"),
		$starsWrapper = $stars.parent(),
		selectedRating = 0;
		
	validateForm();
	
	$(".preview_form").on("submit", function (e) {
		
		validateForm();
		
		var reviewPlus = $("[name=REVIEW_TEXT_plus]").val(),
			reviewMinus = $("[name=REVIEW_TEXT_minus]").val(),
			reviewComment = $("[name=REVIEW_TEXT_comment]").val(),
			$reviewText = $("[name=REVIEW_TEXT]");
			
		$reviewText.val(
			selectedRating +
			separator +
			reviewPlus +
			separator +
			reviewMinus + 
			separator + 
			reviewComment
		);
	});
	
	$('[name=REVIEW_TEXT_comment]').on("keyup", function (e) {
		validateForm();
	});
	
	$stars.on("mouseenter", function () {
		var $this = $(this),
			index = $this.data('index');
		$starsWrapper.removeClass("rating-" + selectedRating);
		
		$stars.filter(":lt(" + index + ")").addClass("selected");
	});
	
	$stars.on("mouseleave", function () {
		var $this = $(this);
		$stars.removeClass("selected");
		$starsWrapper.addClass("rating-" + selectedRating);
	});
	
	$stars.on("click", function () {
		var $this = $(this),
			index = $this.data('index');
			
		if(selectedRating == index) {
			$starsWrapper.removeClass("rating-" + selectedRating);
			selectedRating = 0;
			return false;
		}
		if(selectedRating != 0) {
			$starsWrapper.removeClass("rating-" + selectedRating);
		}
		$starsWrapper.addClass("rating-" + index);
		selectedRating = index;
	});
	
	$("[name=send_button]").on("click", function (event) {
		validateForm(e);
	});
	
	function validateForm(event) {
		var $comment = $('[name=REVIEW_TEXT_comment]'),
		isError = false;
		
		if($comment.val() && $comment.val().trim() != '') {
			$("[name=send_button]").prop("disabled", false);
			isError = true;
		} else {
			$("[name=send_button]").prop("disabled", true);
		} 

		if(event && event.preventDefault && isError) {
			event.preventDefault();
		}
	}
});