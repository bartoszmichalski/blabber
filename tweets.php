<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'library.php';

session_start();
if (isset($_SESSION['tweetId'])) {
 $tweetId=$_SESSION['tweetId'];   
};

if (isset($_GET['tweetId'])) {
    $tweetId=$_GET['tweetId'];
            
}

function showTweet()
{
    
    global $mysql;
    global $tweetId;
    
    $userId=$_SESSION['user_id'];
    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (trim($_POST['new_comment'])!=''){
            $new_comment_text=$_POST['new_comment'];
            $new_comment = new Comment($mysql);
            $userid =$userId;  
            $new_comment->setText($new_comment_text);
            $new_comment->setUserId($userid);
            $new_comment->setTweetId($tweetId);
            $new_comment->setCreationDate(time());
            $new_comment->save($mysql);
            //var_dump($new_tweet);
        }
    }
    
    $tweet = Tweet::loadTweetbyID($mysql, $tweetId);
    
    echo '<table border="1">';
    echo "<th>ID</th><th>Autor</th><th>Tweet</th><th>Utworzono</th> ";
    $authorOftweet=  User::loadUserbyID($mysql, $tweet->getUserid());
    echo sprintf(
        "<tr><td>%d</td><td>%s</td> <td>%s</td><td>%s</td>"
            . "</tr>",
        $tweet->getId(),
        $authorOftweet->getUserName(),
        $tweet->getText(),
        date("Y-m-d H:i:s",$tweet->getCreationDate())
    );
    echo '</table>';
    
    $comments = Comment::loadCommentbyTweetID($mysql, $tweetId);
    if (!is_null($comments)) {
        //var_dump($tweet);
        echo '<table border="1">';
        echo "<th>ID</th><th>Autor komantarza</th><th>Tweet_id</th><th>Komentarz</th><th>Utworzono</th> ";

        foreach ($comments as  $comment) {
                $authorOfcomment=  User::loadUserbyID($mysql, $comment->getUserId());
                echo sprintf(
                "<tr><td>%d</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td>"
                    . "</tr>",
                //User::loadUserbyID($mysql, $tweets->getId()),
                $comment->getId(),
                $authorOfcomment->getUserName(),
                $comment->getTweetId(),
                $comment->getText(),
                date("Y-m-d H:i:s",$comment->getCreationDate())
                );
            //var_dump($item['id']);
        }
        echo '</table>';    
        
    }
}
    
$_SESSION['tweetId']=$tweetId;
showTweet();
?>
<html>
<div>
    <form class="movie_form" method="post" action="#">
        <label>Dodaj nowy komentarz:</label><br>
        <input name="new_comment" type="text" maxlength="60" value="" size="60"/>
        <button type="submit" name="submit" value="submit">Dodaj</button><br>
        
    </form>
    </html>
</div>
