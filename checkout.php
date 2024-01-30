

<?php
include 'components/connect.php';
// Add this at the beginning of your checkout.php file
 // Check if qty is received


session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';




function generate_unique_order_id($user_id)
{
    $timestamp = time();
    $order_id = $user_id . '-' . $timestamp;
    return $order_id;
}




if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_id = generate_unique_order_id($user_id);
    $total_amount = 0; // Assume $total_amount is obtained from your cart logic


    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $lname = $_POST['lname'];
        $lname = filter_var($lname, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $method = $_POST['method'];
        $method = filter_var($method, FILTER_SANITIZE_STRING);
        $address = $_POST['address'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);
        $total_products = $_POST['total_products'];
        $total_price = $_POST['total_price'];
   
        $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $check_cart->execute([$user_id]);


        $total_amount = $total_price;  // gawa ko sakali


        $order_placed = false;
         // For the GCash method
         if ($method == 'gcash') {
   
        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, 'https://api.xendit.co/ewallets/charges');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
       
        $data = [
            'external_id' => $order_id,
            'amount' => intval($total_amount),
            'ewallet_type' => 'GCASH',
            'reference_id' => $order_id,
            'checkout_method' => 'ONE_TIME_PAYMENT',
            'currency' => 'PHP',
            'channel_code' => 'PH_GCASH',
            'channel_properties' => [    
               
                'success_redirect_url' => 'http://localhost/OMG-philippines/success.php',
                'failure_redirect_url' => 'http://localhost/OMG-philippines'
            ],
           
        ];
       
       
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode('xnd_production_YwHU4qabeyVSp8AWxBCVzBjJFiTsG4PxzVUm40c7t9kEopFzGeW1iIO3GWBbHBD' . ':')
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
       
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Get the HTTP status code
       
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else if ($httpcode >= 400) {
            echo "HTTP Error: " . $httpcode . " - Response: " . $result;  // Handle HTTP errors with detailed response
        } else {
            $response_data = json_decode($result, true);
            if (isset($response_data['status']) && $response_data['status'] === 'PENDING') {
                header('Location: ' . $response_data['actions']['desktop_web_checkout_url']);
                exit();
            } else {
                echo 'Payment could not be initialized. Please try again.';
            }
        }
        $response = curl_exec($ch);
        $response_data = json_decode($response, true);


        if ($response_data['status'] == 'success') {
            $order_placed = true;
        }
        curl_close($ch);


         // For the in-store pickup method
        } elseif ($method == 'instore') {
            $order_placed = true;
        }
   


        if ($check_cart->rowCount() > 0) {
            if ($address == '') {
                $message[] = 'please add your address!';
            } else {
                $cart_items = array();
                while ($fetch_cart = $check_cart->fetch(PDO::FETCH_ASSOC)) {
                    $size = $fetch_cart['size'];
                    $select_product_price = $conn->prepare("SELECT price, priceR FROM products WHERE id = ?");
                    $select_product_price->execute([$fetch_cart['pid']]);
                    $product_price = $select_product_price->fetch(PDO::FETCH_ASSOC);
                    $price = $size === 'large' ? $product_price['priceR'] : $product_price['price'];
                    $sub_total = $price * $fetch_cart['quantity'];
   
                    // Consider add-ons in the total price calculation
                    $select_addons = $conn->prepare("SELECT addon_name, addon_price FROM cart_addons WHERE cart_id = ?");
                    $select_addons->execute([$fetch_cart['id']]);
                    $addons = $select_addons->fetchAll(PDO::FETCH_ASSOC);
   
                    $sub_total += array_sum(array_column($addons, 'addon_price'));
   
                    $total_price += $sub_total;
                    $cart_items[] = array(
                        'name' => $fetch_cart['name'],
                        'price' => $price,
                        'quantity' => $fetch_cart['quantity'],
                        'addons' => $addons
                    );
                }
                $total_products = implode(' - ', array_map(function ($item) {
                    return $item['name'] . ' (' . $item['price'] . ' x ' . $item['quantity'] . ')';
                }, $cart_items));
   
                $order_id = generate_unique_order_id($user_id);
   
   
                    $order_placed = true;
               
   
                if ($order_placed) {
                     // Convert cart items with addons to JSON format
        $cart_addons_json = json_encode($cart_items, JSON_UNESCAPED_UNICODE);
        $insert_order = $conn->prepare("INSERT INTO `orders` (order_id, user_id, name, number, email, method, address, total_products, total_price, cart_addons) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_order->execute([$order_id, $user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $cart_addons_json]);
                    // Delete cart addons first
                    $delete_cart_addons = $conn->prepare("DELETE FROM `cart_addons` WHERE cart_id IN (SELECT id FROM `cart` WHERE user_id = ?)");
                    $delete_cart_addons->execute([$user_id]);
   
                    // Delete cart items
                    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                    $delete_cart->execute([$user_id]);
   
                    $message[] = 'Order placed successfully! and an email confirmation has been sent to your email address.';
                    $email_subject = "Receipt for Your Order at OMG Philippines";
                   


                   
               
                    $email_body = "<p>Thank you for placing your order with us. Your order details are as follows: </p>";
               
                    $email_body .= "<h2>Order Confirmation</h2>";
                    $email_body .= "<p><strong>Order ID:</strong> " . $order_id . "</p>";
                    $email_body .= "<p><strong>Name:</strong> " . $name . "</p>";
                    foreach ($cart_items as $item) {
                      $email_body .= "<p>Product: " . $item['name'] . " - ₱" . $item['price'] . " x " . $item['quantity'] . "</p>";
                     
                      if (isset($item['addons']) && is_array($item['addons'])) {
                          foreach ($item['addons'] as $addon) {
                              $email_body .= "<p>Addon: " . $addon['addon_name'] . " - ₱" . $addon['addon_price'] . "</p>";
                          }
                      }
                  }
                  $email_body .= "<p><strong>Payment Method:</strong> " . $method . "</p>";
               
                    $email_body .= "<p><strong>Total Products:</strong> " . $total_products . "</p>";
                    $email_body .= "<p><strong>Total Price:</strong> ₱" . $total_price . "</p>";
               
                    $email_body .= "<p>Thank you for ordering! </p>";
                 // Send the email using PHPMailer
                 $mail = new PHPMailer(true);
                 
                 $mail->isSMTP();
                 $mail->Host = 'smtp.gmail.com';
                 $mail->SMTPAuth = true;
                 $mail->Username = 'omgphilippines123@gmail.com';
                 $mail->Password = 'qcdjmrfckncojvsy';
                 $mail->SMTPSecure = 'ssl';
                 $mail->Port = 465;
               
                 $mail->setFrom('omgphilippines123@gmail.com', 'OMG Philippines');
                 $mail->addAddress($email);
                 $mail->isHTML(true);
                 $mail->Subject = $email_subject;
                 $mail->Body = $email_body;
               
                 try {
                     $mail->send();
                 } catch (Exception $e) {
                     $message[] = "Receipt email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                   }


                }
            }
        } else {
            $message[] = 'Your cart is empty';
        }
    }


} else {
    $user_id = '';
    header('location:index.php');
}








?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="icon" href="images/omg-logo.png">


   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<!-- Include jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style2.css">
</head>
<body>


<!-- header section starts -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->


<!--<div class="check-out-sticky">
    <h3 class="order-summary">Order Summary</h3>
</div>-->




    <section class="checkout">
        <form action="" method="post" enctype="multipart/form-data" class="checkout-grid">
            <div class="cart-items">
                <h3>Cart Items</h3>
                <?php
                    $total_price = 0;


                    $select_cart = $conn->prepare("SELECT c.*, p.priceR FROM `cart` c INNER JOIN `products` p ON c.pid = p.id WHERE c.user_id = ?");
                    $select_cart->execute([$user_id]);


                    if ($select_cart->rowCount() > 0) {
                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        $size = $fetch_cart['size'];
                        $select_product_price = $conn->prepare("SELECT price, priceR FROM products WHERE id = ?");
                        $select_product_price->execute([$fetch_cart['pid']]);
                        $product_price = $select_product_price->fetch(PDO::FETCH_ASSOC);
                        $price = $size === 'large' ? $product_price['priceR'] : $product_price['price'];
                        $sub_total = $price * $fetch_cart['quantity'];


                        // Consider add-ons in the total price calculation
                        $select_addons = $conn->prepare("SELECT addon_name, addon_price FROM cart_addons WHERE cart_id = ?");
                        $select_addons->execute([$fetch_cart['id']]);
                        $addons = $select_addons->fetchAll(PDO::FETCH_ASSOC);


                        $sub_total += array_sum(array_column($addons, 'addon_price'));
                        $total_price += $sub_total;
                ?>
                        <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">₱<?= $price; ?> x <?= $fetch_cart['quantity']; ?></span></p>
                        <?php if (!empty($addons)): ?>
                        <div class="addons-list">
                            <ul style="display: flex; flex-direction: column;">
                                <?php foreach ($addons as $addon): ?>
                                <li class="addons"><?= $addon['addon_name']; ?> (+₱<?= $addon['addon_price']; ?>)</li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                <?php
                    }
                    } else {
                    echo '<p class="empty">Your cart is empty!</p>';
                    }
                ?>
                <p class="grand-total"><span class="name" style="color: #FF8400;">GRAND TOTAL:</span><span class="price">₱<?= $total_price; ?></span></p>


                <a href="cart.php" class="back-to-cart-btn">Back To Cart</a>


                <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                <input type="hidden" name="total_price" value="<?= $total_price; ?>">
                <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
                <input type="hidden" name="lname" value="<?= $fetch_profile['lname'] ?>">

                <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
                <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
                <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">
            </div>


           




       
            <div class="user-info">
                <h3>Your Info</h3>
                <p><i class="fas fa-user"></i>Name: <span><?= $fetch_profile['name'] ?></span> <span><?= $fetch_profile['lname'] ?></span></p>
                <p><i class="fas fa-phone"></i>Contact number: <span><?= $fetch_profile['number'] ?></span></p>
                <p><i class="fas fa-envelope"></i>Email: <span><?= $fetch_profile['email'] ?></span></p>
                <button id="edit-info-btn" class="btn">Edit Info</button>
<!-- Edit user info form -->
<div id="edit-info-form" style="display: none;">
    <h3>Edit Your Info</h3>
    <form id="edit-info-form">
        <input type="text" id="edit-name" placeholder="Enter your name" >
        <input type="text" id="edit-lname" placeholder="Enter your last name"  >



        <input type="tel" id="edit-number" name="number"placeholder="Enter your number"  pattern="\d*" inputmode="numeric">
        <button id="update-info-btn" class="btn">Update Info</button>
    </form>
</div>



                <h3>Delivery Address</h3>
                <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'Please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
                <button id="edit-address-btn" class="btn">Edit Address</button>
<!-- Edit address form -->
<div id="edit-address-form" style="display: none;">
    <h3>Edit Delivery Address</h3>
    <form id="edit-address-form">
        <input type="text" id="edit-number" placeholder="Enter your number">
        <input type="text" id="edit-street" placeholder="Enter street name">
        <input type="text" id="edit-brgy" placeholder="Enter barangay">
        <input type="text" id="edit-province" placeholder="Enter province">
        <input type="text" id="edit-city" placeholder="Enter city">
        <input type="text" id="edit-region" placeholder="Enter region">
        <input type="tel" id="edit-postal" placeholder="Enter postal code">
        <input type="text" id="edit-country" placeholder="Enter country">
        <button id="update-address-btn" class="btn">Update Address</button>
    </form>
</div>



                <div class="delivery-info">
                    <h3>Delivery Information</h3>
                    <p><strong>Note:</strong> Delivery is available within the Laguna area only. If you are outside the delivery range, please choose "In-store Pick-up" as your payment method and visit our stores or other franchise branches.
                </p><p><strong> The delivery fee is not included in online payment and will be collected upon delivery.</strong></p>
                </div>
      
                <div class="Payment-method">
                    <h3>Select Payment method</h4>
                    <select name="method" class="box" id="payment-method" required>
                        <option value="" disabled selected>Select Payment Method</option>
                        <option value="gcash">GCash</option>
                        <option value="instore">In-store Pickup</option>
                    </select>
                </div>
                <input type="submit" value="Place Order" class="btn <?php if($fetch_profile['address'] == '' || (isset($_POST['method']) && $_POST['method'] === 'gcash')) { echo 'disabled'; } ?>" style="width: 100%; background: #FF8400; color: #F6F1E9 ;" name="submit">

            </div>



   
        </form>
    </section>
</div>




<!-- footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->


<!-- custom js file link -->
<script src="js/modal.js"></script>
<script src="js/script.js"></script>

<script>
  
    $(document).ready(function () {
        // Edit user info
        $("#edit-info-btn").click(function () {
            $("#user-info").hide();
            $("#edit-info-form").show();
        });

        // Update user info using AJAX
        $("#update-info-btn").click(function (e) {
            e.preventDefault();

            var name = $("#edit-name").val();
            var lname = $("#edit-lname").val();
            var number = $("#edit-number").val();

            $.ajax({
                type: "POST",
                url: "update_profile.php",
                data: {
                    submit: true,
                    name: name,
                    lname: lname,
                    number: number
                },
                success: function (response) {
                    // Handle success, you may display a success message
                    alert("User info updated successfully!");
                    location.reload(); // Reload the page to reflect changes
                },
                error: function (error) {
                    // Handle error, you may display an error message
                    alert("Error updating user info: " + error.responseText);
                }
            });
        });

        // Edit address
        $("#edit-address-btn").click(function () {
            $("#user-address").hide();
            $("#edit-address-form").show();
        });

        // Update address using AJAX
        $("#update-address-btn").click(function (e) {
            e.preventDefault();

            var number = $("#edit-number").val();
            var street = $("#edit-street").val();
            var brgy = $("#edit-brgy").val();
            var province = $("#edit-province").val();
            var city = $("#edit-city").val();
            var region = $("#edit-region").val();
            var postal = $("#edit-postal").val();
            var country = $("#edit-country").val();

            $.ajax({
                type: "POST",
                url: "update_address.php",
                data: {
                    submit: true,
                    number: number,
                    street: street,
                    brgy: brgy,
                    province: province,
                    city: city,
                    region: region,
                    postal: postal,
                    country: country
                },
                success: function (response) {
                    // Handle success, you may display a success message
                    alert("Address updated successfully!");
                    location.reload(); // Reload the page to reflect changes
                },
                error: function (error) {
                    // Handle error, you may display an error message
                    alert("Error updating address: " + error.responseText);
                }
            });
        });
    });
 
</script>
<script src="js/cart.js"></script>


</body>
</html>