<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy-now'])) {
  $name = $_POST['name'];
  $year = $_POST['year'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  
  $filename = 'mycart.json';
  $jsonString = file_get_contents($filename);
  $cart = json_decode($jsonString, true);
  
  $cart[] = [
    'name' => $name,
    'year' => $year,
    'description' => $description,
    'price' => floatval($price)
  ];
  
  $jsonData = json_encode($cart);
  file_put_contents($filename, $jsonData);
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Objects Catalog</title>
  <style>
    .cards-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  margin: 20px;
}

.card {
  display: flex;
  flex-direction: column;
  width: 200px;
  height: 380px;
  margin: 10px;
  padding: 20px 10px;
  background-color: #ffffff;
  border-radius: 5px;
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.3);
  transition: box-shadow 0.3s;
  border: 2px solid transparent;
  align-items: center;
  position: relative;
}

.card:hover {
  border: 2px solid #ff0000;
  box-shadow: 0px 0px 10px 2px rgba(255,0,0,0.5);
}

.card-image {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background-color: #ff0000;
  color: #ffffff;
  font-size: 24px;
  font-weight: bold;
  text-transform: uppercase;
}

.card-details {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  margin-top: 5px;
  align-items: center;
}

.card-name {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 5px;
}

.card-year {
  font-size: 14px;
  margin-bottom: 5px;
}

.card-type {
  font-size: 16px;
  margin-bottom: 5px;
  text-transform: uppercase;
}

.card-description {
  font-size: 14px;
  margin-bottom: 5px;
  text-align: justify;
}

.card-price {
  font-size: 18px;
  font-weight: bold;
   position: absolute;
 bottom: 50px;
}

.buy-now {
  display: inline-block;
  padding: 10px 20px;
  background-color: #ff0000;
  color: #ffffff;
  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
  text-decoration: none;
  border-radius: 5px;
 position: absolute;
 bottom: 5px;
}

.headingbanner {
text-align: center;
}

header {
display: flex;
justify-content: space-between;
align-items: center;
width: 100%;
padding: 15px 10px;
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
  <h2 class="headingbanner">Random Offers for today, <?php echo date('l, F jS, Y'); ?></h2>
      <a href="mycart.php">Go to My Cart</a>
</header>      
  <div class="cards-container">
    <?php
    $jsonString = file_get_contents('output.json');
    $objects = json_decode($jsonString, true);
    foreach ($objects as $object) {
      echo '<div class="card">';
      echo '<div class="card-image">' . substr($object['object'], 0, 1) . '</div>';
      echo '<div class="card-details">';
      echo '<div class="card-name">' . $object['article'] . '</div>';
      echo '<div class="card-description">' . $object['description'] . '</div>';      
      echo '<b>Year:</b> <span class="card-year">' . $object['year'] . '</span>';

      echo '<hr width="80">';
      echo '<b>Category:</b> <span class="card-type">' . $object['articletype'] . '</span>';      
      echo '<span class="card-price">' . $object['price'] . '</span>';

echo '<a href="#" class="buy-now">Buy Now</a>';
      echo '</div>';
      echo '</div>';
    }
    
?>
  </div>
  

    

    
    <script>
      const buyNowButtons = document.querySelectorAll('.buy-now');
      buyNowButtons.forEach(button => {
        button.addEventListener('click', (event) => {
          const card = event.target.closest('.card');
          const name = card.querySelector('.card-name').textContent;
          const year = card.querySelector('.card-year').textContent;
          const description = card.querySelector('.card-description').textContent;
          const price = card.querySelector('.card-price').textContent;
          
          const data = {
            name: name,
            year: year,
            description: description,
            price: price
          };
          
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'add-to-cart.php');

          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.onload = function() {
            if (xhr.status === 200) {
              console.log(xhr.responseText);
            }
          };
          xhr.send(encodeURI('buy-now=true&name=' + data.name + '&year=' + data.year + '&description=' + data.description + '&price=' + data.price));
        });
      });
    </script>
  
</body>
</html>
