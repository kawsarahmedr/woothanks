<?php
/* WooCommerce customer First Name shortcode [wct_customer_first_name] */
function woothanks_customer_firstname(){

    $user_id = get_current_user_id();
    $customer = new WC_Customer( $user_id );
    $last_order = $customer->get_last_order();
    $order_id = $last_order->get_id();
    $order = new WC_Order( $order_id );

    ob_start();
    echo $order-> get_billing_first_name();
    return ob_get_clean();
}

/* WooCommerce order overview Shortcode [wct_order_overview] */
function woothanks_order_overview(){

    $user_id = get_current_user_id();
    $customer = new WC_Customer( $user_id );
    $last_order = $customer->get_last_order();
    $order_id = $last_order->get_id();
    $order = new WC_Order( $order_id );

    ob_start();
?>
    <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

        <li class="woocommerce-order-overview__order order">
            <?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
            <strong><?php echo $order->get_order_number();?></strong>
        </li>

        <li class="woocommerce-order-overview__date date">
            <?php esc_html_e( 'Date:', 'woocommerce' ); ?>
            <strong><?php echo wc_format_datetime( $order->get_date_created() );?></strong>
        </li>

        <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
            <li class="woocommerce-order-overview__email email">
                <?php esc_html_e( 'Email:', 'woocommerce' ); ?>
                <strong><?php echo $order->get_billing_email();?></strong>
            </li>
        <?php endif; ?>

        <li class="woocommerce-order-overview__total total">
            <?php esc_html_e( 'Total:', 'woocommerce' ); ?>
            <strong><?php echo $order->get_formatted_order_total();?></strong>
        </li>

        <?php if ( $order->get_payment_method_title() ) : ?>
            <li class="woocommerce-order-overview__payment-method method">
                <?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
                <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
            </li>
        <?php endif; ?>
    </ul>
<?php
    return ob_get_clean();
}

/* WooCommerce order details shortcode [wct_order_details] */
function woothanks_order_details(){

    $user_id = get_current_user_id();
    $customer = new WC_Customer( $user_id );
    $last_order = $customer->get_last_order();
    $order_id = $last_order->get_id();
    $order = new WC_Order( $order_id );

    ob_start();

    $order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
?>
    <section class="woocommerce-order-details">
        <?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

        <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

            <thead>
                <tr>
                    <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                    <th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php
                do_action( 'woocommerce_order_details_before_order_table_items', $order );

                foreach ( $order_items as $item_id => $item ) {
                    $product = $item->get_product();

                    wc_get_template(
                        '/../../woocommerce/templates/order/order-details-item.php',
                        array(
                            'order'              => $order,
                            'item_id'            => $item_id,
                            'item'               => $item,
                            'show_purchase_note' => $show_purchase_note,
                            'purchase_note'      => $product ? $product->get_purchase_note() : '',
                            'product'            => $product,
                        )
                    );
                }

                do_action( 'woocommerce_order_details_after_order_table_items', $order );
                ?>
            </tbody>

            <tfoot>
                <?php
                foreach ( $order->get_order_item_totals() as $key => $total ) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
                            <td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
                        </tr>
                        <?php
                }
                ?>
                <?php if ( $order->get_customer_note() ) : ?>
                    <tr>
                        <th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
                        <td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
                    </tr>
                <?php endif; ?>
            </tfoot>
        </table>
        <?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
    </section>
<?php
    return ob_get_clean();
}

/* WooCommerce customer details shortcode [wct_customer_details] */
function woothanks_customer_details(){

    $user_id = get_current_user_id();
    $customer = new WC_Customer( $user_id );
    $last_order = $customer->get_last_order();
    $order_id = $last_order->get_id();
    $order = new WC_Order( $order_id );

    ob_start();

    wc_get_template( '/../../woocommerce/templates/order/order-details-customer.php', array( 'order' => $order ) );

    return ob_get_clean();
}

/* UrlDev Hero Area shortcode to display the banner img */
function urldev_hero_img_shortcode($args = array(), $content = ""){
    
    ob_start();
    if ($content != "") {
?>
        <section class="urldev-hero-img-section">
            <div class="urldev-hero-img">
                <img style="width: 100%!important;" src="<?php echo do_shortcode($content); ?>" alt="trilonium hero image">
            </div>
        </section>
<?php
    }
    return ob_get_clean();
}