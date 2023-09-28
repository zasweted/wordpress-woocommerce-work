<?php

function render_author_list_with_filter_shortcode($atts) {
    $params = shortcode_atts(array(
        'attr_name' => '',  // Empty default value
    ), $atts);

    // Access the attr_name parameter
    $attr_name = $params['attr_name'];

    // Check if attr_name is empty
    if (empty($attr_name)) {
        return 'Attribute name is missing in the shortcode.';
    }

    // Define nested arrays of allowed pages and associated 'attr_name' values
    $allowed_pages = array(
        'не-книги' => array('брэнд'),
        'акции' => array('брэнд', 'язык'),
        'книги' => array('издательство', 'язык'),
        // Add more allowed page names or page IDs and their corresponding attr_name values as needed
    );

    // Get the current page URL
    $current_page_url = esc_url($_SERVER['REQUEST_URI']);

    // Determine the current page name (you may need to modify this part)
    $current_page_name = get_current_page_name(); // You need to implement this function

    // Check if the page name exists in the allowed_pages array
    if (isset($allowed_pages[$current_page_name]) && in_array($attr_name, $allowed_pages[$current_page_name])) {
        // Call the function to generate and return the author list
        return generate_author_list($attr_name);
    } else {
        return 'Shortcode is not allowed on this page.';
    }
}

function generate_author_list($attr_name) {
    // Rest of your code for rendering the author list goes here

    // Get the product attribute slug for authors
    $attribute_slug = ucfirst($attr_name); // Replace 'authors' with your actual attribute slug

    // Get all products
    $products = wc_get_products(array(
        'status' => 'publish',
        'limit' => -1,
    ));

    // Initialize an array to store authors and their counts
    $authors_counts = array();

    // Loop through each product
    foreach ($products as $product) {
        $product_authors = $product->get_attribute($attribute_slug);

        // Check if the product has the specified attribute
        if (!empty($product_authors)) {
            $product_authors = explode(', ', $product_authors);

            // Loop through each author and add them to the list
            foreach ($product_authors as $author) {
                $authors_counts[$author] = isset($authors_counts[$author]) ? $authors_counts[$author] + 1 : 1;
            }
        }
    }

    // Get the current page URL
    $current_page_url = esc_url($_SERVER['REQUEST_URI']);
    // Generate a unique ID for the button
    $button_id = 'show-more-authors-' . $attr_name;

    // Initialize output buffer
    ob_start();

    // Render the author list
    if (!empty($authors_counts)) {
        $author_count = count($authors_counts);
        echo '<div class="author-list-container">';
        echo '<h2 class="main-page-sidebar-heading">' . $attribute_slug . ':</h2>';
        echo '<ul class="author-list">';
        $i = 0;
        foreach ($authors_counts as $author => $count) {
            $i++;
            $author_slug = sanitize_title($author);
            $author_link = add_query_arg([
                'filter' => $author_slug,
                'attr_name' => $attr_name,
            ], $current_page_url); // Create the author filter link

            $list_item_class = ($i > 10) ? 'hidden-author' : '';
            echo '<li class="author-list-single-author ' . $list_item_class . '"><a href="' . esc_url($author_link) . '"><p>' . $author . '</p><p>(' . $count . ')</p></a></li>';
        }
        echo '</ul>';
        if ($author_count > 10) {
            echo '<button id="' . $button_id . '" class="show-more-authors">Больше</button>';
        }
        echo '</div>';
    } else {
        return false;
    }

    // Get the output content and clean the buffer
    $output = ob_get_clean();

    // Wrap the output with a unique identifier
    $shortcode_id = uniqid('author_list_');
    $output_with_id = '<div id="' . $shortcode_id . '">' . $output . '</div>';

    return $output_with_id;
}

function get_current_page_name()
{
    if (is_product_category()) {
        $current_category = get_queried_object();
        $current_page_name = urldecode($current_category->slug);
        return $current_page_name;
    } else {
        // If it's not a product category page, set a default value for $current_category_name
        $current_page_name = 'акции';
        return $current_page_name;
    }
}
add_shortcode('author_list_with_filter', 'render_author_list_with_filter_shortcode');
