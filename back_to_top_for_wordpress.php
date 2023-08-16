<?php
function my_custom_script() {
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
			$(document).ready(function() {
			const backToTopBtn = $('#scrollToTopButton');

			backToTopBtn.click(function(event) {
				event.preventDefault();
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			});

			$(window).scroll(function() {
				const screenHeight = $(window).height();
				const scrollThreshold = screenHeight * 0.2; // 20% of screen height

				if ($(window).scrollTop() >= scrollThreshold) {
					backToTopBtn.removeClass('hidden').fadeIn();
				} else {
					backToTopBtn.fadeOut();
				}
			});

			// Initially hide the button on page load
			backToTopBtn.addClass('hidden');
		});


    </script>
    <?php
}
add_action('wp_head', 'my_custom_script');