<?php
session_start();

include_once 'library.php';


$connection = new Connection($mysql);
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $email=$_POST['email'];
    $password=$_POST['password'];

    $isEmailinDB = User::loadUserbyEmail($mysql, $email);
    if (is_null($isEmailinDB)) {
        echo'Niezarejestrowany adres email.'; 
    } else { 
    if  (password_verify($password,$isEmailinDB->getHashedPassword())){
        echo 'Hasło poprawne.';
        $_SESSION['user_id']=$isEmailinDB->getId();
        $_SESSION['user']=$isEmailinDB;
        $_SESSION['username']=$isEmailinDB->getUserName();
    //    $connection = close();
    //    $connection  = null;
        header("Location: main.php"); 
        } else {
        echo 'Nieprawidlowy email lub hasło.';}
    }
}



    

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
<div>
    <form class="login_form" method="post" action="#">
        <label>email:</label><br>
        <input name="email" type="text" maxlength="255" value="" size="50"/><br>
        <label>hasło:</label><br>
        <input name="password" type="password" maxlength="255" value="" size="50"/><br>
        <button type="submit" name="submit" value="submit">Zaloguj</button><br>
        
    </form>
    <a href="register.php">zarejestruj się</a>
</div>
</html>