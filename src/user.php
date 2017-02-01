<?php

class User {
    
    private $id;
    private $username;
    private $email;
    private $hashedPassword;
    
    public function __construct()
    {
        $this->id=-1;
        $this->username='';
        $this->email='';
        $this->hashedPassword='';
    }
    public function setUsername($username)
    {
        $this->username=$username;
        
    }
    public function setEmail($email) {
        $this->email=$email;
        
    }
    public function setHashedPassword($newPassword){
        $newHashedPassword=  password_hash($newPassword, PASSWORD_BCRYPT);
        $this->hashedPassword=$newHashedPassword;
    }
    public function getId(){
        return $this->id;
    }
    public function getUserName(){
        return $this->username;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getHashedPassword(){
        return $this->hashedPassword;
    }
    public function save(mysqli $connection)
    {
        if ($this->id==-1) {
            $sql=  sprintf("INSERT INTO `Users`(`id`, `email`, `username`, `hashed_password`) VALUES (NULL,'%s','%s','%s')",  $this->email, $this->username, $this->hashedPassword);
            $result = $connection->query($sql);
            if ($result==true) {
                $this->id=$connection->insert_id;
                return TRUE;
            }
        } else {
            $sql= sprintf("UPDATE Users SET username='%s', email='%s', hashed_password='%s' WHERE id=%d ", $this->username, $this->email, $this->hashedPassword, $this->id);
            $result = $connection->query($sql);
            if($result == true){
            return true;
            }
        }
        return false;
    }
    static public function loadUserbyID(mysqli $connection, $id) {
        $sql=sprintf("SELECT * FROM Users WHERE id=%d", $id);
        $result =$connection->query($sql);
        if ($result==true && $result->num_rows ==1) {
            $row =$result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username=$row['username'];
            $loadedUser->hashedPassword=$row['hashed_password'];
            $loadedUser->email=$row['email'];
            return $loadedUser;
        }
        return null;
    }
    static function loadAllUsers(mysqli $connection) {
        $sql="SELECT * FROM Users";
        $ret = [];
        $result =$connection->query($sql);
        if ($result == true && $result->num_rows!=0) {
            foreach($result as $row) {
                $loadedUser = new User ();
                $loadedUser->id = $row['id'];
                $loadedUser->username=$row['username'];
                $loadedUser->hashedPassword=$row['hashed_password'];
                $loadedUser->email=$row['email'];   
                $ret[]=$loadedUser;
            }
        }
        return $ret;
        
    }
    static public function loadUserbyEmail(mysqli $connection, $email) {
        $sql=sprintf("SELECT * FROM Users WHERE email='%s'", $email);
        $result =$connection->query($sql);
        if ($result==true && $result->num_rows ==1) {
            $row =$result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->username=$row['username'];
            $loadedUser->hashedPassword=$row['hashed_password'];
            $loadedUser->email=$row['email'];
            return $loadedUser;
        }
        return null;
    }
    public function delete(mysqli $connection){
        if($this->id != -1){
            $sql = "DELETE FROM Users WHERE id=$this->id";
            $result = $connection->query($sql);
            if($result == true){
                $this->id = -1;
                return true;
            }
        return false;

        }
 
        return true;
    }
    

}