document.addEventListener("DOMContentLoaded", () => {
    const searchField = document.getElementById("search_email");
    const resultContainer = document.getElementById("results");

    searchField.addEventListener("input", () => {
        let email = searchField.value.trim();
        if (email.length >= 1) {
            fetch("index.php?page=SearchChat", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "email=" + encodeURIComponent(email)
            })
            .then(res => res.json())
            .then(data => {
                resultContainer.innerHTML = "";
                if (data.success && data.data.length) {
                    data.data.forEach(user => {
                        let li = document.createElement("li");
                        li.classList.add("contact-email-item");
                        li.textContent = user.email;
                        li.addEventListener("click", () => {
                            window.location.href = "index.php?page=chat&contact=" + encodeURIComponent(user.email);
                        });
                        resultContainer.appendChild(li);
                    });
                } else {
                    let li = document.createElement("li");
                    li.textContent = "Aucun utilisateur trouvé";
                    resultContainer.appendChild(li);
                }
            })
            .catch(err => console.error(err));
        } else {
            resultContainer.innerHTML = "";
        }
    });
});
