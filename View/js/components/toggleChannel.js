
 function toggleChannel(){
    const msgChannel = document.querySelector(".menu__list");
    const dltMsgChannel = document.getElementById("deleted-msg");

    const boxDltMsg = document.querySelector(".show-deleted-msg");

    const msgReceived = document.querySelectorAll(".message-received");
    
    const formSend = document.getElementById("send-message");
    
    
    const contactEmail = encodeURIComponent(document.getElementById("email_recipient").textContent.trim());
    
    dltMsgChannel.addEventListener("click",()=>{     
        const msgSent = document.querySelectorAll(".message-sent");
        
        msgSent.forEach(msgS=> msgS.style.display="none");
        console.log(msgSent)
        msgReceived.forEach(msgR=> msgR.style.display="none");
        formSend.style.display = "none";
        
        fetch("index.php?page=chat&contact="+contactEmail,{
            method: "POST",
            headers:{"Content-Type": "application/json"},
            body: JSON.stringify({
                toggle:"toggle"
            })
        })
        .then(response=>response.text())
        .then(data=>{
            console.log(data);
            
            boxDltMsg.style.display = "";
            boxDltMsg.innerHTML = data;
            
            // toggle
            
            msgChannel.addEventListener("click",()=>{
                
                boxDltMsg.style.display = "none";
                msgSent.forEach(msg=> msg.style.display="");
                msgReceived.forEach(msgR=> msgR.style.display="");
                formSend.style.display = "";
            })
        })
        .catch(error=> console.error("Erreur Ajax :",error))
        
    })

}
toggleChannel()