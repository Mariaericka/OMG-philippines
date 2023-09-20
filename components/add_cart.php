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
        $add_ons = isset($_POST['add_ons']) ? $_POST['add_ons'] : array(); // Initialize as empty array if not set

        if (!empty($pids) && is_array($pids) && count($pids) > 0) {
            for ($i = 0; $i < count($pids); $i++) {
                $pid = filter_var($pids[$i], FILTER_SANITIZE_STRING);
                $name = filter_var($names[$i], FILTER_SANITIZE_STRING);
                $image = filter_var($images[$i], FILTER_SANITIZE_STRING);
                $qty = filter_var($qtys[$i], FILTER_SANITIZE_STRING);
                $selected_size = filter_var($sizes[$i], FILTER_SANITIZE_STRING);
                $selected_price = filter_var($price[$i], FILTER_SANITIZE_STRING);

                // Check if the same cart item with the same add-ons already exists
                $check_cart = $conn->prepare("SELECT c.id FROM `cart` c INNER JOIN `cart_addons` ca ON c.id = ca.cart_id WHERE c.user_id = ? AND c.pid = ?");
                $check_cart->execute([$user_id, $pid]);

                if ($check_cart->rowCount() > 0) {
                    $message[] = 'Product "' . $name . '" with these add-ons already added to cart!';
                } else {
                    // Insert the cart item
                    $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image, size) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $insert_cart->execute([$user_id, $pid, $name, $selected_price, $qty, $image, $selected_size]);

                    if ($insert_cart->rowCount() > 0) {
                        $cart_id = $conn->lastInsertId();

                        // Handle add-ons for this specific cart item
                        if (isset($add_ons[$pid]) && is_array($add_ons[$pid])) {
                            foreach ($add_ons[$pid] as $addon_id => $addon_price) {
                                // Fetch the addon_name based on the addon_id
                                $select_addon = $conn->prepare("SELECT name FROM `addons` WHERE id = ?");
                                $select_addon->execute([$addon_id]);
                                $addon_row = $select_addon->fetch(PDO::FETCH_ASSOC);
                                $addon_name = $addon_row['name'];

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
