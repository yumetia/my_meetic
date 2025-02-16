
function chat(){

    const input = document.getElementById("message");
    const form = document.getElementById("send-message");
    const recipientEmail = document.getElementById("email_recipient").textContent.trim();
    const chatBox = document.getElementById("chat-box");

    const senderEmail = document.getElementById("sender-email").textContent.trim();


    form.addEventListener("submit",(ev)=>{
        ev.preventDefault();
        if (input.value.trim()!==""){

            const message = input.value.trim();
            const options = { weekday: 'short', year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const formattedDate = new Date().toLocaleString('en-US', options).replace(',', '');
            
            // ajax lets go

            fetch("index.php?page=Message",{
                method: "POST",
                headers:{"Content-Type": "application/json"},
                body: JSON.stringify({
                    message:message,
                    senderEmail:senderEmail,
                    recipientEmail:recipientEmail,
                    formattedDate:formattedDate
                })
            })
            .then(response=>response.text())
            .catch(error => console.error("Erreur AJAX :", error));
            
            // just to make it easier printing the date...
            
            fetch("index.php?page=Message",{
                method:"POST",
                headers:{"Content-Type": "application/json"},
                body: JSON.stringify({
                    refresh:"refresh"
                })
            })
            .then(response=>response.text())
            .then(data=>{
                data = data.trim();

                console.log(data);
                // get id message for conversation 
                //  to add it dynamically on the HTML ID.
                const boxMessage = document.createElement("div");
                
                boxMessage.classList.add("message-sent")
                boxMessage.innerHTML = `<div class='header-msg'><p>${formattedDate}</p>
                <button class='delete-btn' id='${data}'>Delete</button></div>
                ${"You "}(${senderEmail}):<br>${message}
                </div>`;
                
                chatBox.appendChild(boxMessage);

                // calling also to delete in front and back end 
                deleteMsg();
            })
            
            .catch(error => console.error("Erreur Ajax: ",error))
            
            
        }
        
        // reset input after submitting msg
        input.value= "";
        
    })
}

chat()
deleteMsg();

function deleteMsg(){
    const dltButtons = document.querySelectorAll(".delete-btn");
    
    dltButtons.forEach(dltButton=>{
        const messageId = dltButton.getAttribute("id");
        
        dltButton.addEventListener("click",()=>{
            const boxMsg = dltButton.closest(".message-sent");

            fetch("index.php?page=Message",{
                method:"POST",
                headers:{"Content-Type":"application/json"},
                body: JSON.stringify({
                    messageId:messageId
                })
            })
            .then(response=>response.text())
            .then(()=>{
                boxMsg.remove();
         
            })
            .catch(error=> console.error("Erreur Ajax :",error))
            console.log("deleted")

        })
    })
    
}
