<?php

/**
 * Function to look through a text for links to specified taxonomies.
 *
 * @param String $content
 * @param Array|Object $taxonomies
 * @param Boolean $city_search
 * @param Array $cities An array of the Cities that needs to be searched for. The Array can contain WP_Post
 * @param Boolean $no_headings Do you want the search to look for the keywords in <h1>, <h2>, <h3> etc.? True/false
 * @return mixed|string
 */
function add_links_to_keywords($content, $taxonomies, $city_search = false, $cities = array(), $no_headings = true) {
    // Check if ACF is active
    if (!function_exists('get_field')) {
        return $content;
    }

    $all_keywords = array();

    // Initialize array to store linked phrases
    $linkedPhrases = array();

    // Process taxonomies
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(array('taxonomy' => $taxonomy, 'hide_empty' => false));

        foreach ($terms as $term) {
            $seo_keyword = get_field('seo_keywords', $taxonomy . '_' . $term->term_id);
            $term_link = get_term_link($term->term_id, $taxonomy);

            if ($seo_keyword && $term_link) {
                $keywords = array_filter(explode(',', $seo_keyword), 'strlen');

                // Sort keywords by length in descending order
                usort($keywords, function ($a, $b) {
                    return strlen($b) - strlen($a);
                });

                foreach ($keywords as $value) {
                    if (!empty($value)) {
                        $escaped_value = preg_quote(trim($value), '/');
                        if($no_headings === true){
                            $pattern = '/(?<!<\/a>)\b' . preg_quote($escaped_value, '/') . '\b(?![^<]*<\/(?:h1|h2|h3|h4|h5|h6)>)(?![^<]*["\'])/i';
                        } else {
                            $pattern = '/(?<!<\/a>)\b' . preg_quote($escaped_value, '/') . '\b(?![^<]*>)/i';
                        }

                        // Perform the replacement only if the word or phrase doesn't have a link
                        $content = preg_replace_callback($pattern, function ($matches) use ($term_link, &$linkedPhrases) {
                            $phrase = $matches[0];
                            if (!in_array($phrase, $linkedPhrases)) {
                                $linkedPhrases[] = $phrase;
                                return '<a href="' . esc_url($term_link) . '">' . $phrase . '</a>';
                            }
                            return $phrase;
                        }, $content);
                    }
                }
            }
        }
    }

    if($city_search === true
        && is_array($cities)
        && !empty($cities)){
        // Make links for citi names too.
        $city_posts = $cities;
        $city_names = array_map(function ($city_post) {
            $title = (strpos($city_post->post_title, ' ') == true ? substr($city_post->post_title, strpos($city_post->post_title, ' ') + 1) : $city_post->post_title );
            return array(
                'title' => $title,
                'link' => get_permalink($city_post->ID),
            );
        }, $city_posts);

        $linked_cities = array();

        foreach ($city_names as $value) {
            if (!empty($value)) {
                // Regular expression pattern to find the first occurrence of "Beder" outside heading tags
                if($no_headings === true){
                    $pattern = '/<(h[1-6])[^>]*>.*?<\/\1>(*SKIP)(*FAIL)|\b'.$value['title'].'\b/i';
                } else {
                    $pattern = '/\b' . preg_quote($value['title'], '/') . '\b/i';
                }

                // Link to be added
                $link = $value['link'];

                // Replace the first occurrence of "Beder" outside heading tags with a link
                $content = preg_replace($pattern, '<a href="' . esc_url($link) . '">$0</a>', $content, 1);
            }
        }

        #foreach ($city_posts as $city_post) {
        #    echo $city_post->post_title . '<br>';
        #}
    }

    // Apply wpautop to preserve line breaks
    $content = wpautop($content);

    return $content;
}

