<?php

class Comment {
    private $id;
    private $userId;
    private $tweetId;
    private $creationDate;
    private $text;
    
    public function __construct()
    {
        $this->id =-1;
        $this->userId = 0 ;
        $this->tweetId = 0 ;
        $this->creationDate = '';
        $this->text = '';
    }
    
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    public function setTweetId($tweetId)
    {
        $this->tweetId = $tweetId;
    }
    
    public function setText($text)
    {
        $this->text = $text;
    }
    
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }
    
    public function getUserId()
    {
        return $this->userId;
    }
    
    public function getTweetId()
    {
        return $this->tweetId;
    }
    
    public function getText()
    {
        return $this->text;
    }
    
    public function getCreationDate() 
    {
        return $this->creationDate;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    static public function loadCommentbyID(mysqli $conection, $id)
    {
        $sql = sprintf("SELECT * FROM Comments WHERE id=%d", $id);
        $result = $conection->query($sql);
        if ($result == true && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['user_id'];
                $loadedComment->tweetId = $row['tweet_id'];
                $loadedComment->text = $row['text'];
                $loadedComment->creationDate = $row['creation_date'];
                
                return $loadedComment;
        }
        
        return null;
    }
    
    static public function loadCommentbyTweetID(mysqli $conection, $tweetId)
    {
        $sql = sprintf("SELECT * FROM Comments WHERE tweet_id=%d order by creation_date DESC", $tweetId);
        $ret = [];
        $result = $conection->query($sql);
        if ($result == true && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['user_id'];
                $loadedComment->tweetId = $row['tweet_id'];
                $loadedComment->text = $row['text'];
                $loadedComment->creationDate = $row['creation_date'];
                $ret[] = $loadedComment;
            }
            return $ret;
            
        }
        return null;
    }

    public function save(mysqli $connection)
    {
        if ($this->id == -1) {
            $sql=  sprintf("INSERT INTO `Comments`(`id`, `user_id`, `tweet_id`, `creation_date`, `text`) VALUES (NULL,%d,%d,%s,'%s')",
                            $this->userId,                           
                            $this->tweetId,
                            $this->creationDate,
                            $this->text
                           );
            $result = $connection->query($sql);
            if ($result) {
                $this->id = $connection->insert_id;
                return true;
            }
        } else {
            $sql= sprintf("UPDATE `Comments` SET `user_id`=%d,`tweet_id`=%d,`creation_date`='%s',`text`='%s' WHERE id=%d",
                    $this->userId,
                    $this->tweetId,
                    $this->creationDate,
                    $this->text,
                    $this->id);
            $result = $connection->query($sql);
            if($result){
                
                return true;
            }
        }
        return false;
    }
}