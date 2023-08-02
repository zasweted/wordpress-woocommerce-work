<?php
function attributes_list_single_product_page()
{
    global $product;
    
    if ( is_product() ) {
        $attributes = $product->get_attributes();
        
        if ( $attributes ) {
            echo '<div class="subcat-list-cont">';
            
            foreach ( $attributes as $attribute ) {
                $attribute_name = str_replace( 'pa_', '', $attribute->get_name() );
                $attribute_value = $product->get_attribute( $attribute_name );
                
                if ( $attribute_value ) {
                    echo '<li class="subcat-list-item top-ten" style="list-style: none; font-weight:400"><span style="text-transform:capitalize;  font-weight:500">' . $attribute_name . ':</span> ' . $attribute_value . '</li>';
                }
            }
            
            echo '</div>';
        }
    }
}
add_action('woocommerce_product_meta_end', 'attributes_list_single_product_page');
