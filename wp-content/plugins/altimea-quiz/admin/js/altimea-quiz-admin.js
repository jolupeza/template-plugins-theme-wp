(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

  $(function() {
    $("#post-body-content").prepend('<div id="quiz_error" class="error" style="display:none" ></div>');

    $('#post').submit(function() {
      if ( $("#post_type").val() === 'altimea_quiz' ) {
        return wpq_validate_quizes();
      }
    });
  });

  let wpq_validate_quizes = function() {
    const quizError = $("#quiz_error");
    let err = 0;

    quizError.html("").hide();

    if ($("#title").val().trim() === '') {
      quizError.append("<p>Please enter Question Title.</p>");
      err++;
    }

    var correct_answer = $("#correct_answer").val();
    if ($("#quiz_answer"+correct_answer).val().trim() === "") {
      quizError.append("<p>Correct answer cannot be empty.</p>");
      err++;
    }

    if (err > 0) {
      $("#publish").removeClass("button-primary-disabled");
      $(".spinner").hide();
      $("#quiz_error").show();

      return false;
    }

    return true;
  };
})( jQuery );
