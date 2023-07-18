// Get the modal
var modal = document.getElementById("costumizeOrderModal");

function openModal(productId) {
  var sizeDropdown = document.getElementById("size-dropdown" + productId);
  var regularPriceLabel = document.getElementById("modal-regular-price" + productId);
  var largePriceLabel = document.getElementById("modal-large-price" + productId);

  // Get the prices using AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      regularPriceLabel.textContent = response.regularPrice;
      largePriceLabel.textContent = response.largePrice;
    }
  };
  xhr.open("GET", "get_prices.php?productId=" + productId, true);
  xhr.send();

  modal.style.display = "block";
}

function closeModal() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.addEventListener("click", function(event) {
  if (event.target === modal) {
    closeModal();
  }
});

function addToCart(productId) {
  // Get the selected size and quantity from the modal
  var sizeDropdown = document.getElementById("size-dropdown" + productId);
  var selectedSize = sizeDropdown.value;
  var quantityInput = document.querySelector("#costumizeOrderModal .modal-body .qty");
  var quantity = quantityInput.value;

  // Perform any additional validation or processing if required

  // Create an object or form data to send the selected product details to the server
  var data = {
    productId: productId,
    size: selectedSize,
    quantity: quantity
  };

  // Make an AJAX request to the server to add the product to the cart
  // You can use libraries like Axios, jQuery, or the native fetch API for the AJAX request

  // Example using Axios library:
  axios.post("add_to_cart.php", data)
    .then(function(response) {
      // Handle the response from the server, such as displaying a success message or updating the cart view
      console.log(response.data);
    })
    .catch(function(error) {
      // Handle any errors that occur during the AJAX request
      console.error(error);
    });
}
