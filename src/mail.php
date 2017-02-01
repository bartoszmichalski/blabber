<?php

class Mail {
    private $id;
    private $senderUserId;
    private $receiverUserId;
    private $creationDate;
    private $text;
    private $wasRead;


    public function __construct() {
        $this->id =-1;
        $this->senderUserId =0 ;
        $this->receiverUserId=0 ;
        $this->creationDate = '';
        $this->text ='';
        $this->wasRead =0;
    }
    public function setSenderUserId($senderUserId) {
        $this->senderUserId=$senderUserId;
    }
    public function setReceiverUserId($receiverUserId) {
        $this->receiverUserId=$receiverUserId;
    }
    public function setText($text) {
        $this->text=$text;
    }
    public function setCreationDate($creationDate) {
        $this->creationDate=$creationDate;
    }
    public function setWasRead($wasRead) {
        $this->wasRead=$wasRead;
    }
    public function getSenderUserId() {
        return $this->senderUserId;
    }
    public function getReceiverUserId() {
        return $this->receiverUserId;
    }
    public function getWasRead() {
        return $this->wasRead;
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
    
    static public function loadMailbyID(mysqli $connection, $id) {
        $sql=sprintf("SELECT * FROM `Mails` WHERE id=%d", $id);
       // $ret = [];
        $result =$connection->query($sql);
        if ($result==true && $result->num_rows ==1) {
         //   foreach($result as $row) {
                $row =$result->fetch_assoc();
                $loadedMail = new Mail();
                $loadedMail->id = $row['id'];
                $loadedMail->senderUserId=$row['sender_user_id'];
                $loadedMail->receiverUserId=$row['receiver_user_id'];
                $loadedMail->text=$row['text'];
                $loadedMail->creationDate=$row['creation_date'];
                $loadedMail->wasRead=$row['was_read'];
             //   $ret[]=$loadedTweet;
                return $loadedMail;
           // }
        }
        return null;
    }
    static public function loadMailbySenderUserID(mysqli $connection, $senderUserid) {
        $sql=sprintf("SELECT * FROM `Mails` WHERE sender_user_id=%d order by creation_date DESC", $senderUserid);
        $ret = [];
        $result =$connection->query($sql);
        if ($result==true && $result->num_rows !=0) {
           foreach($result as $row) {
              //  $row =$result->fetch_assoc();
                $loadedMail = new Mail();
                $loadedMail->id = $row['id'];
                $loadedMail->senderUserId=$row['sender_user_id'];
                $loadedMail->receiverUserId=$row['receiver_user_id'];
                $loadedMail->text=$row['text'];
                $loadedMail->creationDate=$row['creation_date'];
                $loadedMail->wasRead=$row['was_read'];
                $ret[]=$loadedMail;
                
            }
            return $ret;
        }
        return null;
    }
    static public function loadMailbyReceiverUserID(mysqli $connection, $receiverUserid) {
        $sql=sprintf("SELECT * FROM `Mails` WHERE receiver_user_id=%d  order by creation_date DESC", $receiverUserid);
        $ret = [];
        $result =$connection->query($sql);
        if ($result==true && $result->num_rows !=0) {
           foreach($result as $row) {
               // $row =$result->fetch_assoc();
                $loadedMail = new Mail();
                $loadedMail->id = $row['id'];
                $loadedMail->senderUserId=$row['sender_user_id'];
                $loadedMail->receiverUserId=$row['receiver_user_id'];
                $loadedMail->text=$row['text'];
                $loadedMail->creationDate=$row['creation_date'];
                $loadedMail->wasRead=$row['was_read'];
                $ret[]=$loadedMail;
                
            }
            return $ret;
        }
        return null;
    }
//    static public function loadCommentbyTweetID(mysqli $conection, $tweetId) {
//        $sql=sprintf("SELECT * FROM Comments WHERE tweet_id=%d order by creation_date DESC", $tweetId);
//        $ret = [];
//        $result =$conection->query($sql);
//        if ($result==true && $result->num_rows !=0) {
//            foreach($result as $row) {
//           // $row =$result->fetch_assoc();
//                $loadedComment = new Comment();
//                $loadedComment->id = $row['id'];
//                $loadedComment->userId=$row['user_id'];
//                $loadedComment->tweetId=$row['tweet_id'];
//                $loadedComment->text=$row['text'];
//                $loadedComment->creationDate=$row['creation_date'];
//                $ret[]=$loadedComment;
//            }
//            return $ret;
//            
//        }
//        return null;
//    }

    public function save(mysqli $connection)
    {
        if ($this->id==-1) {
            //INSERT INTO `Mails`(`id`, `sender_user_id`, `receiver_user_id`, `creation_date`, `text`, `was_read`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
            $sql=  sprintf("INSERT INTO `Mails`(`id`, `sender_user_id`, `receiver_user_id`, `creation_date`, `text`, `was_read`)  VALUES (NULL,%d,%d,%d,'%s',%d)",
                            $this->senderUserId,
                            $this->receiverUserId,
                            $this->creationDate,
                            $this->text,
                            $this->wasRead
                           );
            $result = $connection->query($sql);
            if ($result==true) {
                $this->id=$connection->insert_id;
                return TRUE;
            }
        } else {
            //UPDATE `Mails` SET `id`=[value-1],`sender_user_id`=[value-2],`receiver_user_id`=[value-3],`creation_date`=[value-4],`text`=[value-5],`was_read`=[value-6] WHERE 1
            //UPDATE `Comments` SET `user_id`=%d,`tweet_id`=%d,`creation_date`='%s',`text`='%s' WHERE id=%d",
            $sql= sprintf("UPDATE `Mails` SET `sender_user_id`=%d,`receiver_user_id`=%d,`creation_date`=%d,`text`='%s',`was_read`=%d WHERE id=%d",
                    $this->senderUserId,
                    $this->receiverUserId,
                    $this->creationDate,
                    $this->text,
                    $this->wasRead,
                    $this->id
                        );
            $result = $connection->query($sql);
            if($result == true){
            return true;
            }
        }
        return false;
    }
}


