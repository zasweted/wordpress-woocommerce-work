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
			echo '<li><span>SKU:</span> ' . esc_html( $product->get_sku() ) . '</li>';
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
					echo $value . ', ';
				}
			} else {
				echo $attribute_values;
			}

			echo '</li>';
		}			
			echo'</div>';
	
}