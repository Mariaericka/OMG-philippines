  // Get the modal
var modal = document.getElementById("costumizeOrderModal");

function openModal() {
    var modal = document.getElementById("costumizeOrderModal");
    var sizeDropdown = document.getElementById("size-dropdown");
  
    modal.style.display = "block";


  }
  
  

  function closeModal() {
    var modal = document.getElementById("costumizeOrderModal");
    modal.style.display = "none";
  }
  

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target.classList.contains("backdrop")) {
        event.target.style.display = "none";
    }
};
