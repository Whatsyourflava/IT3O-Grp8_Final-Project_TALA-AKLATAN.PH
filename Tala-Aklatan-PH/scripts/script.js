document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("#registerForm").onsubmit = function(event) {
        event.preventDefault();
        let formData = new FormData(this);
        
        fetch("register.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => alert(data));
    };
});
