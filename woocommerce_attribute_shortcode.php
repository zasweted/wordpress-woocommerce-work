<?php

function display_author_on_shop_loop_as_shortcode() {
	
		ob_start();

    $authors = [];
    $author_slug_prefix = '/автор/';    
    $attribute_slug = 'Автор'; 

    // Get all products
    $products = wc_get_products(array(
        'status' => 'publish',
        'limit' => -1,
    ));
   
        $author_names = $product->get_attribute( 'Автор' );

        if ( $author_names ) {
            $authors = explode( ', ', $author_names );

            if ( !empty( $authors ) && count($authors) > 1) {
				$firs_author_name = $authors[0];
				$firs_author_name_slug = sanitize_title($firs_author_name);
				$author_url = '/автор/' . $firs_author_name_slug;
                echo '<div style="display:flex; flex-direction:row; flex-wrap:wrap;justify-content:center;">';
                
				echo '<a class="author-name-excerpt" style="font-size:14px; font-weight:400;" href="' . esc_url( $author_url ) . '">' . esc_html( $firs_author_name ) . ', ...</a>';

                echo '</div>';
            } else {
				$firs_author_name = $authors[0];
				$firs_author_name_slug = sanitize_title($firs_author_name);
				$author_url = '/автор/' . $firs_author_name_slug;
                echo '<div style="display:flex; flex-direction:row; flex-wrap:wrap;justify-content:center;">';
                
				echo '<a class="author-name-excerpt" style="font-size:14px; font-weight:400; " href="' . esc_url( $author_url ) . '">' . esc_html( $firs_author_name ) . '</a>';

                echo '</div>';
			}
        }else{
			echo 'empty';
		}
	return ob_get_clean();
	
}
add_shortcode('author_on_shop_loop_shortcode', 'display_author_on_shop_loop_as_shortcode');


function display_author_on_shop_loop_as_shortcode() {
    ob_start();

    $authors = array();
    $author_slug_prefix = '/автор/'; // Replace with your author slug prefix

    // Get the product attribute slug for authors
    $attribute_slug = 'Автор'; // Replace 'authors' with your actual attribute slug

    // Get all products
    $products = wc_get_products(array(
        'status' => 'publish',
        'limit' => -1,
    ));

    // Loop through each product
    foreach ($products as $product) {
        $product_authors = $product->get_attribute($attribute_slug);

        // Check if the product has the specified attribute
        if (!empty($product_authors)) {
            $product_authors = explode(', ', $product_authors);

            // Loop through each author and add them to the list
            foreach ($product_authors as $author) {
                $authors[] = $author;
            }
        }
    }

    // Remove duplicate authors
    $authors = array_unique($authors);

    // Render the author list
    if ( !empty( $authors ) && count($authors) > 1) {
		$firs_author_name = $authors[0];
		$firs_author_name_slug = sanitize_title($firs_author_name);
		$author_url = '/автор/' . $firs_author_name_slug;
		echo '<div style="display:flex; flex-direction:row; flex-wrap:wrap;justify-content:center;">';
		
		echo '<a class="author-name-excerpt" style="font-size:14px; font-weight:400;" href="' . esc_url( $author_url ) . '">' . esc_html( $firs_author_name ) . ', ...</a>';

		echo '</div>';
	} else {
		$firs_author_name = $authors[0];
		$firs_author_name_slug = sanitize_title($firs_author_name);
		$author_url = '/автор/' . $firs_author_name_slug;
		echo '<div style="display:flex; flex-direction:row; flex-wrap:wrap;justify-content:center;">';
		
		echo '<a class="author-name-excerpt" style="font-size:14px; font-weight:400; " href="' . esc_url( $author_url ) . '">' . esc_html( $firs_author_name ) . '</a>';

		echo '</div>';
	}

    return ob_get_clean();
}
add_shortcode('author_on_shop_loop_shortcode', 'display_author_on_shop_loop_as_shortcode');