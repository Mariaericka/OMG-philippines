function updateQuantity(cartId, action, price) {
  
    const quantityElement = document.getElementById('quantity_' + cartId);
    console.log('Quantity Element:', quantityElement);

    let quantity = parseInt(quantityElement.innerText);

    if (action === 'add') {
        quantity++;
    } else if (action === 'subtract' && quantity > 1) {
        quantity--;
    }
 // Store the updated quantity in session storage
 sessionStorage.setItem('quantity_' + cartId, quantity);
    // Log relevant variables for debugging
    console.log('Cart ID:', cartId);
    console.log('Action:', action);
    console.log('Price:', price);

    console.log('Quantity:', quantity);
    

    // Update the quantity on the page
    quantityElement.innerText = quantity;

    // Calculate and update subtotal
    const subTotalElement = document.getElementById('subTotal_' + cartId);
    const subTotal = quantity * price;
    subTotalElement.innerText = '₱' + subTotal;

    // Update the grand total and Cart Total at the bottom
    updateGrandTotal(cartId,quantity);

    // Store the updated quantity in a hidden input field
    const quantityInput = document.getElementById('input_quantity_' + cartId);
    console.log('Hidden Input Value Before Update:', quantityInput.value);
    quantityInput.value = quantity;
    console.log('Hidden Input Value After Update:', quantityInput.value);
}


   function updateGrandTotal(cartId,quantity) {
    let grandTotal = 0;

    // Loop through all subtotals and sum them up
    const subTotalElements = document.querySelectorAll('[id^="subTotal_"]');
    subTotalElements.forEach(element => {
        grandTotal += parseFloat(element.innerText.replace('₱', ''));
    });

    // Update the grand total at the top and bottom
    const cartTotalElement = document.getElementById('cartTotal');
    if (cartTotalElement) {
        cartTotalElement.innerText = '₱' + grandTotal;
    }

    const cartTotalBottomElement = document.getElementById('cartTotalBottom');
    if (cartTotalBottomElement) {
        cartTotalBottomElement.innerText = '₱' + grandTotal;
    }



      // AJAX request to update quantity in the database
      $.ajax({
        type: 'POST',
        url: 'update-quantity.php',
        data: {
            cartId: cartId,
            quantity: quantity
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log('Quantity updated successfully');
            } else {
                console.error('Error updating quantity:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.log('Server Response:', xhr.responseText);
        }
    });
    

}