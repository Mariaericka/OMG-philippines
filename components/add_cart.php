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
        $add_ons = $_POST['add_ons']; // Corrected key name for add-ons
        
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

                        if (isset($add_ons[$i]) && is_array($add_ons[$i])) {
                            foreach ($add_ons[$i] as $addon_name => $addon_price) {
                                $addon_name = filter_var($addon_name, FILTER_SANITIZE_STRING);
                                $addon_price = filter_var($addon_price, FILTER_SANITIZE_STRING);
                                
                                // Fetch the addon_id based on the addon_name
                                $select_addon_id = $conn->prepare("SELECT id FROM `addons` WHERE name = ?");
                                $select_addon_id->execute([$addon_name]);
                                $addon_row = $select_addon_id->fetch(PDO::FETCH_ASSOC);
                                $addon_id = $addon_row['id'];
                                
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
