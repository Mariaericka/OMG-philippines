<?php
include 'components/connect.php';

$id = $_POST['id'];

$select_product = $conn->prepare("SELECT * FROM `products` WHERE category_id = '$id'");
$select_product->execute();

while ($row = $select_product->fetch(PDO::FETCH_ASSOC)) {
    $product_name = $row['name'];
    echo $product_name;
}
?>