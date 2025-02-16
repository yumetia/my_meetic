function displayInput() {
    const editButtons = document.querySelectorAll(".edit-btn");
    let cpt = 0;

    editButtons.forEach(editButton => {
        editButton.addEventListener("click", () => {

            if (cpt < 1) {

                const fieldName = editButton.getAttribute("data-field");
                const span = document.getElementById("user_" + fieldName);
                const previousInfo = span.textContent.trim();
                const isPasswordField = fieldName.toLowerCase().includes("mot_de_passe");


                span.innerHTML = `
                    <form method="post" action="index.php?page=Edit">
                        <input type="hidden" name="previousInfo" value="${previousInfo}">
                        <input class="edit-input" type="${isPasswordField ? 'password' : 'text'}" 
                               name="${fieldName}" 
                               placeholder="${isPasswordField ? '' : previousInfo}" 
                               autofocus>
                        <button type="submit">✔</button>
                        <button type="button" class="cancel-btn">X</button>
                    </form>
                `;


                span.querySelector(".edit-input").focus();
                span.querySelector(".cancel-btn").addEventListener("click", () => {

                    span.textContent = previousInfo;

                    cpt = 0;

                });

            } else {

                editButton.parentElement.querySelectorAll("p.warning").forEach(wrng => wrng.remove());
                const warning = document.createElement("p");
                warning.classList.add("warning");


                warning.innerHTML = "<strong style='color:purple;'>Remplissez le champ actuel d'abord !</strong>";
                editButton.parentElement.appendChild(warning);
            }
            
            cpt++;

        });
    });
}

displayInput();
displayEditImg();

function displayEditImg(){
    const img = document.querySelector(".pp_user");
    const originalSrc = img.src;
    
    img.addEventListener("click",()=>{
        const div = document.querySelector(".pp-user__edit");
        
        div.innerHTML = `<form action="index.php?page=Edit" method="POST" enctype="multipart/form-data">
        <div class='change-preview'>
            <input id="browse-img" type="file" name="profile_image" accept="image/*" required>
            <button id='delete-img'>Delete</button>
        </div>
        
        <button type="submit">Confirmer</button>
        <button class="cancel-btn">Cancel</button>
        </form>`;
        
        div.querySelector(".cancel-btn").addEventListener("click",()=>{
            
            div.innerHTML="";
            img.src = originalSrc;
        })
        
        
        // display preview
        
        const inputFile = document.getElementById("browse-img");
        inputFile.addEventListener("change",()=>{
            img.src = URL.createObjectURL(inputFile.files[0]);
        })


        // deleting image preview and confirm process
    
        const deleteImg = document.getElementById("delete-img");

        deleteImg.addEventListener("click",(ev)=>{
            ev.preventDefault();
            inputFile.removeAttribute("required");
            inputFile.value = "";

            const genre = document.getElementById("user_genre").textContent.trim();
            if (genre.toLowerCase() ==="homme"){
                img.src = "View/assets/man_default.png";
            }else if (genre.toLowerCase() ==="femme"){
                img.src = "View/assets/woman_default.png" ;       
            } else {
                img.src = "View/assets/neutral_avatar.png" ;
            }

        })


        
    })
    

}

