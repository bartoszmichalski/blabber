<?php

include_once 'library.php';

session_start();

if (isInSession()) {
$userId=$_SESSION['user_id'];

function showReceivedMail() {
    global $userId;
    global $mysql;
    
    $allReceivedMail = Mail::loadMailbyReceiverUserID($mysql, $userId);
  

    echo '<h3>Odebrane:</h3><table border="1">';

    echo "<th>ID</th><th>Nadawca</th><th>Odbiorca</th><th>Wiadomość</th><th>Utworzona</th><th>Przeczytana</th> ";
    if (!is_null($allReceivedMail)) {
        foreach ($allReceivedMail as  $receivedMail) {
                $senderUserName=  User::loadUserbyID($mysql, $receivedMail->getSenderUserId());
                $receiverUserName=  User::loadUserbyID($mysql, $receivedMail->getReceiverUserId());
                //var_dump($receiverUserName);
                echo sprintf(
                "<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td></tr>",
                $receivedMail->getId(),
                $senderUserName->getUserName(),
                $receiverUserName->getUserName(),
                sprintf('<a href="mail_details.php?mailId=%d">%s</a>', $receivedMail->getId(), substr($receivedMail->getText(),0,30)),
                date("Y-m-d H:i:s",$receivedMail->getCreationDate()),
                $receivedMail->getWasRead()
                );
            //var_dump($item['id']);
           // }
        }
        
    }
    echo '</table>';
    
}
function showSendMail() {
    global $userId;
    global $mysql;
    
   // echo ($userId);
    
    $allSendMail = Mail::loadMailbySenderUserID($mysql, $userId);
    //var_dump($allSendMail);

    echo '<h3>Wysłane:</h3><table border="1">';

    //

    echo "<th>ID</th><th>Nadawca</th><th>Odbiorca</th><th>Wiadomość</th><th>Utworzono</th><th>Przeczytana</th> ";
    if (!is_null($allSendMail)) {
        foreach ($allSendMail as  $SendMail) {
                $senderUserName=  User::loadUserbyID($mysql, $SendMail->getSenderUserId());
                $receiverUserName=  User::loadUserbyID($mysql, $SendMail->getReceiverUserId());
                
                echo sprintf(
                "<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td></tr>",
                //User::loadUserbyID($mysql, $tweets->getId()),
                $SendMail->getId(),
                $senderUserName->getUserName(),
                $receiverUserName->getUserName(),
                sprintf('<a href="mail_details.php?mailId=%d">%s</a>', $SendMail->getId(), substr($SendMail->getText(),0,30)),
                date("Y-m-d H:i:s",$SendMail->getCreationDate()),
                $SendMail->getWasRead()
                );
            //var_dump($item['id']);
           // }
        }
        
    }
    echo '</table>';
    
}

//showReceivedMail();
//showSendMail();
}
?>
<html>
    <body></body>
</html>
<?php
showReceivedMail();
showSendMail();
?>