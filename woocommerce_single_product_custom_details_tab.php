<?php
/**
 * Remove product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['additional_information'] );  	// Remove the additional information tab

    return $tabs;
}
/**
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['test_tab'] = array(
		'title' 	=> __( 'Детали', 'woocommerce' ),
		'priority' 	=> 10,
		'callback' 	=> 'woo_new_product_tab_content'
	);

	return $tabs;

}
function woo_new_product_tab_content() {

	if ( ! is_product() ) {
        return;
    }

    $meta_attrs = [
		'isbn' => 'ISBN'
		];

    global $product;
	$product_id = $product->get_id();
    $custom_fields = get_post_custom($product_id);
			echo '<div class="details-tab-container">';
			echo '<li><span>Код товара:</span> ' . esc_html( $product->get_sku() ) . '</li>';
    foreach ($meta_attrs as $meta_key => $label) {
        if (isset($custom_fields[$meta_key][0])) {
            $value = $custom_fields[$meta_key][0];
            echo '<li><span>' . esc_html($label) . ': </span>' . esc_html($value) . '</li>';
        }
	}
			$product_attributes = single_product_attribute_list();

			foreach ($product_attributes as $attribute_name => $attribute_values) {
				$cleaned_name = str_replace('pa_', '', $attribute_name);

				echo '<li><span>' . $cleaned_name . ': </span>';

				if (is_array($attribute_values)) {
					foreach ($attribute_values as $value) {
						if ($cleaned_name === 'автор' || $cleaned_name === 'издательство') {
							$value_slug_prefix = '/' . $cleaned_name . '/';
							$value_slug = sanitize_title($value);
            				$value_url = $value_slug_prefix . $value_slug;
							echo '<a href="' . esc_url($value_url) . '">' . $value . '</a>, ';
						} else {
							echo $value . ', ';
						}
					}
				} else {
					if ($cleaned_name === 'автор' || $cleaned_name === 'издательство') {
							$attribute_values_slug_prefix = '/' . $cleaned_name . '/';
							$attribute_values_slug = sanitize_title($attribute_values);
            				$attribute_values_url = $attribute_values_slug_prefix . $attribute_values_slug;
							echo '<a href="' . esc_url($attribute_values_url) . '">' . $attribute_values . '</a>, ';
					} else {
						echo $attribute_values;
					}
				}

				echo '</li>';
			}
			echo'</div>';
	
}


/**
 * single product attribute list
 */
function single_product_attribute_list()
{  
    global $product;
    if (is_product()) {
        $attributes = [];
    
        // Loop over each attribute and retrieve its values
        foreach ($product->get_attributes() as $attribute) {
            $attribute_name = $attribute->get_name();
            $attribute_values = $product->get_attribute($attribute_name);

            // If the attribute values contain a separator (e.g., comma)
            if (strpos($attribute_values, ',') !== false) {
                $values_array = explode(',', $attribute_values);
                $attributes[$attribute_name] = array_map('trim', $values_array);
            } else {
                $attributes[$attribute_name] = $attribute_values;
            }
        }
    
        return $attributes;
    }
}