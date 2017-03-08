<?php

include_once 'library.php';

session_start();
if (isInSession()) {
    
    $userId=0;
    $tweetsOfUserId=0;
    
    function showTweets() {
        global $mysql;
        global $userId;
        global $tweetsOfUserId;
        $userId=$_SESSION['user_id'];
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (trim($_POST['new_tweet'])!=''){
                $new_tweet_text=$_POST['new_tweet'];
                $new_tweet = new Tweet($mysql);
                $userid =$userId;  
                $new_tweet->setText($new_tweet_text);
                $new_tweet->setUserId($userid);
                $new_tweet->setCreationDate(time());
                $new_tweet->save($mysql);
            }
        }
        if (isset($_GET['userId'])) {
            $tweetsOfUserId=$_GET['userId'];
        } else {
            $tweetsOfUserId=$userId;
        }

        $allUserTweets = Tweet::loadTweetbyUserID($mysql, $tweetsOfUserId);
        showNewMailOption();
        echo '<html><body><table border="1">';

        echo "<th>ID</th><th>Autor</th><th>Tweet</th><th>Utworzono</th> ";
        if (!is_null($allUserTweets)) {
            foreach ($allUserTweets as  $tweets) {
                    $authorOftweet=  User::loadUserbyID($mysql, $tweets->getUserid());
                    echo sprintf(
                        "<tr><td>%d</td><td>%s</td> <td>%s</td><td>%s</td>"
                            . "</tr>",
                        $tweets->getId(),
                        $authorOftweet->getUserName(),
                        $tweets->getText(),
                        date("Y-m-d H:i:s",$tweets->getCreationDate())
                    );
                    $commentCount= Tweet::countCommentsByTweetId($mysql, $tweets->getId());

                    if (1==1) {
                        echo sprintf('<tr><td colspan="4">Komentarzy: %d</td></tr>', $commentCount);
                    }

            }
        }
        echo '</table></body></html>';
}
    function showNewMailOption () {
        global $userId;
        global $tweetsOfUserId;
        if ($userId!=$tweetsOfUserId) {
            echo sprintf('<a  style="float:right" href="send_mail.php?sendMailToUserId=%d">Napisz wiadomość do autora</a>',$tweetsOfUserId);
        }
    }

}
?>
<html>
    <a  style="float:right" href="delsession.php">Wyloguj</a><br>
    <a  style="float:right" href="main.php">Wszystkie wpisy</a>
<div>
    <form class="movie_form" method="post" action="#">
        <label>Dodaj nowy wpis:</label><br>
        <input name="new_tweet" type="text" maxlength="140" value="" size="140"/>
        <button type="submit" name="submit" value="submit">Dodaj</button><br>
        
    </form>
</div>
</html>
<?php
showTweets();
?>