<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('chld_thm_cfg_parent_css')):
    function chld_thm_cfg_parent_css()
    {
        wp_enqueue_style('chld_thm_cfg_parent', trailingslashit(get_template_directory_uri()) . '/style.css', array());
    }
endif;
add_action('wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10);
function theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));
    // Chargement du /css/shortcodes/banniere-titre.css pour notre shortcode banniere titre
    wp_enqueue_style('banniere-titre-shortcode', get_stylesheet_directory_uri() . '/banniere-titre.css', array(), filemtime(get_stylesheet_directory() . '/banniere-titre.css'));
}



// END ENQUEUE PARENT ACTION

/* SHORTCODES */


// Je dis à wordpress que j'ajoute un shortcode 'banniere-titre'
add_shortcode('banniere-titre', 'banniere_titre_func');
// Je génère le html retourné par mon shortcode
function banniere_titre_func($atts)
{
    //Je récupère les attributs mis sur le shortcode
    $atts = shortcode_atts(
        array(
            'src' => '',
            'titre' => 'Titre'
        ), $atts, 'banniere-titre');

    //Je commence à récupéré le flux d'information
    ob_start();

    if ($atts['src'] != "") {
?>

<div class="banniere-titre" style="background-image: url(<?= $atts['src'] ?>)">
    <h2 class="titre"><?= $atts['titre'] ?></h2>
</div>

<?php
    }

    //J'arrête de récupérer le flux d'information et le stock dans la fonction $output
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

/* HOOKS */

add_filter( 'wp_nav_menu_items', 'add_extra_item_to_nav_menu', 10, 2 );
function add_extra_item_to_nav_menu( $items, $args ) {
    // echo("<pre>");
    // // var_dump($items);
    // $array = preg_split("/\r\n|\n|\r/", $items);
    // var_dump($array);
    // echo("</pre>");

    // if (is_user_logged_in() && $args->menu == 303) {
    //     $items .= '<li><a href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'">Admin</a></li>';
    // }
    // elseif (!is_user_logged_in() && $args->menu == 303) {
    //     $items .= '<li><a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">Sign in  /  Register</a></li>';
    // }
    if (is_user_logged_in()) {
        $original_menu_items_array = preg_split("/\r\n|\n|\r/", $items);
        $logged_item = '<li id="menu-item-16" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item pag-item-15 current-page-item menu-item-16"><a href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'">Admin</a></li>';
        $items = $original_menu_items_array[0] . $logged_item . $original_menu_items_array[1];
    }
     
    
    return $items;
}