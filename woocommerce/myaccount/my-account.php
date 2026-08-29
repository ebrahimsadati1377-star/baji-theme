<?php
/**
 * My Account page - BajiStyle Custom Version (Without Downloads)
 */

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
$user_id = get_current_user_id();
$orders = wc_get_orders(['customer' => $user_id, 'limit' => 5]);
$points = get_user_meta($user_id, 'baji_user_points', true) ?: 0;
$wishlist_count = function_exists('bajistyle_get_wishlist_count') ? bajistyle_get_wishlist_count() : 0;
?>

<div class="baji-dashboard-wrapper max-w-7xl mx-auto px-4 py-8">

    <?php if (is_user_logged_in()) : ?>

        <!-- ====== هدر کاربر ====== -->
        <div class="bg-gradient-to-r from-amber-50 via-white to-amber-50 rounded-2xl p-6 md:p-8 mb-8 shadow-sm border border-amber-100">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="relative">
                    <?php echo get_avatar($user_id, 80, '', '', ['class' => 'rounded-full border-4 border-amber-400']); ?>
                    <span class="absolute -bottom-1 -right-1 bg-green-500 w-4 h-4 rounded-full border-2 border-white"></span>
                </div>
                <div class="flex-1 text-center md:text-right">
                    <h1 class="text-2xl font-bold text-gray-800">
                        خوش آمدی، <?php echo esc_html($current_user->display_name); ?> 
                        <i class="fa-regular fa-hand-peace text-amber-500"></i>
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fa-regular fa-envelope text-gray-400 ml-1"></i>
                        <?php echo esc_html($current_user->user_email); ?>
                    </p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-3">
                        <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fa-solid fa-star text-amber-500"></i> 
                            <?php echo number_format($points); ?> امتیاز
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fa-regular fa-bag-shopping text-blue-500"></i> 
                            <?php echo count($orders); ?> سفارش
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">
                            <i class="fa-regular fa-heart text-red-500"></i> 
                            <?php echo $wishlist_count; ?> علاقه‌مندی
                        </span>
                    </div>
                </div>
                <a href="<?php echo wc_logout_url(home_url('/login')); ?>" 
                   class="bg-red-50 text-red-600 px-5 py-2 rounded-full hover:bg-red-100 transition text-sm font-medium flex items-center gap-2">
                    <span>خروج</span>
                    <i class="fa-regular fa-arrow-right-from-bracket"></i>
                </a>
            </div>
        </div>

        <!-- ====== ناوبری تب‌ها (بدون دانلودها) ====== -->
        <div class="flex flex-wrap gap-1 border-b border-gray-200 mb-8 overflow-x-auto">
            <?php 
            $tabs = apply_filters('baji_myaccount_tabs', [
                'dashboard' => ['label' => 'داشبورد', 'icon' => 'fa-regular fa-gauge-high'],
                'orders' => ['label' => 'سفارشات', 'icon' => 'fa-regular fa-truck-fast'],
                'edit-account' => ['label' => 'ویرایش حساب', 'icon' => 'fa-regular fa-user-pen'],
                'address' => ['label' => 'آدرس‌ها', 'icon' => 'fa-regular fa-location-dot'],
                'wishlist' => ['label' => 'علاقه‌مندی‌ها', 'icon' => 'fa-regular fa-heart'],
            ]);
            
			$current_tab = is_wc_endpoint_url( 'wishlist' )
				? 'wishlist'
				: ( isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'dashboard' );
            ?>
            
            <?php foreach ($tabs as $key => $tab) : 
                $is_active = $current_tab === $key;
                $active_class = $is_active ? 'border-b-2 border-amber-500 text-amber-700 bg-amber-50/50' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50';
            ?>
				<a href="<?php echo esc_url( add_query_arg( 'tab', $key, wc_get_page_permalink( 'myaccount' ) ) ); ?>" 
                   class="px-4 py-3 text-sm font-medium whitespace-nowrap transition-all <?php echo $active_class; ?>">
                    <i class="<?php echo $tab['icon']; ?> ml-1.5"></i>
                    <?php echo $tab['label']; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- ====== محتوای تب‌ها ====== -->
        <div class="baji-dashboard-content min-h-[400px]">
            
            <?php switch($current_tab) : 
                
                case 'orders': ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-xl font-bold mb-4">
                            <i class="fa-regular fa-truck-fast text-amber-500 ml-2"></i>
                            سفارشات شما
                        </h2>
                        <?php wc_get_template('myaccount/orders.php', ['current_user' => $current_user]); ?>
                    </div>
                    <?php break;
                    
                case 'edit-account': ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-xl font-bold mb-4">
                            <i class="fa-regular fa-user-pen text-amber-500 ml-2"></i>
                            ویرایش حساب کاربری
                        </h2>
                        <?php wc_get_template('myaccount/form-edit-account.php', ['user' => $current_user]); ?>
                    </div>
                    <?php break;
                    
                case 'address': ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-xl font-bold mb-4">
                            <i class="fa-regular fa-location-dot text-green-500 ml-2"></i>
                            آدرس‌های من
                        </h2>
                        <?php wc_get_template('myaccount/my-address.php'); ?>
                    </div>
                    <?php break;
                    
                case 'wishlist': ?>
					<?php get_template_part( 'template-parts/account/wishlist' ); ?>
                    <?php break;
                    
                default: ?>
                    <!-- ====== داشبورد ====== -->
                    
                    <!-- کارت‌های آماری -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <?php 
                        $stats = [
                            ['label' => 'کل سفارشات', 'value' => count($orders), 'icon' => 'fa-regular fa-bag-shopping', 'color' => 'blue'],
                            ['label' => 'در انتظار', 'value' => count(wc_get_orders(['customer' => $user_id, 'status' => 'pending'])), 'icon' => 'fa-regular fa-clock', 'color' => 'yellow'],
                            ['label' => 'تکمیل شده', 'value' => count(wc_get_orders(['customer' => $user_id, 'status' => 'completed'])), 'icon' => 'fa-regular fa-circle-check', 'color' => 'green'],
                            ['label' => 'امتیازات', 'value' => number_format($points), 'icon' => 'fa-regular fa-star', 'color' => 'amber'],
                        ];
                        foreach ($stats as $stat) : ?>
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition text-center">
                                <i class="<?php echo $stat['icon']; ?> text-2xl text-<?php echo $stat['color']; ?>-500 mb-1.5"></i>
                                <div class="text-xl font-bold text-<?php echo $stat['color']; ?>-600"><?php echo $stat['value']; ?></div>
                                <div class="text-xs text-gray-500"><?php echo $stat['label']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- آخرین سفارشات -->
                    <?php if (!empty($orders)) : ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-lg">
                                <i class="fa-regular fa-clock text-amber-500 ml-2"></i>
                                آخرین سفارشات
                            </h3>
                            <a href="<?php echo esc_url(add_query_arg('tab', 'orders')); ?>" 
                               class="text-amber-600 text-sm hover:underline flex items-center gap-1">
                                مشاهده همه
                                <i class="fa-regular fa-arrow-left text-xs"></i>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200 text-gray-500">
                                        <th class="text-right py-2 px-3 font-normal">
                                            <i class="fa-regular fa-hashtag ml-1"></i>#
                                        </th>
                                        <th class="text-right py-2 px-3 font-normal">
                                            <i class="fa-regular fa-calendar ml-1"></i>تاریخ
                                        </th>
                                        <th class="text-right py-2 px-3 font-normal">
                                            <i class="fa-regular fa-money-bill ml-1"></i>مبلغ
                                        </th>
                                        <th class="text-right py-2 px-3 font-normal">
                                            <i class="fa-regular fa-circle-check ml-1"></i>وضعیت
                                        </th>
                                        <th class="text-right py-2 px-3 font-normal">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($orders, 0, 3) as $order) : ?>
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                        <td class="py-3 px-3 font-medium">#<?php echo $order->get_order_number(); ?></td>
                                        <td class="py-3 px-3 text-gray-600"><?php echo $order->get_date_created()->date_i18n('Y/m/d'); ?></td>
                                        <td class="py-3 px-3 font-medium"><?php echo wc_price($order->get_total()); ?></td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                <?php echo $order->get_status() === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                                                <?php echo wc_get_order_status_name($order->get_status()); ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <a href="<?php echo $order->get_view_order_url(); ?>" 
                                               class="text-amber-600 hover:text-amber-800 text-xs font-medium flex items-center gap-1">
                                                مشاهده
                                                <i class="fa-regular fa-arrow-left text-[10px]"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                    
            <?php endswitch; ?>
        </div>

    <?php else : ?>
        
        <!-- ====== کاربر لاگین نیست ====== -->
        <div class="text-center py-20">
            <div class="text-7xl mb-6">
                <i class="fa-regular fa-lock text-gray-300"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">وارد حساب کاربری خود شوید</h2>
            <p class="text-gray-500 max-w-md mx-auto mb-10">
                برای مشاهده سفارشات و مدیریت حساب کاربری خود وارد شوید.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo home_url('/login'); ?>" 
                   class="bg-amber-600 text-white px-8 py-3 rounded-full hover:bg-amber-700 transition font-medium inline-flex items-center gap-2">
                    <i class="fa-regular fa-arrow-right-to-bracket"></i>
                    ورود به حساب کاربری
                </a>
                <a href="<?php echo home_url('/register'); ?>" 
                   class="bg-gray-100 text-gray-700 px-8 py-3 rounded-full hover:bg-gray-200 transition font-medium inline-flex items-center gap-2">
                    <i class="fa-regular fa-user-plus"></i>
                    ثبت‌نام جدید
                </a>
            </div>
            
            <!-- مزیت‌های عضویت -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto mt-16 text-right">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-3xl mb-3 text-amber-500">
                        <i class="fa-regular fa-bag-shopping"></i>
                    </div>
                    <h4 class="font-bold mb-1">سفارشات شما</h4>
                    <p class="text-sm text-gray-500">مشاهده و پیگیری تمام سفارشات</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-3xl mb-3 text-blue-500">
                        <i class="fa-regular fa-location-dot"></i>
                    </div>
                    <h4 class="font-bold mb-1">مدیریت آدرس‌ها</h4>
                    <p class="text-sm text-gray-500">افزودن و ویرایش آدرس‌های ارسال</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-3xl mb-3 text-amber-500">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <h4 class="font-bold mb-1">امتیازات ویژه</h4>
                    <p class="text-sm text-gray-500">جمع‌آوری امتیاز و دریافت تخفیف</p>
                </div>
            </div>
        </div>
        
    <?php endif; ?>

</div>
