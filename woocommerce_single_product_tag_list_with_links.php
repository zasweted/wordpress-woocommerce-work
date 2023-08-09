<?php
function custom_product_tags()
{
	
	global $product;
	
	// Get the product ID
    $product_id = $product->get_id();

    // Get an array of product tags for the current product
    $product_tags = wp_get_post_terms($product_id, 'product_tag');
	if (!empty($product_tags) && !is_wp_error($product_tags)) {
        echo '<div class="product-authors-container-single-page">';
        echo '<h4>Темы:</h4>';
        echo '<p class="author-par">';
        foreach ($product_tags as $index => $tag) {
            echo '<a href="' . get_term_link($tag) . '">' . $tag->name . '</a>';
            
            // Add a comma and space after each tag except the last one
            if ($index < count($product_tags) - 1) {
                echo ', ';
            }
        }
        echo '</p>';
        echo '</div>';
    }
	
	
}

add_action('woocommerce_share', 'custom_product_tags', 10);