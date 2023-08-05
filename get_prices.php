<?php
include 'components/connect.php';

if (isset($_GET['productId'])) {
  $productId = $_GET['productId'];

  // Fetch the prices from the database based on the product ID
  $stmt = $conn->prepare("SELECT price, priceR FROM products WHERE id = ?");
  $stmt->execute([$productId]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $response = array(
    'regularPrice' => $row['price'],
    'largePrice' => $row['priceR']
  );

  echo json_encode($response);
}
?>
