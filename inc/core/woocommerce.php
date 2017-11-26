<?php

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

if ( ! function_exists( 'cb_is_woocommerce' ) ) :
function cb_is_woocommerce() {

    if ( class_exists( 'Woocommerce' )  && ( ( is_woocommerce() ) || is_product() || ( is_cart() ) || ( is_account_page() ) || ( is_order_received_page() ) || ( is_checkout() ) ) ) {
        return true;
    }
       
    return false;
}
endif;

if ( ! function_exists( 'cb_woocommerce_theme_support' ) ) :
function cb_woocommerce_theme_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
endif;
add_action( 'after_setup_theme', 'cb_woocommerce_theme_support' );

if ( ! function_exists( 'cb_disqus_woocommerce' ) ) {
    function cb_disqus_woocommerce( $post ) {

        $cb_post_id = $post->ID;
        $cb_post_title = $post->post_title;
        $cb_disqus_forum_shortname = ot_get_option('cb_disqus_shortname', NULL);

        wp_enqueue_script( 'cb_disqus', '//' . $cb_disqus_forum_shortname . '.disqus.com/embed.js' );
        echo '<div id="disqus_thread"></div>
        <script type="text/javascript">
            var disqus_shortname = "' . $cb_disqus_forum_shortname . '";
            var disqus_title = "' . $cb_post_title . '";
            var disqus_url = "' . get_permalink( $cb_post_id ) . '";
            var disqus_identifier = "' . $cb_disqus_forum_shortname . '-' . $cb_post_id . '";
        </script>';
    }
}

if ( ! function_exists( 'cb_woo_title' ) ) {

    function cb_woo_title() {
       $cb_output = '<div class="cb-module-header cb-category-header"><h1 class="cb-module-title">';
        if ( is_shop() ) {
            $cb_output .= woocommerce_page_title( false );
        } elseif ( ( is_product_category() ) || ( is_product_tag() ) ) {
            global $wp_query;
            $cb_current_object = $wp_query->get_queried_object();
            $cb_output .= $cb_current_object->name;

        } else {
            $cb_output .= get_the_title();
        }
        $cb_output .= '</h1></div>';

        echo $cb_output;
    }
}

if ( ! function_exists( 'cb_woocommerce_show_page_title' ) ) {

    function cb_woocommerce_show_page_title() {
       return false;
    }
}
add_filter( 'woocommerce_show_page_title', 'cb_woocommerce_show_page_title' );

if ( ! function_exists( 'cb_Woocommerce_pagi' ) ) {

    function cb_Woocommerce_pagi() {

       return  array(
            'prev_text'     => '<i class="fa fa-long-arrow-left"></i>',
            'next_text'     => '<i class="fa fa-long-arrow-right"></i>',
        );
    }
}
add_filter( 'woocommerce_pagination_args', 'cb_Woocommerce_pagi' );


if ( ! function_exists( 'cb_woocommerce_loop_count' ) ) {
    function cb_woocommerce_loop_count() {
        if ( ot_get_option('cb_woocommerce_sidebar', NULL ) == 'nosidebar-fw' ) {
            return 4;
        } else {
            return 3;
        }

    }
}
add_filter( 'loop_shop_columns', 'cb_woocommerce_loop_count' );

if ( ! function_exists( 'woocommerce_output_related_products' ) ) {
    function woocommerce_output_related_products() {
        woocommerce_related_products( array( 'posts_per_page' => 2, 'columns' => 2 ), 2 );
    }
}

if ( ! function_exists( 'cb_woocommerce_add_cart_button' ) ) {
    function cb_woocommerce_add_cart_button() {
        global $product;
        return sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( $product->id ),
                    esc_attr( $product->get_sku() ),
                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    esc_attr( $product->product_type ),
                    esc_html( $product->add_to_cart_text() )
                );
    }
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'cb_woocommerce_add_cart_button', 10, 2 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function cb_woo_start_wrap() {
    echo '<div id="cb-content" class="wrap cb-wrap-pad clearfix"><div class="cb-main clearfix">';
    woocommerce_breadcrumb();
    cb_woo_title();
}
add_action('woocommerce_before_main_content', 'cb_woo_start_wrap', 10);

function cb_woo_end_wrap() {
    echo '</div> <!-- end .cb-main -->';
    if ( ot_get_option( 'cb_woocommerce_sidebar', 'sidebar' ) != 'nosidebar-fw' ) { get_sidebar(); }
    echo '</div><!-- end #cb-content -->';
}
add_action('woocommerce_after_main_content', 'cb_woo_end_wrap', 10);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 14 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

function woocommerce_get_sidebar() {}

if ( ! function_exists( 'cb_modals' ) ) {
    function cb_modals() {

        if ( function_exists( 'login_with_ajax' ) ) {
            echo '<div id="cb-lwa" class="cb-lwa-modal cb-modal">';
            login_with_ajax();
            echo '</div>';
        }

        echo '<div id="cb-menu-search" class="cb-s-modal cb-modal"><div class="cb-close-m cb-ta-right"><i class="fa cb-times"></i></div><div class="cb-s-modal-inner cb-pre-load cb-light-loader cb-modal-inner cb-font-header cb-mega-three cb-mega-posts clearfix">' . get_search_form( false ) .'<div id="cb-s-results"></div></div></div>';
    }
}

if ( ! function_exists( 'cb_woo_breadcrumbs' ) ) {
     function cb_woo_breadcrumbs() {
         $cb_icon = '<i class="fa fa-angle-right"></i>';
        return array(
                    'delimiter'   =>  $cb_icon,
                    'wrap_before' => '<div class="cb-breadcrumbs " ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
                    'wrap_after'  => '</div>',
                    'before'      => '',
                    'after'       => '',
                    'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
                 );
    }
}
add_filter('woocommerce_breadcrumb_defaults' , 'cb_woo_breadcrumbs');

if ( ! function_exists( 'cb_modal_logo' ) ) {
    function cb_modal_logo() {
        $cb_logo = ot_get_option('cb_lwa_logo', NULL );
        $cb_logo_retina = ot_get_option('cb_lwa_logo_retina', NULL );

        if  ( $cb_logo != NULL ) {

?>
            <div class="cb-lwa-logo cb-ta-center">
                <img src="<?php echo esc_url( $cb_logo ); ?>" alt="<?php esc_html( get_bloginfo( 'name' ) ); ?> logo" <?php if ( $cb_logo_retina != NULL ) { echo 'data-at2x="' . $cb_logo_retina . '"'; } ?>>
            </div>
<?php
        }
    }
}