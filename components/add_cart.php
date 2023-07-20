<?php
if (isset($_POST['add_to_cart'])) {

    if ($user_id == '') {
        header('location:login.php');
    } else {

        $pids = $_POST['pid'];
        $names = $_POST['name'];
        $prices = $_POST['price'];
        $pricesR = $_POST['priceR'];
        $images = $_POST['image'];
        $qtys = $_POST['qty'];

        // Check if the arrays are not empty and countable
        if (!empty($pids) && is_array($pids) && count($pids) > 0) {

            // Loop through the arrays to insert each product into the cart
            for ($i = 0; $i < count($pids); $i++) {
                $pid = filter_var($pids[$i], FILTER_SANITIZE_STRING);
                $name = filter_var($names[$i], FILTER_SANITIZE_STRING);
                $price = filter_var($prices[$i], FILTER_SANITIZE_STRING);
                $priceR = filter_var($pricesR[$i], FILTER_SANITIZE_STRING);
                $image = filter_var($images[$i], FILTER_SANITIZE_STRING);
                $qty = filter_var($qtys[$i], FILTER_SANITIZE_STRING);

                $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
                $check_cart_numbers->execute([$name, $user_id]);

                if ($check_cart_numbers->rowCount() > 0) {
                    $message[] = 'Product "' . $name . '" already added to cart!';
                } else {
                    $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, priceR, quantity, image) VALUES(?,?,?,?,?,?,?)");
                    $insert_cart->execute([$user_id, $pid, $name, $price, $priceR, $qty, $image]);
                    $message[] = 'Product "' . $name . '" added to cart!';
                }
            }
        } else {
            $message[] = 'No products selected!';
        }
    }
}
?>
