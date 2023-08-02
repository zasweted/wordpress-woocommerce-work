<?php
/**
 * Creates a shortcode [author_list_with_filter]
 * when added on page renders list of product Attribute named - "Издательство"
 * if list is longer then 5, hides rest of list and uses a button to show more/less()revealing rest of list.
 * if list item is clicked filters the products on that page by set Attribute value.
 * 
 */
function render_author_list_with_filter_shortcode() {
    ob_start();

    $authors = [];
    $author_slug_prefix = '/издательство/'; // Replace with your author slug prefix

    // Get the product attribute slug for authors
    $attribute_slug = 'Издательство'; // Replace 'authors' with your actual attribute slug

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

    // Get the current page URL
    $current_page_url = esc_url($_SERVER['REQUEST_URI']);

// Render the author list
if (!empty($authors)) {
    $author_count = count($authors);
    echo '<div class="author-list-container">';
    echo '<ul class="author-list">';
    $i = 0;
    foreach ($authors as $author) {
        $i++;
        $author_slug = sanitize_title($author);
        $author_link = add_query_arg('filter', $author_slug, $current_page_url); // Create the author filter link
        
        $list_item_class = ($i > 5) ? 'hidden-author' : '';
        echo '<li class="author-list-single-author ' . $list_item_class . '"><a href="' . esc_url($author_link) . '">' . $author . '</a></li>';
    }
    echo '</ul>';
    if ($author_count > 5) {
        echo '<button class="show-more-authors">Show More</button>';
    }
    echo '</div>';
} else {
    echo 'No authors found.';
}



    return ob_get_clean();
}
add_shortcode('author_list_with_filter', 'render_author_list_with_filter_shortcode');

function apply_author_filter($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Check if the 'author' query parameter is set
        if (isset($_GET['filter'])) {
            $author_slug = sanitize_text_field($_GET['filter']);

            // Get the product attribute slug for authors
            $attribute_slug = 'издательство'; // Replace with your actual attribute slug in Russian

            $tax_query = array(
                array(
                    'taxonomy' => 'pa_' . $attribute_slug, // Replace 'pa_' with the correct prefix for your product attribute taxonomy
                    'field'    => 'slug',
                    'terms'    => $author_slug,
                ),
            );

            // Modify the product query to filter by the selected author
            $query->set('tax_query', $tax_query);
        }
    }
}
add_action('pre_get_posts', 'apply_author_filter');

function change_author_query_var($query_vars) {
    $query_vars[] = 'filter';
    $query_vars[] = 'издательство'; // Add the query variable in Russian
    return $query_vars;
}
add_filter('query_vars', 'change_author_query_var');

function translate_query_var($translated_text, $untranslated_text, $domain) {
    if ($domain === 'woocommerce' && $untranslated_text === 'Author') {
        return 'издательство'; // Replace with the translated text for "Author" in Russian
    }
    return $translated_text;
}
add_filter('gettext', 'translate_query_var', 20, 3);


/*Css part
.author-list .hidden-author {
    display: none;
}
.show-more-authors {
    cursor: pointer;
    color: blue;
    text-decoration: underline;
}
*/
/* jQuerry part
<script>
jQuery(document).ready(function($) {
    // Show/hide additional authors when "Show More" button is clicked
    $('.show-more-authors').on('click', function() {
        var hiddenAuthors = $('.author-list-container .hidden-author');
        if (hiddenAuthors.is(':visible')) {
            hiddenAuthors.slideUp('slow', function() {
                $(this).hide();
                $('.show-more-authors').text('Show More');
            });
        } else {
            hiddenAuthors.slideDown('slow', function() {
                $(this).show();
                $('.show-more-authors').text('Show Less');
            });
        }
    });
});
</script>
*/
