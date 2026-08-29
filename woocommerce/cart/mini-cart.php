<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( WC()->cart && ! WC()->cart->is_empty() ) : ?>

    <ul class="woocommerce-mini-cart cart_list product_list_widget divide-y divide-gray-100">
        <?php
        do_action( 'woocommerce_before_mini_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'thumbnail', array( 'class' => 'w-16 h-16 object-cover rounded-lg' ) ), $cart_item, $cart_item_key );
                $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>
                
                <!-- اضافه شدن کلاس baji-cart-item برای انیمیشن حذف -->
                <li class="woocommerce-mini-cart-item baji-cart-item py-4 flex items-center gap-4 relative group transition-opacity duration-300">
                    <?php
                    // اضافه شدن کلاس‌های پیش‌فرض ووکامرس و Data Attributeها برای کارکرد صحیح AJAX
                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                        '<a href="%s" class="remove remove_from_cart_button baji-cart-item-remove absolute -top-1 -right-2 bg-gray-100 hover:bg-red-500 hover:text-white transition-colors rounded-full w-5 h-5 flex items-center justify-center text-xs text-gray-400 z-10" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                        esc_attr__( 'Remove this item', 'woocommerce' ),
                        esc_attr( $product_id ),
                        esc_attr( $cart_item_key ),
                        esc_attr( $_product->get_sku() )
                    ), $cart_item_key );
                    ?>

                    <div class="flex-shrink-0">
                        <?php echo $thumbnail; ?>
                    </div>

                    <div class="flex-grow">
                        <a href="<?php echo esc_url( $product_permalink ); ?>" class="text-sm font-medium text-gray-800 hover:text-baji-gold transition-colors line-clamp-1">
                            <?php echo wp_kses_post( $product_name ); ?>
                        </a>
                        <div class="text-xs text-gray-500 mt-1">
                            <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
                            <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="block">' . sprintf( '%s × %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                        </div>
                    </div>
                </li>
                <?php
            }
        }
        do_action( 'woocommerce_mini_cart_contents' );
        ?>
    </ul>

<div class="pt-6 border-t border-gray-100 mt-2">
        <div class="flex justify-between items-center mb-6 text-sm font-bold">
            <?php do_action( 'woocommerce_widget_shopping_cart_total' ); ?>
        </div>
        
        <div class="flex flex-col gap-3">
            <?php 
            // در اینجا دکمه‌ها را به صورت دستی با کلاس‌های اختصاصی خودت فراخوانی می‌کنیم
            // یا اگر می‌خواهی اکشن ووکامرس را نگه داری، مطمئن شو CSS آن را در فایل استایلت override کرده‌ای.
            ?>
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="baji-btn-secondary text-center block">
                <?php esc_html_e( 'مشاهده سبد خرید', 'woocommerce' ); ?>
            </a>
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="baji-btn-primary text-center block">
                <?php esc_html_e( 'تسویه حساب', 'woocommerce' ); ?>
            </a>
        </div>
    </div>

<?php else : ?>
    <div class="text-center py-12">
        <p class="text-gray-400 text-sm italic"><?php esc_html_e( 'سبد خرید خالی است.', 'woocommerce' ); ?></p>
    </div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>