<?php

require_once '../db/config.php';
session_start();

$cart_items = get_cart_items();
foreach ($cart_items as $item) {
    update_cart_item($item['id'], 0);
}

$_SESSION['checkout_success'] = true;

header('Location: cart.php');
exit;
