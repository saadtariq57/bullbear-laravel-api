<?php

require_once('assets/init.php');
$f = '';
$s = '';
if (isset($_GET['f'])) {
    $f = Wo_Secure($_GET['f'], 0);
}

$symbol_search = "";

// function Wo_SearchForg($search_qeury) {
//     global $wo , $sqlConnect;
//     $search_qeury = $search_qeury;
//     $data         = array();
//   $query = mysqli_query($sqlConnect, " SELECT `id` FROM " . T_GROUPS . " WHERE ((`group_name` LIKE '%$search_qeury%') OR `group_title` LIKE '%$search_qeury%')ORDER BY `id` DESC LIMIT 5");
//         if (mysqli_num_rows($query)) {
//             while ($fetched_data = mysqli_fetch_assoc($query)) {
//                 $group             = Wo_GroupData($fetched_data["id"]);
//                 // print_r($group);
//                 $new_data          = array();
//                 $new_data["id"]    = $group["id"];
//                 $new_data["label"] = $group["group_name"];
//                 $new_data["img"]   = $group["avatar"];
//                 $new_data["title"]  =$group['group_title'];
//                 $data[]            = $new_data;
//             }
//         }

// return $data;

// }
if( isset($_POST['group__name__search']) ){
   $symbol_search = $_POST['group__name__search'];
   $groups__data = Wo_SearchForg($symbol_search);
   print_r (json_encode($groups__data));
exit();
}

// if (isset($_GET['f'])) {
//     if($_GET['f'] == 'stripe_cancel'){
//         // $sub_id = $_GET['id'];
//         // include_once('assets/includes/stripe_config.php');

//         echo $sub_id;

//         print_r("Hello i am Working");

//     }
// }
if (isset($_GET['s'])) {
    $s = Wo_Secure($_GET['s'], 0);
}
$hash_id = '';
if (!empty($_POST['hash_id'])) {
    $hash_id = $_POST['hash_id'];
} else if (!empty($_GET['hash_id'])) {
    $hash_id = $_GET['hash_id'];
} else if (!empty($_GET['hash'])) {
    $hash_id = $_GET['hash'];
} else if (!empty($_POST['hash'])) {
    $hash_id = $_POST['hash'];
}
$data            = array();
$allow_array     = array(
    'upgrade',
    'paystack',
    'cashfree',
    'payment',
    'pay_with_bitcoin',
    'coinpayments_callback',
    'paypro_with_bitcoin',
    'upload-blog-image',
    'wallet',
    'download_user_info',
    'movies',
    'funding',
    'stripe',
    'stripe_cancel',
    'add_watchlist',
    'edit_watchlist',
    'get_watchlist_details',
    'delete_user_watchlist',
    'add_symbol_in_watchlist',
    'get_watchlist_symbols_details',
    'add_new_symbol_in_watchlist',
    'delete_user_watchlist_symbol',
    'add_new_symbol_from_single_stock_in_watchlist',
    'add_exam_winner',
    'add_watchlist_like_dislike',
    'coinbase',
    'load_more_products',
    'yoomoney',
    'iyzipay',
    'auto_friend_existing_paid_members',
    'reward_select_winner'
);
if ($f == 'certification' && $s == 'download_user_certification' && !empty($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $allow_array[] = 'certification';
}
$non_login_array = array(
    'session_status',
    'open_lightbox',
    'get_welcome_users',
    'load_posts',
    'save_user_location',
    'load-more-groups',
    'load-more-pages',
    'load-more-users',
    'load_profile_posts',
    'confirm_user_unusal_login',
    'confirm_user',
    'confirm_sms_user',
    'resned_code',
    'resned_code_ac',
    'resned_ac_email',
    'contact_us',
    'google_login',
    'login',
    'register',
    'upgrade',
    'recover',
    'recoversms',
    'reset_password',
    'search',
    'get_search_filter',
    'update_announcement_views',
    'get_more_hashtag_posts',
    'open_album_lightbox',
    'get_next_album_image',
    'get_previous_album_image',
    'get_next_product_image',
    'get_previous_product_image',
    'open_multilightbox',
    'get_next_image',
    'get_previous_image',
    'load-blogs',
    'load-recent-blogs',
    'get_no_posts_name',
    'search-blog-read',
    'search-blog',
    'get_payment_method',
    'stripe',
    'coinbase',
    'load_more_products',
    'yoomoney',
    'iyzipay'
);
if ($wo['config']['membership_system'] == 1) {
    $non_login_array[] = 'pro_register';
    // $non_login_array[] = 'get_payment_method';
    $non_login_array[] = 'cashfree';
    $non_login_array[] = 'paystack';
    $non_login_array[] = 'pay_using_wallet';
    $non_login_array[] = 'get_paypal_url';
    $non_login_array[] = 'stripe_payment';
    $non_login_array[] = 'paypro_with_bitcoin';
    $non_login_array[] = '2checkout_pro';
    $non_login_array[] = 'bank_transfer';
    //$non_login_array[] = 'stripe';
}
if (!in_array($f, $allow_array)) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            exit("Restrcited Area");
        }
    } else {
        exit("Restrcited Area");
    }
}
if (!in_array($f, $non_login_array)) {
    if ($wo['loggedin'] == false && ($s != 'load_more_posts')) {
        if ($s != 'load-comments') {
            exit("Please login or signup to continue.");
        }
    }
}
if ($wo['loggedin'] && $wo['user']['banned'] == 1 && !in_array($f, $non_login_array)) {
    exit();
}
$files = scandir('xhr');
unset($files[0]);
unset($files[1]);
if (file_exists('xhr/' . $f . '.php') && in_array($f . '.php', $files)) {
    include 'xhr/' . $f . '.php';
}
elseif (!empty($_GET['mode_type']) && in_array($_GET['mode_type'], array('linkedin'))) {
    include 'xhr/modes/' . Wo_Secure($_GET['mode_type']) . '.php';
}
mysqli_close($sqlConnect);
unset($wo);
exit();