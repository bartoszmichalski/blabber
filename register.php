<?php


session_start();

include_once 'library.php';



$connection = new Connection($mysql);
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (trim($_POST['username'])!='' && trim($_POST['email'])!='' && trim($_POST['password'])!='') {
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $isEmailinDB = User::loadUserbyEmail($mysql, $email);
        if (!is_null($isEmailinDB)) {
            echo 'Adres email jest już zajęty.';
        } else {
            $new_user = new User();
            $new_user->setUsername($username);
            $new_user->setEmail($email);
            $new_user->setHashedPassword($password);
            $new_user->save($mysql);
            $_SESSION['user']=$new_user;
            $_SESSION['user_id']=$new_user->getId();
            $_SESSION['username']=$new_user->getUserName();
            header("Location: main.php");
        }
    } else {
        echo 'Wartości nie moga być puste';
    }
}
?>
<form class="movie_form" method="post" action="#">
        <label>nazwa użytkownika:</label><br>
        <input name="username" type="text" maxlength="255" value="" size="50"/><br>
        <label>email:</label><br>
        <input name="email" type="text" maxlength="255" value="" size="50"/><br>
        <label>hasło:</label><br>
        <input name="password" type="password" maxlength="255" value="" size="50"/><br>
        <button type="submit" name="submit" value="submit">Zarejestruj</button><br>
        
    </form>
    <a href="login.php">zaloguj się</a>

