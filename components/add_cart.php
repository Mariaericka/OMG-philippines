<?php
if (isset($_POST['add_to_cart'])) {
    if ($user_id == '') {
        header('location:login.php');
    } else {
        $pids = $_POST['pid'];
        $names = $_POST['name'];
        $images = $_POST['image'];
        $qtys = $_POST['qty'];
        $sizes = $_POST['size'];
        $price = $_POST['price'];
        $add_ons = $_POST['add_ons']; // Nested array structure

        if (!empty($pids) && is_array($pids) && count($pids) > 0) {
            for ($i = 0; $i < count($pids); $i++) {
                $pid = filter_var($pids[$i], FILTER_SANITIZE_STRING);
                $name = filter_var($names[$i], FILTER_SANITIZE_STRING);
                $image = filter_var($images[$i], FILTER_SANITIZE_STRING);
                $qty = filter_var($qtys[$i], FILTER_SANITIZE_STRING);
                $selected_size = filter_var($sizes[$i], FILTER_SANITIZE_STRING);
                $selected_price = filter_var($price[$i], FILTER_SANITIZE_STRING);

                $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND pid = ?");
                $check_cart->execute([$user_id, $pid]);

                if ($check_cart->rowCount() > 0) {
                    $message[] = 'Product "' . $name . '" already added to cart!';
                } else {
                    $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image, size) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $insert_cart->execute([$user_id, $pid, $name, $selected_price, $qty, $image, $selected_size]);

                    if ($insert_cart->rowCount() > 0) {
                        $cart_id = $conn->lastInsertId();

                    // Handle add-ons
    foreach ($add_ons[$pid] as $addon_id => $addon_price) {
        // Fetch the addon_name based on the addon_id
        $select_addon = $conn->prepare("SELECT name FROM `addons` WHERE id = ?");
        $select_addon->execute([$addon_id]);
        $addon_row = $select_addon->fetch(PDO::FETCH_ASSOC);
        $addon_name = $addon_row['name'];

        // Check if the add-on is already in the cart
        $check_addon = $conn->prepare("SELECT * FROM `cart_addons` WHERE cart_id = ? AND addon_id = ?");
        $check_addon->execute([$cart_id, $addon_id]);

        if ($check_addon->rowCount() === 0) {
            // Insert the cart add-on
            $insert_cart_addons = $conn->prepare("INSERT INTO `cart_addons` (cart_id, product_id, addon_id, addon_name, addon_price) VALUES (?, ?, ?, ?, ?)");
            $insert_cart_addons->execute([$cart_id, $pid, $addon_id, $addon_name, $addon_price]);
        }
    }

                        $message[] = 'Product "' . $name . '" added to cart!';
                    } else {
                        $message[] = 'Failed to add product "' . $name . '" to cart!';
                    }
                }
            }
        } else {
            $message[] = 'No products selected!';
        }
    }
}
?>
