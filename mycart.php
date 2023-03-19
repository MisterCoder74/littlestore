
<html>
<head>
<style>
    .cart-table {
        border-collapse: collapse;
        width: 100%;
    }
    
    .cart-table th, .cart-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    .cart-table th {
        background-color: #f2f2f2;
    }
    
    .quantity-input {
        width: 50px;
    }
    
    .subtotal, .grand-total, .price {
        text-align: right;
    }
    
    .checkout-button {
        display: inline-block;
  padding: 10px 20px;
  background-color: #ff0000;
  color: #ffffff;
  font-weight: bold;
  text-transform: uppercase;
  text-decoration: none;
  border-radius: 5px;

    }
    
    .headingbanner {
text-align: center;
}

header {
display: flex;
justify-content: space-between;
align-items: center;
width: 100%;
padding: 10px 10px;
background: red;
color: white;
box-shadow: 0px 6px 10px grey;
box-sizing: border-box;
}

a {
color: white;
text-decoration: none;
font-size: 1.1rem;
}
a:hover {
color: black;
text-decoration: underline;
font-size: 1.1rem;
}


body {
box-sizing: border-box;
}
</style>
</head>
<body>
<header>
  <h2 class="headingbanner">Your Shopping Cart</h2>
      <a href="random_objects.php">Back to shop</a>
</header>  

<?php
$cart_file = 'mycart.json';
$cart_items = json_decode(file_get_contents($cart_file), true);

$table_output = '<table class="cart-table">';
$table_output .= '<thead><tr><th>Item</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr></thead>';
$table_output .= '<tbody>';

$total = 0;
$subtotal = 0;
$checkout_items = array();

foreach ($cart_items as $item) {
    $table_output .= '<tr>';
    $table_output .= '<td>' . $item['article'] . '</td>';
    $table_output .= '<td class="price">' . $item['price'] . '</td>';
    $table_output .= '<td><input type="number" class="quantity-input" value="' . $item['quantity'] . '" min="0"></td>';
    $subtotal = $item['price'] * $item['quantity'];
    $table_output .= '<td class="subtotal">' . $subtotal . '</td>';
    $table_output .= '</tr>';

    $checkout_items[] = array(
        'article' => $item['article'],
        'price' => $item['price'],
        'quantity' => $item['quantity'],
        'subtotal' => $subtotal
    );

    $total += $subtotal;
}

$table_output .= '</tbody>';
$table_output .= '<tfoot>';
$table_output .= '<tr><td colspan="3">Grand Total:</td><td class="grand-total">' . $total . '</td></tr>';
$table_output .= '<tr><td colspan="4"><a class="checkout-button" href="checkout.php">Proceed to Checkout</a></td></tr>';
$table_output .= '</tfoot>';
$table_output .= '</table>';

echo $table_output;

if (isset($_GET['checkout'])) {
    $checkout_file = 'checkout.json';
    $checkout_data = array(
        'items' => $checkout_items,
        'total' => $total
    );
    $checkout_json = json_encode($checkout_data);

    file_put_contents($checkout_file, $checkout_json);

    // Redirect to thank you page or clear cart, etc.
}
?>

<script>
function updateSubtotal(row) {
    var price = parseFloat(row.querySelector('.price').textContent);
    var quantity = parseInt(row.querySelector('.quantity-input').value);
    var subtotal = price * quantity;
    row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
    return subtotal;
}

function updateTotal() {
    var rows = document.querySelectorAll('.cart-table tbody tr');
    var total = 0;
    rows.forEach(function(row) {
        total += updateSubtotal(row);
    });
    document.querySelector('.grand-total').textContent = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    var quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            updateTotal();
        });
    });
});

document.querySelector('.checkout-button').addEventListener('click', function(e) {
    e.preventDefault();
    window.location.href = 'checkout.php';
});
</script>


</body>
</html>
