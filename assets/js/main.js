
// JS to show and hide the modal class

const showLoginFormButton = document.getElementById("showLoginFormButton");
const loginModal = document.getElementById("loginModal");
const closeModal = document.getElementById("closeModal");

showLoginFormButton.addEventListener("click", function() {
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
