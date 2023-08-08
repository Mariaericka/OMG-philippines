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
function updateSize(id) {
  const sizeDropdown = document.getElementById(`size-dropdown${id}`);
  const sizeInput = document.getElementById(`size${id}`);
  sizeInput.value = sizeDropdown.value;
}
function updatePrice(id) {
  const sizeDropdown = document.getElementById(`size-dropdown${id}`);
  const priceRegular = parseFloat(sizeDropdown.dataset.priceRegular);
  const priceLarge = parseFloat(sizeDropdown.dataset.priceLarge);
  const selectedSize = sizeDropdown.value;

  const priceElement = document.getElementById(`price${id}`);

  if (selectedSize === 'regular') {
    priceElement.textContent = `₱${priceRegular.toFixed(2)}`;
  } else if (selectedSize === 'large') {
    priceElement.textContent = `₱${priceLarge.toFixed(2)}`;
  }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target.classList.contains("backdrop")) {
      event.target.style.display = "none";
  }
};
// Show the locationModal when the page loads
window.onload = function() {
  openModal('locationModal');
};
