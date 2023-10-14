
// JS to show and hide the modal class

const loginButton = document.getElementById("loginButton");
const loginModal = document.getElementById("loginModal");
const closeModal = document.getElementById("closeModal");

loginButton.addEventListener("click", function() {
    loginModal.style.display = "block";
});

closeModal.addEventListener("click", function() {
    loginModal.style.display = "none";
});

window.addEventListener("click", function(event) {
    if (event.target === loginModal) {
        loginModal.style.display = "none";
    }
});
