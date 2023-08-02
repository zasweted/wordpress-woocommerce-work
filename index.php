<?php
$wholesale_meta = $product->get_meta('wholesale_multi_user_pricing');
$wholesale_price = $wholesale_meta[43]['wholesale_price'];

$regular_price = $product->get_regular_price();

echo '<div>';
    echo 'Regular Price: ' . wc_price($regular_price) . '<br>';
    echo 'Wholesale Price: ' . wc_price($wholesale_price) . '<br>';
    echo '</div>';

if($wholesale_meta[124]['discount_type'] == 'fixed'){
$wholesale_price = $wholesale_meta[124]['wholesale_price'];
echo 'fixed';
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    echo '<p class="whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($wholesale_price) . '</span></p>';
    echo '</div>';
}else if($wholesale_meta[124]['discount_type'] == 'percent'){
$discount_amount = $regular_price * $wholesale_meta[124]['wholesale_price'];
$wholesale_price = $regular_price - $discount_amount;
echo 'discount';
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    echo '<p class="whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($wholesale_price) . '</span></p>';
    echo '</div>';
}

echo $wholesale_price_key_accountai;
echo $wholesale_key_accountai_discount_type;

echo $wholesale_price_meistrai;
echo $wholesale_meistrai_discount_type;
// echo '<div>';
    //echo 'Regular Price: ' . wc_price($regular_price) . '<br>';
    // echo 'Wholesale Price: ' . wc_price($wholesale_price) . '<br>';
    //echo '</div>';

/**
* Shop page, display wholesale price for all users



function woocommerce_template_loop_price() {
global $product;

if ($product->get_meta('wholesale_multi_user_pricing')) {
$wholesale_meta = $product->get_meta('wholesale_multi_user_pricing');

$wholesale_price_meistrai = $wholesale_meta[123]['wholesale_price'];
$wholesale_meistrai_discount_type = $wholesale_meta[123]['discount_type'];

$regular_price = $product->get_regular_price();
if($wholesale_price_meistrai > 0){
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    if($wholesale_meistrai_discount_type == 'fixed'){
    echo '<p class="whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($wholesale_price_meistrai) .
            '</span></p>';
    } else {
    $price_after_discount = $regular_price - ($regular_price * $wholesale_price_meistrai / 100);
    echo '<p class="whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($price_after_discount) . '</span>
    </p>';
    }
    echo '</div>';
} else {
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    echo '</div>';
}

}

}
add_filter( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', );
*/
/**
* Single product page, display wholesale price for all users
*/
function woocommerce_template_single_price() {
if (is_singular('product')) {
global $product;

if ($product->get_meta('wholesale_multi_user_pricing')) {
$wholesale_meta = $product->get_meta('wholesale_multi_user_pricing');

$wholesale_price_meistrai = $wholesale_meta[123]['wholesale_price'];
$wholesale_meistrai_discount_type = $wholesale_meta[123]['discount_type'];

$regular_price = $product->get_regular_price();
print_r($product) .'</br'; print_r($regular_price) .'</br'; if($wholesale_price_meistrai> 0){
echo '<div class="single-whole-sale-price-container">';
    echo '<p class="single-whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    if($wholesale_meistrai_discount_type == 'fixed'){
    echo '<p class="single-whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($wholesale_price_meistrai) .
            '</span></p>';
    } else {
    $price_after_discount = $regular_price * $wholesale_price_meistrai / 100;
    echo '<p class="single-whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($price_after_discount) .
            '</span></p>';
    }
    echo '</div>';
} else {
echo '<div class="single-whole-sale-price-container">';
    echo '<p class="single-whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    echo '</div>';
}

}
}
}
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

function woocommerce_template_loop_price() {
global $product;

if ($product->get_meta('wholesale_multi_user_pricing')) {
$wholesale_meta = $product->get_meta('wholesale_multi_user_pricing');

$wholesale_price_meistrai = $wholesale_meta[123]['wholesale_price'];
$wholesale_meistrai_discount_type = $wholesale_meta[123]['discount_type'];

$regular_price = $product->get_regular_price();
if($wholesale_price_meistrai > 0){
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    if($wholesale_meistrai_discount_type == 'fixed'){
    echo '<p class="whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($wholesale_price_meistrai) .
            '</span></p>';
    } else {
    $price_after_discount = $regular_price * $wholesale_price_meistrai / 100;
    echo '<p class="whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($price_after_discount) . '</span>
    </p>';
    }
    echo '</div>';
} else {
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    echo '</div>';
}

}

}
add_filter( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', );
/****/
function woocommerce_template_loop_price() {
if ( ! is_user_logged_in() ){
global $product;

if ($product->get_meta('wholesale_multi_user_pricing')) {
$wholesale_meta = $product->get_meta('wholesale_multi_user_pricing');

$wholesale_price_meistrai = $wholesale_meta[123]['wholesale_price'];
$wholesale_meistrai_discount_type = $wholesale_meta[123]['discount_type'];

$regular_price = $product->get_regular_price();
if($wholesale_price_meistrai > 0){
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    if($wholesale_meistrai_discount_type == 'fixed'){
    echo '<p class="whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($wholesale_price_meistrai) .
            '</span></p>';
    } else {
    $price_after_discount = $regular_price * $wholesale_price_meistrai / 100;
    echo '<p class="whole-sale-price-text"><b>Registruotiems: </b><span>' . wc_price($price_after_discount) . '</span>
    </p>';
    }
    echo '</div>';
} else {
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"><b>Įprasta: </b><span>' . wc_price($regular_price) . '</span></p>';
    echo '</div>';
}

}
} else {
global $product;
$wholesale_meta = $product->get_meta('wholesale_multi_user_pricing');
$regular_price = floatval($product->get_regular_price());
$wholesale_price_meistrai = floatval($wholesale_meta[123]['wholesale_price']);
$price_after_discount = $regular_price * $wholesale_price_meistrai / 100;
if($wholesale_price_meistrai > 0){
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"' . wc_price($price_after_discount) . ' </p>';
        echo '</div>';
}else {
echo '<div class="whole-sale-price-container">';
    echo '<p class="whole-sale-price-text"' . wc_price($regular_price) . ' </p>';
        echo '</div>';
}

}



}
add_filter( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

function change_stock_status_strings_single_product( $availability, $product ) {
    global $product;

    // Check if it is a singular product page
    if ( is_singular( 'product' ) ) {
        // Change "In Stock" message
        if (!$product->is_on_backorder() && $product->is_in_stock()) {
            $stock_quantity = $product->get_stock_quantity();
            $availability = 'На складе (доставка 1-3 дня)' . '</br>';
            $availability .= 'Количество на складе: ' . $stock_quantity;
        }

        // Change "Out of Stock" message
        if (!$product->is_on_backorder() && !$product->is_in_stock()) {
            $availability = '<span class="shop-loop-stock"><b>Статус товара: </b><span class="dont-have-stock"> Распродано</span></span>';
        }

        // Change "Backorder" message
        if ($product->is_on_backorder()) {
            $availability = '<span class="shop-loop-stock"><b>Статус товара: </b><span class="preorder"> Предзаказ (доставка через 3-4 недели) </span></span>';
        }

        if ($product->is_on_backorder() && $product->get_stock_quantity() < 0) {
            $availability = '<span class="shop-loop-stock"><b>Статус товара: </b><span class="preorder"> Предзаказ (доставка через 3-4 недели) </span></span>';
        }
    }

    return $availability;
}
add_filter( 'woocommerce_get_availability_text', 'change_stock_status_strings_single_product', 10, 2 );