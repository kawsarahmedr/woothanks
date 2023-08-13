<?php
/**
 * This functional template will create Customizer API setting to set custom page
 * @since version 1.0.0
 **/
function woothanks_customization($customize){
	// WooThanks Options
	$customize->add_section('woothanks_section', array(
		'title' => __('WooThanks', 'woothanks'),
		'priority' => 10
	));
	$customize->add_setting('woothanks_page', array(
		'default' => __('', 'woothanks'),
		'transport' => 'refresh'
	));
	$customize->add_control('woothanks_page', array(
		'section' => 'woothanks_section',
		'label' => __('Enter Custom "Thank You" Page ID:', 'woothanks'),
		'description' => __( 'Leave it empty for default woocommerce redirection.', 'woothanks' ),
		'type' => 'number'
	));
}