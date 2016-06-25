<?
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'person-thumb', 100, 100, true ); // Кадрирование изображения
    add_image_size( 'news-announce', 240, 160, true ); // Кадрирование изображения
}
register_nav_menus( array(
    'sidebar_menu' => 'Sidebar Menu',
    'header_menu' => 'Header Menu',
) );

if( function_exists('acf_add_options_page') ) {


    acf_add_options_page(array(
        'page_title' 	=> 'Theme General Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> true
    ));

    foreach (['en','it'] as $lang) {

        acf_add_options_sub_page([
            'page_title' => "Theme Settings " . $lang,
            'menu_title' => "Theme Settings " . $lang,
            'post_id' => $lang,
            'parent_slug' => 'theme-general-settings',
            'parent' => 'theme-general-settings'
        ]);

    }
}
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');