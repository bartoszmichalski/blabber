<?php

include_once 'library.php';

session_start();
if (isInSession()) {



    function showTweets() {
        global $mysql;
        if (isset($_SESSION['username'])) {
                echo 'Witaj '.$_SESSION['username'];
        }
        $logedUser= $_SESSION['user'];
        $userId=$_SESSION['user_id'];
        $connection = new Connection($mysql);
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (trim($_POST['new_tweet'])!=''){
                $new_tweet_text=$_POST['new_tweet'];
                $new_tweet = new Tweet($mysql);
                $userid =$userId;  //dodać ID zalogowanego operatora
                $new_tweet->setText($new_tweet_text);
                $new_tweet->setUserId($userid);
                $new_tweet->setCreationDate(time());
                $new_tweet->save($mysql);
                //var_dump($new_tweet);
            }
        }
        $allTweets = Tweet::loadAllTweets($mysql);
        echo '<html><body><table border="1">';
        echo "<th>ID</th><th>Autor</th><th>Tweet</th><th>Utworzono</th> ";
        foreach ($allTweets as  $tweets) {
            $authorOftweet=  User::loadUserbyID($mysql, $tweets->getUserid());
            echo sprintf(
                "<tr><td>%s</td><td>%s</td> <td>%s</td><td>%s</td>"
                    . "</tr>",
                $tweets->getId(),
                sprintf('<a href="main_user.php?userId=%d">%s</a>',$tweets->getUserId(), $authorOftweet->getUserName()),
                sprintf('<a href="tweets.php?tweetId=%d">%s</a>',$tweets->getId(),$tweets->getText()),
                date("Y-m-d H:i:s",$tweets->getCreationDate())
            );
        }
        echo '</table></body></html>';
    }        

}
?>
<html>
    <a  style="float:right" href="delsession.php">Wyloguj</a><br>
    <a  style="float:right" href="main_user.php">Moje wpisy</a><br>
    <a  style="float:right" href="mails.php">Moja poczta</a><br>
    <a  style="float:right" href="edit_user.php">Moje konto</a><br>
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