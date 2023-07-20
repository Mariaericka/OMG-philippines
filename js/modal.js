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


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target.classList.contains("backdrop")) {
      event.target.style.display = "none";
  }
};
