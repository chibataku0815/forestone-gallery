<?php
    $cb_responsive_style = ot_get_option( 'cb_responsive_onoff', 'on' );
    $cb_logo_position = 'cb-logo-' . ot_get_option( 'cb_logo_position', 'left' );
	$cb_body_class =  $cb_hd_wrap = $cb_menu_wrap = $cb_hd_wrap_s = $cb_bg_to_margin_top = $cb_main_menu_wrap = $cb_hd_wrap_s_2 = $cb_bg_attr = NULL;
	$cb_main_wrap = 'wrap ';
    $cb_review_checkbox = $cb_review_prop = $cb_bg_to_img = $cb_bg_ad = NULL;
    $cb_bg_to = ot_get_option( 'cb_bg_to', 'off' );
    $cb_logo = ot_get_option( 'cb_logo_url', NULL );
    $cb_show_header = $cb_show_m_header = NULL;

    if ( cb_header_banner() != NULL ) {
    	$cb_hd_wrap_s = ' cb-with-block';
    }

    if ( is_singular() ) {
    	$cb_show_header = cb_show_header();
    }

    if ( is_single() ) {
    	$cb_review_checkbox = get_post_meta( $post->ID, 'cb_review_checkbox', true );
    	$cb_review_type = get_post_meta( $post->ID, 'cb_user_score', true );

    	if ( ( $cb_review_checkbox == 'on' )  || ( $cb_review_checkbox == '1' ) ){
    		 if ( $cb_review_type == 'cb-readers' ) {
	            $cb_review_prop =  'itemscope itemtype="http://schema.org/Product"';
	        } else {
	            $cb_review_prop = 'itemprop="review" itemscope itemtype="http://schema.org/Review"';
	        }

	    }

    	$cb_post_format = get_post_format( $post->ID );
    	if ( $cb_post_format == 'gallery' ) {
    		$cb_bg_to = NULL;
    	}
    }

    if ( $cb_show_header == NULL ) {
    	$cb_show_header = 'on';
    }

    $cb_tm_wrap = ot_get_option( 'cb_sw_tm', 'fw' ) == 'box' ? ' wrap' : NULL;

    if ( ( cb_menu_icons( 'cb-top' ) == NULL ) && ( ! has_nav_menu( 'top' ) ) ) {
    	$cb_tm_wrap .= ' cb-tm-only-mob';
    }

    if ( ot_get_option( 'cb_sw_hd', 'fw' ) == 'fw' ) {
        $cb_hd_wrap = ' wrap';
        $cb_main_wrap = 'cb-wrap-off ';
    } else {
    	$cb_hd_wrap = ' cb-fw';
    	$cb_hd_wrap_s_2 = 'wrap';
    }

    if ( ot_get_option( 'cb_sw_menu', 'fw' ) == 'fw' ) {
        $cb_menu_wrap = ' cb-menu-fw';
    } else {
    	$cb_menu_wrap = ' wrap';
    	$cb_main_menu_wrap = ' wrap';
    }

    $cb_mobile = new Mobile_Detect;

	if ( ( $cb_bg_to == 'global' ) || ( ( $cb_bg_to == 'only-hp' ) && ( is_front_page() == TRUE ) ) ) {
	    $cb_bg_to_margin_top = ot_get_option('cb_bg_to_margin_top', NULL);
	    $cb_bg_to_url = ot_get_option('cb_bg_to_url', NULL);
	    $cb_bg_to_img = ot_get_option('cb_bg_to_img', NULL);
	    $cb_bg_ad = '<a href="' . esc_url($cb_bg_to_url) .'" target="_blank" id="cb-bg-to" rel="nofollow"></a>';
	    $cb_body_class .= ' cb-bg-to-on';
	    if ( ( $cb_bg_to_margin_top != NULL ) && ( $cb_mobile->isMobile() != true ) ) {
	        $cb_bg_to_margin_top = ' style="margin-top:'. intval($cb_bg_to_margin_top[0]) . $cb_bg_to_margin_top[1] . ';"';
	    }
	    if ( $cb_bg_to_img != NULL ) {
	        $cb_bg_to_img = 'style="background-color: #fff; background-image: url('. esc_url($cb_bg_to_img) .'); background-attachment: fixed; background-position: 50% 0%; background-repeat: no-repeat no-repeat;"';
	    }
	}
    if ( cb_background_image() != NULL ) {
        $cb_bg_attr = 'data-cb-bg="' . cb_background_image() . '"';
    }
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>

		<meta charset="utf-8">
		<!-- Google Chrome Frame for IE -->
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
		<!-- mobile meta -->
        <?php if ( $cb_responsive_style == 'on' ) { ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php } else { ?>
            <meta name="viewport" content="width=1200"/>
        <?php } ?>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php  if ( has_nav_menu( 'main' ) ) {

					$cb_main_menu = wp_nav_menu(
						array(
							'echo'           => FALSE,
					    	'theme_location' => 'main',
					    	'container' => FALSE,
					        'depth' => 0,
							'walker' => new cb_mega_walker,
							'items_wrap' => '<ul class="cb-main-nav wrap clearfix">%3$s</ul>',
						)
                    );
				}
		?>

		<!-- head extras -->
		<?php wp_head(); ?>
		<!-- end head extras -->

	</head>

	<body <?php body_class( $cb_body_class );  echo $cb_bg_to_img . $cb_bg_attr; ?>>

		<?php echo $cb_bg_ad; ?>

		<div id="cb-outer-container"<?php echo $cb_bg_to_margin_top; ?>>

			<?php if ( ( cb_menu_icons( 'cb-top' ) != NULL ) || ( has_nav_menu( 'top' ) ) || ( has_nav_menu( 'small' ) ) ) { ?>

				<div id="cb-top-menu" class="clearfix cb-font-header <?php echo esc_attr( $cb_tm_wrap ); ?>">
					<div class="wrap clearfix cb-site-padding cb-top-menu-wrap">

						<?php if ( has_nav_menu( 'small' ) ) { ?>
							<div class="cb-left-side cb-mob">

								<a href="#" id="cb-mob-open" class="cb-link"><i class="fa fa-bars"></i></a>
								<?php cb_mob_logo(); ?>
							</div>
						<?php } ?>
                        <?php cb_top_nav_left(); ?>
                        <?php echo cb_mob_extra_icons(); ?>
                        <?php echo cb_menu_icons( 'cb-top' ); ?>
					</div>
				</div>

				<div id="cb-mob-menu" class="cb-mob-menu">
					<div class="cb-mob-close-wrap">
						
						<a href="#" id="cb-mob-close" class="cb-link"><i class="fa cb-times"></i></a>
						<?php 
						echo ot_get_option( 'cb_mob_social', 'off' ) == 'on' ? '<div class="cb-mob-social">' : NULL;
				        if ( ot_get_option( 'cb_mob_menu_tw', 'off' ) == 'on' ) { ?>
				            <a href="<?php echo esc_url( 'http://www.twitter.com/' . ot_get_option( 'cb_mob_menu_tw_url', NULL ) ); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
				        <?php }

				        if ( ot_get_option( 'cb_mob_menu_fb', 'off' ) == 'on' ) { ?>
				            <a href="<?php echo esc_url( 'http://www.facebook.com/' . ot_get_option( 'cb_mob_menu_fb_url', NULL ) ); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				        <?php }

				        if ( ot_get_option( 'cb_mob_menu_go', 'off' ) == 'on' ) { ?>
				            <a href="<?php echo esc_url( 'http://plus.google.com/' . ot_get_option( 'cb_mob_menu_go_url', NULL ) ); ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
				        <?php }

				        if ( ot_get_option( 'cb_mob_menu_pi', 'off' ) == 'on' ) { ?>
				            <a href="<?php echo esc_url( 'http://www.pinterest.com/' . ot_get_option( 'cb_mob_menu_pi_url', NULL ) ); ?>" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
				        <?php }

				        if ( ot_get_option( 'cb_mob_menu_in', 'off' ) == 'on' ) { ?>
				            <a href="<?php echo esc_url( 'http://www.instagram.com/' . ot_get_option( 'cb_mob_menu_in_url', NULL ) ); ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
				        <?php }
				        echo ot_get_option( 'cb_mob_social', 'off' ) == 'on' ? '</div>' : NULL;
				        ?>
				    </div>

					<div class="cb-mob-menu-wrap">
						<?php cb_mobile_nav(); ?>
						<?php  if ( ot_get_option('cb_mob_menu_bg', NULL) != NULL ) { ?>
							<span class="cb-mob-bg"></span>
						<?php } ?>
					</div>

				</div>
			<?php } ?>

			<div id="cb-container" class="clearfix<?php if ( $cb_bg_ad !=  NULL ) { echo ' wrap'; } ?>" <?php echo $cb_review_prop; ?>>
				<?php if ( ( ( $cb_logo != NULL ) || ( cb_header_banner() != NULL ) ) && ( $cb_show_header == 'on' ) ) { ?>
					<header id="cb-header" class="cb-header <?php echo esc_attr( $cb_hd_wrap_s ) . ' ' . esc_attr( $cb_hd_wrap_s_2 ) ?>">

					    <div id="cb-logo-box" class="<?php echo esc_attr( $cb_logo_position ); ?> wrap">
	                    	<?php cb_logo(); ?>
	                        <?php echo cb_header_banner( $cb_mobile->isMobile() ); ?>
	                    </div>

					</header>
				<?php } ?>

				<?php cb_modals(); ?>
				<?php echo cb_post_formats_overlay( NULL, true ); ?>

				<?php if ( has_nav_menu( 'main' ) ) { ?>
					 <nav id="cb-nav-bar" class="clearfix <?php echo esc_attr( $cb_main_menu_wrap ); ?>">
					 	<div class="cb-nav-bar-wrap cb-site-padding clearfix cb-font-header <?php echo esc_attr( $cb_menu_wrap ); ?>">
		                    <?php echo $cb_main_menu; ?>
		                </div>
	 				</nav>
 				<?php } ?>