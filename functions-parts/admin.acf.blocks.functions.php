<?php


add_action('acf/init', 'greeting_acf_blocks_init');
function greeting_acf_blocks_init() {

    // check function exists
    if( function_exists('acf_register_block') ) {

        // register a testimonial block
        acf_register_block(array(
            'name'              => 'testimonial',
            'title'             => __('Testimonial'),
            'description'       => __('A custom testimonial block.'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'testimonial', 'quote' ),
        ));
        // register a testimonial block
        acf_register_block(array(
            'name'              => 'testimonial-trustpilot',
            'title'             => __('Testimonial - Trustpilot'),
            'description'       => __('A custom testimonial block with Trustpilot.'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'testimonial', 'trustpilot', 'quote' ),
        ));

        // register a testimonial block
        acf_register_block(array(
            'name'              => 'how-it-works',
            'title'             => __('How Greeting Works'),
            'description'       => __('A block that shows how Greeting.dk works.'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'how-it-works' ),
        ));
        // register a testimonial block
        acf_register_block(array(
            'name'              => 'how-it-works-with-cta',
            'title'             => __('How Greeting Works - with CTA button'),
            'description'       => __('A block that shows how Greeting.dk works. Including CTA button'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'how-it-works' ),
        ));

        // register a text block
        acf_register_block(array(
            'name'              => 'text',
            'title'             => __('Greeting - Text Block'),
            'description'       => __('A block for text in Greeting.dk template.'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'text' ),
        ));
        // register a text block
        acf_register_block(array(
            'name'              => 'text-with-header',
            'title'             => __('Greeting - Text Block With Header'),
            'description'       => __('A block for text in Greeting.dk template.'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'text' ),
        ));

        // register a contact block
        acf_register_block(array(
            'name'              => 'contact-us',
            'title'             => __('Greeting - Contact Block'),
            'description'       => __('A block for Contact Us in Greeting.dk template.'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'text' ),
        ));
        // register a contact person block
        acf_register_block(array(
            'name'              => 'contact-person',
            'title'             => __('Greeting - Contact Person'),
            'description'       => __('A block for Contact Person in Greeting.dk template.'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'text' ),
        ));

        // register a press mentions block
        acf_register_block(array(
            'name'              => 'press-mentions',
            'title'             => __('Greeting - Presse'),
            'description'       => __('A block for Press Mentions in Greeting.dk template.'),
            'render_callback'   => 'greeting_block_render_callback',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'text' ),
        ));
    }
}

function greeting_block_render_callback( $block ) {

    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);

    // include a template part from within the "template-parts/block" folder
    if( file_exists( get_theme_file_path("/template-parts/inc/acf_blocks/content-{$slug}.php") ) ) {
        include( get_theme_file_path("/template-parts/inc/acf_blocks/content-{$slug}.php") );
    }
}