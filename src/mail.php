<?php

class Mail {
    private $id;
    private $senderUserId;
    private $receiverUserId;
    private $creationDate;
    private $text;
    private $wasRead;


    public function __construct()
    {
        $this->id = -1;
        $this->senderUserId = 0 ;
        $this->receiverUserId = 0 ;
        $this->creationDate = '';
        $this->text = '';
        $this->wasRead = 0;
    }
    
    public function setSenderUserId($senderUserId)
    {
        $this->senderUserId = $senderUserId;
    }
    
    public function setReceiverUserId($receiverUserId)
    {
        $this->receiverUserId = $receiverUserId;
    }
    
    public function setText($text)
    {
        $this->text = $text;
    }
    
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }
    
    public function setWasRead($wasRead) 
    {
        $this->wasRead = $wasRead;
    }
    
    public function getSenderUserId()
    {
        return $this->senderUserId;
    }
    
    public function getReceiverUserId()
    {
        return $this->receiverUserId;
    }
    
    public function getWasRead()
    {
        return $this->wasRead;
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
    
    static public function loadMailbyID(mysqli $connection, $id)
    {
        $sql = sprintf("SELECT * FROM `Mails` WHERE id=%d", $id);
        $result = $connection->query($sql);
        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedMail = new Mail();
            $loadedMail->id = $row['id'];
            $loadedMail->senderUserId = $row['sender_user_id'];
            $loadedMail->receiverUserId = $row['receiver_user_id'];
            $loadedMail->text = $row['text'];
            $loadedMail->creationDate = $row['creation_date'];
            $loadedMail->wasRead = $row['was_read'];

            return $loadedMail;
        }
        
        return null;
    }
    
    static public function loadMailbySenderUserID(mysqli $connection, $senderUserid)
    {
        $sql = sprintf("SELECT * FROM `Mails` WHERE sender_user_id=%d order by creation_date DESC", $senderUserid);
        $ret = [];
        $result = $connection->query($sql);
        if ($result && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedMail = new Mail();
                $loadedMail->id = $row['id'];
                $loadedMail->senderUserId = $row['sender_user_id'];
                $loadedMail->receiverUserId = $row['receiver_user_id'];
                $loadedMail->text = $row['text'];
                $loadedMail->creationDate = $row['creation_date'];
                $loadedMail->wasRead = $row['was_read'];
                $ret[] = $loadedMail;                
            }
            
            return $ret;
        }
        
        return null;
    }
    
    static public function loadMailbyReceiverUserID(mysqli $connection, $receiverUserid)
    {
        $sql = sprintf("SELECT * FROM `Mails` WHERE receiver_user_id=%d  order by creation_date DESC", $receiverUserid);
        $ret = [];
        $result = $connection->query($sql);
        if ($result && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedMail = new Mail();
                $loadedMail->id = $row['id'];
                $loadedMail->senderUserId = $row['sender_user_id'];
                $loadedMail->receiverUserId = $row['receiver_user_id'];
                $loadedMail->text = $row['text'];
                $loadedMail->creationDate = $row['creation_date'];
                $loadedMail->wasRead = $row['was_read'];
                $ret[] = $loadedMail;                
            }
            
            return $ret;
        }
        
        return null;
    }

    public function save(mysqli $connection)
    {
        if ($this->id == -1) {
            $sql = sprintf("INSERT INTO `Mails`(`id`, `sender_user_id`, `receiver_user_id`, `creation_date`, `text`, `was_read`)  VALUES (NULL,%d,%d,%d,'%s',%d)",
                            $this->senderUserId,
                            $this->receiverUserId,
                            $this->creationDate,
                            $this->text,
                            $this->wasRead
                           );
            $result = $connection->query($sql);
            if ($result) {
                $this->id = $connection->insert_id;
                return true;
            }
        } else {
            $sql = sprintf("UPDATE `Mails` SET `sender_user_id`=%d,`receiver_user_id`=%d,`creation_date`=%d,`text`='%s',`was_read`=%d WHERE id=%d",
                    $this->senderUserId,
                    $this->receiverUserId,
                    $this->creationDate,
                    $this->text,
                    $this->wasRead,
                    $this->id
                        );
            $result = $connection->query($sql);
            if($result){

                return true;
            }
        }

        return false;
    }
}


