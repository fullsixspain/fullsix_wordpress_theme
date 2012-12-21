<?php

use FullSIX\Bundle\WordPressBundle\WordPressResponse;

require_once ABSPATH . '../vendor/autoload.php';

function fullsix_wordpress_theme_customize_register($wp_customize)
{
    $wp_customize->add_section('fullsix_wordpress_theme_core', array(
        'title' => __('Core parameters', 'fullsix_wordpress_theme'),
        'priority' => 0,
    ));
    $wp_customize->add_setting('fullsix_wordpress_theme_templates_path', array(
        'default' => '::%%s.html.twig',
    ));
    $wp_customize->add_control('fullsix_wordpress_theme_templates_path', array(
        'label' => 'Template path scheme',
        'section' => 'fullsix_wordpress_theme_core',
    ));
}

add_action('customize_register', 'fullsix_wordpress_theme_customize_register');

function fullsix_wordpress_theme_get_twig()
{
    global $container;
    return $container->get('twig');
}

function fullsix_wordpress_theme_process($name)
{
    $data = fullsix_wordpress_theme_get_template_data($name);
    $template = fullsix_wordpress_theme_get_twig()->loadTemplate(sprintf(get_theme_mod('fullsix_wordpress_theme_templates_path'), $name));
    $template->display($data);
}

function fullsix_wordpress_theme_get_template_data($template)
{
    global $response;
    $data = array();
    if ($response instanceof WordPressResponse) {
        $data = $response->getParams();
    }
    return apply_filters('fullsix_wordpress_theme_template_data', $data);
}
