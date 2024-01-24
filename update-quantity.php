<?php

include 'components/concart.php';

session_start();

$response = ['success' => false, 'message' => 'Unknown error'];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    $response['message'] = 'User not authenticated';
}

if (isset($_POST['cartId']) && isset($_POST['quantity'])) {
    $cartId = $_POST['cartId'];
    $quantity = $_POST['quantity'];

    try {
        // Include the connection details and create a PDO instance
        include 'components/connect.php';

        // Update the database with the new quantity
        $query = "UPDATE cart SET quantity = :quantity WHERE id = :cartId";
        $statement = $pdo->prepare($query);

        if ($statement) {
            $statement->bindParam(':quantity', $quantity);
            $statement->bindParam(':cartId', $cartId);

            if ($statement->execute()) {
                $response['success'] = true;
                $response['message'] = 'Quantity updated successfully';
            } else {
                $response['message'] = 'Error updating quantity in the database';
            }
        } else {
            $response['message'] = 'Error preparing SQL statement';
        }
    } catch (PDOException $e) {
        $response['message'] = 'Exception: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Missing parameters';
}

header('Content-Type: application/json');
echo json_encode($response);

?>
