<?php

class Tweet {
    private $id;
    private $userId;
    private $text;
    private $creationDate;
    
    public function __construct() {
        $this->id =-1;
        $this->userId =0 ;
        $this->text ='';
        $this->creationDate = '';
    }
    public function setUserId($userId) {
        $this->userId=$userId;
    }
    public function setText($text) {
        $this->text=$text;
    }
    public function setCreationDate($creationDate) {
        $this->creationDate=$creationDate;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getText() {
        return $this->text;
    }
    public function getCreationDate() {
        return $this->creationDate;
    }
    public function getId() {
        return $this->id;
    }
    static public function loadTweetbyID(mysqli $conection, $id) {
        $sql=sprintf("SELECT * FROM Tweets WHERE id=%d", $id);
       // $ret = [];
        $result =$conection->query($sql);
        if ($result==true && $result->num_rows ==1) {
         //   foreach($result as $row) {
                $row =$result->fetch_assoc();
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId=$row['user_id'];
                $loadedTweet->text=$row['text'];
                $loadedTweet->creationDate=$row['creation_date'];
             //   $ret[]=$loadedTweet;
                return $loadedTweet;
           // }
        }
        return null;
    }
    static public function loadTweetbyUserID(mysqli $conection, $userid) {
        $sql=sprintf("SELECT * FROM Tweets WHERE user_id=%d order by creation_date DESC", $userid);
        $ret = [];
        $result =$conection->query($sql);
        if ($result==true && $result->num_rows !=0) {
            foreach($result as $row) {
           // $row =$result->fetch_assoc();
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId=$row['user_id'];
                $loadedTweet->text=$row['text'];
                $loadedTweet->creationDate=$row['creation_date'];
                $ret[]=$loadedTweet;
            }
            return $ret;
            
        }
        return null;
    }
    static public function loadAllTweets(mysqli $connection) {
      //  $sql=sprintf("SELECT tweets.id as id, users.username as username, tweets.user_id, as user_id, tweets.creation_date as creation_date, tweets.text as text FROM Tweets JOIN users on users.id=tweets.user_id order by creation_date DESC");
        $sql=sprintf("SELECT * FROM Tweets order by creation_date DESC");
        $ret = [];
        $result =$connection->query($sql);
        if ($result==true && $result->num_rows !=0) {
            foreach($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id=$row['id'];
                $loadedTweet->userId=$row['user_id'];
                $loadedTweet->text=$row['text'];
                $loadedTweet->creationDate=$row['creation_date'];
              //  $username=$row['username'];
                $ret[]=$loadedTweet;
                //var_dump($loadedTweet);
            }
            return $ret;
        }
        return null;
    }
    public function save(mysqli $connection)
    {
        if ($this->id==-1) {
            $sql=  sprintf("INSERT INTO `Tweets`(`id`, `user_id`, `text`, `creation_date`) VALUES (NULL,%d,'%s',%s)",
                            $this->userId,                           
                            $this->text,
                            $this->creationDate);
            $result = $connection->query($sql);
            if ($result==true) {
                $this->id=$connection->insert_id;
                return TRUE;
            }
        } else {
            $sql= sprintf("UPDATE `Tweets` SET `user_id`=%d,`text`='%s',`creation_date`='%s' WHERE id=%d", $this->userId, $this->text, $this->creationDate, $this->id);
            $result = $connection->query($sql);
            if($result == true){
            return true;
            }
        }
        return false;
    }
    static public function countCommentsByTweetId(mysqli $connection, $tweetId) {
        $sql=sprintf("SELECT COUNT(*) as Count FROM Comments where Comments.tweet_id=%d", $tweetId);
        $result =$connection->query($sql);
         if ($result==true && $result->num_rows ==1) {
         
                $row =$result->fetch_assoc();
                $count = $row['Count'];               
        return $count ;
         }
    }
}