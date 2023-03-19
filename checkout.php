<?php
// read the contents of the checkout.json file
$checkout_data = file_get_contents('checkout.json');

// decode the JSON data into a PHP array
$checkout_array = json_decode($checkout_data, true);

// get the items array and total amount from the checkout array
$items = $checkout_array['items'];
$total = $checkout_array['total'];
?>

<!-- display the items and total amount in an HTML table -->
<html>
<head>
<style>
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

.paynow-button {
        display: inline-block;
  padding: 10px 20px;
  background-color: #ff0000;
  color: #ffffff;
  font-weight: bold;
  text-transform: uppercase;
  text-decoration: none;
  border-radius: 5px;
}

table {
width: 70%;
margin: 25px;
padding: 5px;
}

th {
background: #ddd;
padding: 5px;
text-align: left;

}

tr {
padding: 5px;
text-align: left;
}

form {
width: 20%;
margin-top: 20px;
padding: 10px 30px;
box-shadow: 0px 6px 8px grey;

}

input {
margin-bottom: 10px;
}

fieldset {
margin: 10px 0;
}

</style>
</head>
<body>
<header>
  <h2 class="headingbanner">Checkout summary</h2>
      <a href="mycart.php">Back to your Cart</a>
</header> 

<table>
  <thead>
    <tr>
      <th>Article</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Subtotal</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
      <tr>
        <td><?php echo $item['article']; ?></td>
        <td><?php echo $item['price']; ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td><?php echo $item['subtotal']; ?></td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="3">Grand Total:</td>
      <td><?php echo $total; ?></td>
    </tr>
  </tbody>
</table>
<p></p>
<header>
  <h2 class="headingbanner">Your payment data</h2>
      <a href="mycart.php">Back to your Cart</a>
</header> 
<!-- form for user information and payment -->
<form method="post" action="process_payment.php">

<fieldset>
<legend>Personal Information</legend>
  <label for="name">Name:</label><br>
  <input type="text" id="name" name="name" required><br>

  <label for="surname">Surname:</label><br>
  <input type="text" id="surname" name="surname" required><br>

  <label for="address">Address:</label><br>
  <input type="text" id="address" name="address" required><br>
</fieldset>
<fieldset>
<legend>Credit Card Information</legend>

  <label for="credit_card_holder">Credit Card Holder:</label><br>
  <input type="text" id="credit_card_holder" name="credit_card_holder" required><br>

<label for="credit_card_number">Credit Card Number:</label><br>
  <input type="text" id="credit_card_number" name="credit_card_number" required><br>
  
  <label for="credit_card_expiry">Expires in:</label><br>
<input type="month" id="credit_card_expiry" name="credit_card_expiry"  min="2023-03" value="2023-03"><br>

<label for="credit_card_cvv">CVV:</label><br>
 <input type="text" id="credit_card_cvv" name="credit_card_cvv" maxlength="3"><br>
</fieldset>
  <input class="paynow-button" type="submit" value="Pay Now">
  
</form>
</body>
</html>