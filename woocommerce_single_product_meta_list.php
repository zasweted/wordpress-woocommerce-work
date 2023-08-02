<?php

/*
 * single product page description
 */

 function custom_fileds_single_product_page() {
    if ( ! is_product() ) {
        return;
    }

    $meta_attrs = [
		'isbn' => 'ISBN'
		];

    global $product;
	$font = 'Jost';
    $product_id = $product->get_id();
    $custom_fields = get_post_custom($product_id);
			echo '<div style="display:flex; flex-direction: column; justify-content:flex-start;">';
    foreach ($meta_attrs as $meta_key => $label) {
        if (isset($custom_fields[$meta_key][0])) {
            $value = $custom_fields[$meta_key][0];
            echo '<li style="list-style:none; font-weight:400; "><span style="font-weight:500; font-size:12.6px; font-family:'. $font .'; color:#222d35;">' . esc_html($label) . ': </span>' . esc_html($value) . '</li>';
        }
	}
			$product_attributes = single_product_attribute_list();
			foreach ($product_attributes as $attribute_name => $attribute_values) {
			$cleaned_name = str_replace('pa_', '', $attribute_name);

			echo '<li style="list-style:none; font-weight:400; "><span style="font-weight:500; font-size:12.6px; font-family:'. $font .'; color:#222d35; text-transform: capitalize;"><span>' . $cleaned_name . ': </span>';

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

add_action('woocommerce_product_meta_end', 'custom_fileds_single_product_page');

