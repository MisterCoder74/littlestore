<?php

if (isset($_POST['buy-now'])) {
    $name = $_POST['name'];
    $year = $_POST['year'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Read existing cart items from mycart.json
    $cartItems = [];
    if (file_exists('mycart.json')) {
        $cartItems = json_decode(file_get_contents('mycart.json'), true);
    }
    
    // Add new item to cart items array
    $newItem = ['article' => $name, 'year' => $year, 'quantity' => 1, 'price' => $price];
    $cartItems[] = $newItem;
    
    // Write updated cart items array to mycart.json
    file_put_contents('mycart.json', json_encode($cartItems));
    
    // Return success message
    echo 'Item added to cart';
}

?>
