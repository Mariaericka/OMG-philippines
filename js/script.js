
navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

 function loader(){
    document.querySelector('.loader').style.display = 'none';
 }


function fadeOut(){
   setInterval(loader, 2000);
}

window.onload = fadeOut;

document.querySelectorAll('input[type="number"]').forEach(numberInput => {
   numberInput.oninput = () =>{
      if(numberInput.value.length > numberInput.maxLength) numberInput.value = numberInput.value.slice(0, numberInput.maxLength);
   };
});

//branches modal in location


document.addEventListener("DOMContentLoaded", function () {
   const openButtons = document.querySelectorAll("[data-open-modal]");
   const modals = document.querySelectorAll("[data-modal]");

   openButtons.forEach((button, index) => {
       button.addEventListener("click", () => {
           // Hide all modals first
           modals.forEach((modal) => {
               modal.classList.remove("show");
           });

           // Show the selected modal
           modals[index].classList.add("show");
       });
   });

   modals.forEach((modal) => {
       modal.addEventListener("click", (event) => {
           if (event.target === modal || event.target.getAttribute("data-close-modal") !== null) {
               modal.classList.remove("show");
           }
       });
   });
});
