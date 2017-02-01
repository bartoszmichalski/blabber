<?php

include_once 'library.php';

session_start();

if (isInSession()) {
$userId=$_SESSION['user_id'];

function showMail() {
    global $userId;
    global $mysql;
    
    if (isset($_GET['mailId'])) {
    $mailId=$_GET['mailId'];
            
}
    
    $mailDetails = Mail::loadMailbyID($mysql, $mailId);
  

    echo '<h3>Mail:</h3><table border="1">';

    echo "<th>ID</th><th>Nadawca</th><th>Odbiorca</th><th>Wiadomość</th><th>Utworzona</th><th>Przeczytana</th> ";
    if (!is_null($mailDetails)) {
       // foreach ($allReceivedMail as  $receivedMail) {
                $senderUserName=  User::loadUserbyID($mysql, $mailDetails->getSenderUserId());
                $receiverUserName=  User::loadUserbyID($mysql, $mailDetails->getReceiverUserId());
                //var_dump($receiverUserName);
                echo sprintf(
                "<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td></tr>",
                $mailDetails ->getId(),
                $senderUserName->getUserName(),
                $receiverUserName->getUserName(),
                $mailDetails ->getText(),
                date("Y-m-d H:i:s",$mailDetails->getCreationDate()),
                $mailDetails ->getWasRead()
                );
            //var_dump($item['id']);
           // }
      //  }
        
    }
    echo '</table>';
    $mailDetails->setWasRead(1);
    if ($mailDetails->getReceiverUserId()==$userId) {
        $mailDetails->save($mysql);
        
    }
}

}
?>
<html>
    <body></body>
</html>
<?php

showMail();
?>