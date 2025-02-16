
document.getElementById("registerForm").addEventListener("submit", function (e) {
    e.preventDefault();
    
    const firstname = document.getElementById("firstname").value;
    const lastname = document.getElementById("lastname").value;
    const birthdate = document.querySelector("input[type='date']").value;
    const city = document.getElementById("city").value;
    const password = document.getElementById("pswd").value;
    const passwordConfirm = document.getElementById("pswdc").value;
    const email = document.querySelector("input[type='email']").value;
    const gender = document.querySelector("select").value;
    const hobbies = document.getElementById("hobbies").value;
    
    const currentYear = new Date().getFullYear();
    const birthYear = new Date(birthdate).getFullYear();

    
    const age = currentYear - birthYear;

    if (age < 18) {
        displayError("Vous devez avoir au moins 18 ans pour vous inscrire.");
    } else if (password !== passwordConfirm) {
        displayError("Les mots de passe ne correspondent pas.");
    } else if (password.length < 10) {
        displayError("Mot de passe trop court !!!");
    } else {
        displaySuccess("Inscrit !");
        
        fetch("index.php?page=Register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                firstname: firstname,
                lastname: lastname,
                birthdate: birthdate,
                city: city,
                email: email,
                password: password,
                gender: gender,
                hobbies: hobbies
            })
        })
        .then(response => response.text())  
        .then(response => {
            console.log(response);
            window.location.href = "index.php?page=account";
        });
    }
});

function displayError(message) {
    const div = document.querySelector(".container");
    div.querySelectorAll("p").forEach(p => p.remove());

    const errorMessage = document.createElement("p");
    errorMessage.textContent = message;
    errorMessage.style.color = "red";
    div.appendChild(errorMessage);
}

function displaySuccess(message) {
    const div = document.querySelector(".container");
    div.querySelectorAll("p").forEach(p => p.remove());

    const successMessage = document.createElement("p");
    successMessage.textContent = message;
    successMessage.style.color = "green";
    div.appendChild(successMessage);
}
