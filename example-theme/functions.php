<?php

/**
 * Use this mecanism to add data available to your twig templates
 *
 * Here we add a 'section' variable with the first level parent's id and title
 */
function example_template_data($data) {
    global $post;
    if ($post) {
        /* Get an array of Ancestors and Parents if they exist */
        $parents = get_post_ancestors($post->ID);
        /* Get the top Level page->ID count base 1, array base 0 so -1 */
        $id = ($parents) ? $parents[count($parents) - 1] : $post->ID;
        /* Get the parent and set the $class with the page slug (post_name) */
        $parent = get_post($id);
        $data["section"] = array('id' => $parent->ID, 'name' => $parent->post_title);
    } else {
        $data["section"] = array('class' => 'misc');
    }
    return $data;
}

add_filter('fullsix_wordpress_theme_template_data', 'example_template_data');
