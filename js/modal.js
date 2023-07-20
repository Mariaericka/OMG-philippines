function openModal(productId) {
  var modal = document.getElementById("costumizeOrderModal" + productId);
  modal.style.display = "block";
}

function closeModal(productId) {
  var modal = document.getElementById("costumizeOrderModal" + productId);
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target.classList.contains("backdrop")) {
      event.target.style.display = "none";
  }
};
