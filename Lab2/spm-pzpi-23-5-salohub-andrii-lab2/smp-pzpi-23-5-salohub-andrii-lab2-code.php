<?php

$MIN_AGE = 7;
$MAX_AGE = 150;
$MIN_QUANTITY = 0;
$MAX_QUANTITY = 100;

function loadProducts()
{
    $jsonFile = 'smp-pzpi-23-5-salohub-andrii-lab2_products.json';

    if (!file_exists($jsonFile)) {
        die("Помилка: Файл продуктів {$jsonFile} не знайдено");
    }

    $jsonData = file_get_contents($jsonFile);
    $products = json_decode($jsonData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Помилка при розборі JSON: " . json_last_error_msg());
    }

    return $products;
}

$products = loadProducts();

$cart = [];
$userName = null;
$userAge = null;

function main()
{
    echo "\n";
    echo "################################\n";
    echo "# ПРОДОВОЛЬЧИЙ МАГАЗИН \"ВЕСНА\" #\n";
    echo "################################\n";

    while (true) {
        showMenu();
        $command = trim(readline("Введіть команду: "));

        switch ($command) {
            case '0':
                exit(0);
            case '1':
                selectProducts();
                break;
            case '2':
                showReceipt();
                break;
            case '3':
                setupProfile();
                break;
            default:
                echo "ПОМИЛКА! Введіть правильну команду\n";
                break;
        }
    }
}

function showMenu()
{
    echo "1 Вибрати товари\n";
    echo "2 Отримати підсумковий рахунок\n";
    echo "3 Налаштувати свій профіль\n";
    echo "0 Вийти з програми\n";
}

function selectProducts()
{
    global $products, $cart, $MIN_QUANTITY, $MAX_QUANTITY;

    while (true) {
        showProductsList();
        $choice = trim(readline("Виберіть товар: "));

        if ($choice === '0') {
            return;
        }

        if (!isset($products[(int)$choice])) {
            echo "ПОМИЛКА! ВКАЗАНО НЕПРАВИЛЬНИЙ НОМЕР ТОВАРУ\n";
            continue;
        }

        $selectedProduct = $products[(int)$choice];
        echo "Вибрано: {$selectedProduct['name']}\n";
        $quantity = (int)trim(readline("Введіть кількість, штук: "));

        if ($quantity < $MIN_QUANTITY || $quantity >= $MAX_QUANTITY) {
            echo "ПОМИЛКА! Кількість повинна бути більше {$MIN_QUANTITY} і менше {$MAX_QUANTITY}\n";
            continue;
        }

        if ($quantity < $MIN_QUANTITY) {
            echo "ПОМИЛКА! Кількість не може бути від'ємною.\n";
        } elseif ($quantity === 0) {
            if (isset($cart[$choice])) {
                unset($cart[$choice]);
                echo "ВИДАЛЯЮ ТОВАР З КОШИКА\n";
            } else {
                echo "Товару немає в кошику для видалення.\n";
            }
            if (empty($cart)) {
                echo "КОШИК ПОРОЖНІЙ\n";
            } else {
                $cart[$choice] = $quantity;
                echo "У КОШИКУ:\n";
                $nameWidth = getMaxNameLength() + 1;

                $nameHeader = custom_str_pad('НАЗВА', $nameWidth);
                echo "{$nameHeader} КІЛЬКІСТЬ\n";

                foreach ($cart as $productId => $quantity) {
                    if ($quantity > $MIN_QUANTITY) {
                        $paddedName = custom_str_pad($products[$productId]['name'], $nameWidth);
                        echo "{$paddedName} {$quantity}\n";
                    }
                }
            }
        } elseif ($quantity >= $MAX_QUANTITY) {
            echo "ПОМИЛКА! Кількість товару не може бути 100 або більше.\n";
        } else {
            $cart[$choice] = $quantity;
            echo "У КОШИКУ:\n";
            $nameWidth = getMaxNameLength() + 1;

            $nameHeader = custom_str_pad('НАЗВА', $nameWidth);
            echo "{$nameHeader} КІЛЬКІСТЬ\n";

            foreach ($cart as $productId => $quantity) {
                if ($quantity > $MIN_QUANTITY) {
                    $paddedName = custom_str_pad($products[$productId]['name'], $nameWidth);
                    echo "{$paddedName} {$quantity}\n";
                }
            }
        }
        echo "\n";
    }
}

function getMaxNameLength()
{
    global $products;
    $maxLength = 0;
    foreach ($products as $product) {
        $length = utf8_char_count($product['name']);
        if ($length > $maxLength) {
            $maxLength = $length;
        }
    }
    return $maxLength;
}

function showProductsList()
{
    global $products;

    $nameWidth = getMaxNameLength() + 1;

    $nameHeader = custom_str_pad('НАЗВА', $nameWidth);
    echo "№  {$nameHeader} ЦІНА\n";

    foreach ($products as $id => $product) {
        $paddedName = custom_str_pad($product['name'], $nameWidth);
        printf("%-2d %s %s\n", $id, $paddedName, $product['price']);
    }
    echo "   -----------\n";
    echo "0  ПОВЕРНУТИСЯ\n";
}

function showReceipt()
{
    global $products, $cart, $MIN_QUANTITY;
    if (empty($cart)) {
        echo "\nВаш кошик порожній.\n";
        return;
    }

    $nameWidth = getMaxNameLength() + 1;
    $nameHeader = custom_str_pad('НАЗВА', $nameWidth);
    $priceHeader = custom_str_pad('ЦІНА', 5);
    $quantityHeader = custom_str_pad('КІЛЬКІСТЬ', 10);
    $costHeader = custom_str_pad('ВАРТІСТЬ', 8);
    echo "№  {$nameHeader} {$priceHeader} {$quantityHeader} {$costHeader}\n";

    $totalSum = 0;
    $itemNumber = 1;

    foreach ($cart as $productId => $quantity) {
        if ($quantity > $MIN_QUANTITY) {
            $product = $products[$productId];
            $itemCost = $product['price'] * $quantity;
            $totalSum += $itemCost;

            $paddedName = custom_str_pad($product['name'], $nameWidth);
            printf(
                "%-2d %s %-5d %-10d %d\n",
                $itemNumber++,
                $paddedName,
                $product['price'],
                $quantity,
                $itemCost
            );
        }
    }
    echo "РАЗОМ ДО СПЛАТИ: {$totalSum}\n";
    echo "\n";
}

function setupProfile()
{
    global $userName, $userAge, $MIN_AGE, $MAX_AGE;

    while (true) {
        $name = trim(readline("Ваше ім'я: "));

        if (empty($name) || !preg_match('/[a-zA-Zа-яА-ЯіІїЇєЄґҐ]/', $name)) {
            echo "ПОМИЛКА! Ім'я повинно містити хоча б одну літеру\n";
            continue;
        }

        $userName = $name;
        break;
    }

    while (true) {
        $age = (int)trim(readline("Ваш вік: "));

        if ($age < $MIN_AGE || $age > $MAX_AGE) {
            echo "ПОМИЛКА! Вік повинен бути від {$MIN_AGE} до {$MAX_AGE} років\n";
            continue;
        }

        $userAge = $age;
        break;
    }

    echo "\n";
    echo "Ваше ім'я: {$userName}\n";
    echo "Ваш вік: {$userAge}\n";
    echo "\n";
}

function utf8_char_count($string)
{
    $length = 0;
    $i = 0;
    $bytes = strlen($string);

    while ($i < $bytes) {
        $byte = ord($string[$i]);
        if ($byte < 0x80) {
            $i += 1;
        } elseif ($byte < 0xE0) {
            $i += 2;
        } elseif ($byte < 0xF0) {
            $i += 3;
        } else {
            $i += 4;
        }
        $length++;
    }

    return $length;
}

function custom_str_pad($string, $pad_length)
{
    $char_count = utf8_char_count($string);
    $padding = max(0, $pad_length - $char_count);
    return $string . str_repeat(' ', $padding);
}

main();
