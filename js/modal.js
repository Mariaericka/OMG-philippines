// modal.js

function openModal(id) {
  var modal = document.getElementById(`costumizeOrderModal${id}`);
  modal.style.display = 'block';
}

function closeModal(id) {
  var modal = document.getElementById(`costumizeOrderModal${id}`);
  modal.style.display = 'none';
}

function submitForm(id) {
  var form = document.querySelector(`#productForm${id}`);
  form.submit();
}
// JavaScript function to update the price based on the selected size
function updatePrice(id) {
  const sizeDropdown = document.getElementById('size-dropdown' + id);
  const priceRegular = parseFloat(sizeDropdown.getAttribute('data-price-regular'));
  const priceLarge = parseFloat(sizeDropdown.getAttribute('data-price-large'));
  const selectedSize = sizeDropdown.value;

  // Update the displayed price based on the selected size
  if (selectedSize === 'regular') {
    document.getElementById('price-display' + id).innerText = 'Regular ₱' + priceRegular + '.00';
  } else {
    document.getElementById('price-display' + id).innerText = 'Large ₱' + priceLarge + '.00';
  }
}


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target.classList.contains("backdrop")) {
      event.target.style.display = "none";
  }
};
