<?php
function woothanks_activate(){
    // This is plugin is compitable with v5.0 or latter
    if( version_compare( get_bloginfo( 'version'), '5.0', '<') ){
        wp_die( __( "You must update to use this plugin.", "woothanks") );
    }
}