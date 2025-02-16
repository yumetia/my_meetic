<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && !empty($_SERVER['CONTENT_TYPE']) 
    && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode(["success" => false, "message" => "Aucune donnée reçue"]);
        exit;
    }
    
    if (isset($data["refresh"])){
        $senderEmail = $_SESSION["user_email"];
        $contactEmail = $_SESSION["contact_email"];

        $conv = new GenericModel();
        $conv = $conv->getRowParticular(
            "message",
            "(sender_email",
            "'$senderEmail' or sender_email = '$contactEmail') and (recipient_email= '$senderEmail' or recipient_email = '$contactEmail')",
            "id_message,sender_email,date,content,is_deleted"
        );

        // echo for ajax request the last id submitted
        echo $conv[count($conv)-1]["id_message"];

        exit;
    }
}


class Message extends Edit{
    public function addMessage($data){
        if (isset($data["senderEmail"])){

            $senderEmail = $data["senderEmail"];
            $message = $data["message"];
            $recipientEmail = $data["recipientEmail"];
            $formattedDate = $data["formattedDate"];
    
            $this->addRow([
                "table"=>"message",
                "sender_email"=>$senderEmail,
                "content"=>$message,
                "recipient_email"=>$recipientEmail,
                "date"=>$formattedDate
            ]);
            return true;
        }
        return false;

    }
    
    public function deleteMessage($data){
        if (isset($data["messageId"])){
            $messageId = $data["messageId"];
            echo $messageId;
            $sql = "UPDATE message SET is_deleted=1 where id_message = $messageId";
            $stmt = $this->database->prepare($sql);
            $stmt->execute();
            
            return true;
        }
        return false;
        
    }
    
    public function displayDltMessage($dltMessages,$senderEmail){

        if (!empty($dltMessages)) {

                foreach ($dltMessages as $message) {

                    if ( $message["is_deleted"]==1 && $senderEmail == $message["sender_email"] ){
        
                            echo "<div class='message-deleted'>".
                            "<div class='header-msg'>"."<p>"."<strong style='color:red;'>(Deleted)</strong><br>".
        
                            $message['date']."</p>
                            </div>"."<p class='body-msg'>".
        
                            "You ($senderEmail):<br>".
                            $message['content']."</p>".
                            "</div>";

                    }
                }
            }
    }



    public function displayMessage($msgInfos,$senderEmail,$recipientEmail){
        
        if (!empty($msgInfos)) {

            foreach ($msgInfos as $message) {
                $messageId = $message["id_message"];

                if ( $message["is_deleted"]==0 ){

                    if ($senderEmail == $message["sender_email"]) {
    
                        echo "<div class='message-sent'>".
                        "<div class='header-msg'>"."<p>".
    
                        $message['date']."</p>".
                        "<button class='delete-btn' id='$messageId'>Delete</button></div>"."<p class='body-msg'>".
    
                        "You ($senderEmail):<br>".
                        $message['content']."</p>".
                        "</div>";
    
                    } else {
    
                        echo "<div class='message-received'>".
                        "<div class='header-msg'>"."<p>".
    
                        $message['date']."</p>".
                        "</div>"."<p class='body-msg'>".
    
                        "($recipientEmail):<br>".
                        $message['content']."</p>".
                        "</div>";
    
                    }

                }
            }

        }
        
    }

    

}

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    (new Message)->addMessage($data);
    (new Message)->deleteMessage($data);

}
