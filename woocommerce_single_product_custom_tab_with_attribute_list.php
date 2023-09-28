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

    global $product;
	$product_id = $product->get_id();
			echo '<div class="details-tab-container">';
			echo '<li><span>Код товара:</span> ' . esc_html( $product->get_sku() ) . '.</li>';
    		global $product;

				$formatted_attributes = array();

				$attributes = $product->get_attributes();

				foreach($attributes as $attr=>$attr_deets){

					$attribute_label = wc_attribute_label(urldecode($attr));
					
					if ( isset( $attributes[ $attr ] ) || isset( $attributes[ 'pa_' . $attr ] ) ) {

						$attribute = isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : $attributes[ 'pa_' . $attr ];

						if ( $attribute['is_taxonomy'] ) {

							$formatted_attributes[$attribute_label] = implode( ', ', wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) ) );

						} else {

							$formatted_attributes[$attribute_label] = $attribute['value'];
						}

					}
				}

				//print_r($formatted_attributes);
				
				foreach ($formatted_attributes as $key => $value) {
				if ($key === 'Автор' || $key === 'Издательство' || $key === 'Бренд') {

					$key_slug_prefix = '/' . mb_strtolower($key) . '/';
					$value_slug_sufix = sanitize_title($value);
					$key_value_url = $key_slug_prefix . $value_slug_sufix;
					
					$attributes_to_check = array('Автор', 'Издательство', 'Бренд');
					
					if (in_array($key, $attributes_to_check) && strpos($value, ',') !== false) {
						// Multiple authors - create individual links
						$authors = explode(', ', $value);
						echo '<li><span>' . $key . ': </span>';
						foreach ($authors as $author) {
							$author_slug = sanitize_title($author);
							echo '<a href="' . esc_url($key_slug_prefix . $author_slug) . '">' . $author . '</a>';
							if ($author !== end($authors)) {
								echo ', ';
							}
						}
						echo '</li>';
					} else {
						// Single author, publisher, or brand - create a single link
						echo '<li><span>' . $key . ': </span><a href="' . esc_url($key_value_url) . '">' . $value . '</a></li>';
					}
				} else {
					echo '<li><span>' . $key . ': </span>' . $value . '.</li>';
				}
			}

			echo '</div>';
	
}
