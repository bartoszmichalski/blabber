<?php

include_once 'library.php';

session_start();
if (isInSession()) {
    if (isset($_GET['sendMailToUserId'])) {
        $sendMailToUserId=$_GET['sendMailToUserId'];
        $_SESSION['sendMailToUserId']=$sendMailToUserId;
    }
    $userId=$_SESSION['user_id'];
    
    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (trim($_POST['new_mail'])!=''){
            $new_mail_text=$_POST['new_mail'];
            $newMail = new Mail($mysql);
            //$userid =$userId;  //dodać ID zalogowanego operatora
            $newMail->setText($new_mail_text);
            $newMail->setSenderUserId($userId);
            $newMail->setReceiverUserId($sendMailToUserId);
            $newMail->setCreationDate(time());
            $newMail->setWasRead(0);
            $newMail->save($mysql);
            echo ('<h4>Wiadomość wysłana.</h4>');
            //var_dump($new_tweet);
        }
    }
    $senderUser=  User::loadUserbyID($mysql, $userId);
    $senderUserName=$senderUser->getUserName();
    $receiverUser=  User::loadUserbyID($mysql, $sendMailToUserId);
    $receiverUserName=$receiverUser->getUserName();
    echo sprintf('Wiadomość od %s do %s.',$senderUserName,$receiverUserName );
}
?>
<html>
    <div>
    <form class="movie_form" method="post" action="#">
        <label>Wyślij nową wiadomość:</label><br>
        <textarea name="new_mail" rows="4" cols="50" maxlength="1024" value=""></textarea>
        
        <button type="submit" name="submit" value="submit">Wyślij</button><br>
        
    </form>
    </div>
</html>