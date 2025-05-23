<?php

define('DB_FILE', __DIR__ . '/store.db');
session_start();

function init_db()
{
    $db = new SQLite3(DB_FILE);

    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='products'");
    if (!$result->fetchArray()) {
        $db->exec('
            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                price DECIMAL(10,2) NOT NULL
            )
        ');

        $db->exec('
            CREATE TABLE cart_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                session_id TEXT NOT NULL,
                product_id INTEGER NOT NULL,
                quantity INTEGER NOT NULL DEFAULT 1,
                FOREIGN KEY (product_id) REFERENCES products(id)
            )
        ');

        $db->exec("INSERT INTO products (name, price) VALUES
            ('Молоко пастеризоване', 12),
            ('Хліб чорний', 9),
            ('Сир білий', 21),
            ('Сметана 20%', 25),
            ('Кефір 1%', 19),
            ('Вода газована', 18),
            ('Печиво \"Весна\"', 14)
        ");
    }

    return $db;
}

function get_db()
{
    static $db = null;
    if ($db === null) {
        $db = init_db();
    }
    return $db;
}

function get_products()
{
    $db = get_db();
    $result = $db->query('SELECT * FROM products');

    $products = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $products[$row['id']] = $row;
    }

    return $products;
}

function get_cart_items()
{
    $db = get_db();
    $session_id = session_id();

    $stmt = $db->prepare('
        SELECT c.id, c.product_id, c.quantity, p.name, p.price 
        FROM cart_items c
        JOIN products p ON c.product_id = p.id
        WHERE c.session_id = :session_id
    ');
    $stmt->bindValue(':session_id', $session_id, SQLITE3_TEXT);
    $result = $stmt->execute();

    $cart_items = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $cart_items[] = $row;
    }

    return $cart_items;
}

function add_to_cart($product_id, $quantity)
{
    $db = get_db();
    $session_id = session_id();

    $stmt = $db->prepare('
        SELECT id, quantity FROM cart_items 
        WHERE session_id = :session_id AND product_id = :product_id
    ');
    $stmt->bindValue(':session_id', $session_id, SQLITE3_TEXT);
    $stmt->bindValue(':product_id', $product_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $existing_item = $result->fetchArray(SQLITE3_ASSOC);

    if ($existing_item) {
        $new_quantity = $existing_item['quantity'] + $quantity;
        $stmt = $db->prepare('
            UPDATE cart_items 
            SET quantity = :quantity 
            WHERE id = :id
        ');
        $stmt->bindValue(':quantity', $new_quantity, SQLITE3_INTEGER);
        $stmt->bindValue(':id', $existing_item['id'], SQLITE3_INTEGER);
        $stmt->execute();
    } else {
        $stmt = $db->prepare('
            INSERT INTO cart_items (session_id, product_id, quantity)
            VALUES (:session_id, :product_id, :quantity)
        ');
        $stmt->bindValue(':session_id', $session_id, SQLITE3_TEXT);
        $stmt->bindValue(':product_id', $product_id, SQLITE3_INTEGER);
        $stmt->bindValue(':quantity', $quantity, SQLITE3_INTEGER);
        $stmt->execute();
    }
}

function update_cart_item($item_id, $quantity)
{
    $db = get_db();

    if ($quantity <= 0) {
        $stmt = $db->prepare('DELETE FROM cart_items WHERE id = :id');
        $stmt->bindValue(':id', $item_id, SQLITE3_INTEGER);
    } else {
        $stmt = $db->prepare('UPDATE cart_items SET quantity = :quantity WHERE id = :id');
        $stmt->bindValue(':quantity', $quantity, SQLITE3_INTEGER);
        $stmt->bindValue(':id', $item_id, SQLITE3_INTEGER);
    }

    $stmt->execute();
}

function calculate_cart_total()
{
    $cart_items = get_cart_items();
    $total = 0;

    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return $total;
}
