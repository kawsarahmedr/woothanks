<?php
/**
 * This template redirect customer to custom thank you page
 * @since version 1.0.0
 **/
function woothanks_redirect(){
    $woothanksPage = '';
    $woothanksPageID = get_theme_mod('woothanks_page' );
    if( $woothanksPageID != ''){
        $woothanksPage = $woothanksPageID;
    }
    $orderKey = $_GET['key'];
    if( is_wc_endpoint_url( 'order-received' ) && isset( $orderKey ) && $woothanksPage != '' ) {
        wp_redirect( get_page_link( $woothanksPage ) . '?key=' .  $orderKey );
        exit;
    }
}