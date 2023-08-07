<?php
function display_price_for_registered_users() {
    global $product;

    if ( ! is_user_logged_in() ) {
        $sale_price = $product->get_sale_price();
        $tag_discounts = array(
            '10proc' => 0.9, 
            '15proc' => 0.85, 
			'20proc' => 0.80, 
            '25proc' => 0.75,
            '30proc' => 0.7,  
            '40proc' => 0.6, 
            '50proc' => 0.5, 
            '30proc-promo' => 0.7, 
        );

        // Check if the product has any of the specified tags
        $product_tags = get_the_terms( $product->get_id(), 'product_tag' );
        if ( $product_tags && ! is_wp_error( $product_tags ) ) {
            foreach ( $product_tags as $tag ) {
                $tag_slug = $tag->slug;
                if ( array_key_exists( $tag_slug, $tag_discounts ) ) {
                    $regular_price = $product->get_regular_price();
                    $discount_percentage = $tag_discounts[ $tag_slug ];
                    $discounted_price = $regular_price * $discount_percentage;

                    echo '<span class="please-log-in">Registruotiems vartotojams: ' . wc_price( $discounted_price ) . '</span>';
                    return; 
                }
            }
        }

        if ( ! empty( $sale_price ) ) {
            echo '<span class="please-log-in">Registruotiems vartotojams: ' . wc_price( $sale_price ) . '</span>';
        }
    }
}
add_action( 'woocommerce_after_shop_loop_item', 'display_price_for_registered_users', 10 );

