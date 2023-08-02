<?php

/**
 * Attribute selector shortcode
 */

function attribute_selector_shortcode($atts) {
    ob_start();
	$params = shortcode_atts(array(
        'attr_name' => '',  // Empty default value
    ), $atts);

    // Access the book_name parameter
    $attr_name = $params['attr_name'];

    // Check if book_name is empty
    if (empty($attr_name)) {
        echo false;  // Shortcode does nothing
    } else {
		$attributes = [];
    $attribute_slug_prefix = '/' . mb_strtolower($attr_name) . '/'; // Replace with your author slug prefix

    // Get the product attribute slug for authors
    $attribute_slug =  $attr_name; // Replace 'authors' with your actual attribute slug

    // Get all products
    $products = wc_get_products(array(
        'status' => 'publish',
        'limit' => -1,
    ));

    // Loop through each product
    foreach ($products as $product) {
        $product_attributes = $product->get_attribute($attribute_slug);

        // Check if the product has the specified attribute
        if (!empty($product_attributes)) {
            $product_attributes = explode(', ', $product_attributes);

            // Loop through each author and add them to the list
            foreach ($product_attributes as $attribute) {
                $attributes[] = $attribute;
            }
        }
    }

    // Remove duplicate authors
    $attributes = array_unique($attributes);

    // Render the author list
    if (!empty($attributes)) {
        echo '<div class="attribute-list-container">';
		
		echo '<select class="attribute-list-selector" name="attr_list" id="attr_list">';
		echo '<option>' . $attr_name . '</option>';
        foreach ($attributes as $attribute) {
			
            $attribute_slug = sanitize_title($attribute);
            $attribute_url = $attribute_slug_prefix . $attribute_slug;
            echo '<option value="' . esc_url($attribute_url) . '">' . $attribute . '</option>';
        }
        echo '</select>';
		echo '</div>';
    }

    return ob_get_clean();
	}
	
    
}
add_shortcode('attribute_list_shortcode', 'attribute_selector_shortcode');