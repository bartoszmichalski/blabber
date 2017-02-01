<?php



include_once 'library.php';

session_start();
if (isInSession()) {
    $userId=$_SESSION['user_id'];
    if (isset($_SESSION['username'])) {
            echo 'Edycja konta '.$_SESSION['username'].'<br>';
    }
    
    if ($_SERVER['REQUEST_METHOD']==='POST') {
         
        if ($_POST['submit']=='username') {
            if  (trim($_POST['username'])!='') {
                $username=$_POST['username'];
                $new_user = new User();
                $new_user->setUsername($username);
                $new_user->save($mysql);
                $_SESSION['user']=$new_user;
                $_SESSION['user_id']=$new_user->getId();
                $_SESSION['username']=$new_user->getUserName();
                echo 'Zapisano';
            
            } else {
                echo 'Wartości nie moga być puste';
                
            }
        }
        if ($_POST['submit']=='password')   {
            if (trim($_POST['password'])!='') {
                $password=$_POST['password'];
                $new_user = new User();
                $new_user->setHashedPassword($password);
                $new_user->save($mysql);
                $_SESSION['user']=$new_user;
                $_SESSION['user_id']=$new_user->getId();
                $_SESSION['username']=$new_user->getUserName();
                echo 'Zapisano';
            } else {
                echo 'Wartości nie moga być puste';
            }
        }
    
    }
}
?>
<html>
    <a  style="float:right" href="delsession.php">Wyloguj</a><br>
    <a  style="float:right" href="main_user.php">Moje wpisy</a><br>
    <a  style="float:right" href="mails.php">Moja poczta</a><br>
<div>
    <form class="movie_form" method="post" action="#">
        <label>Zmień nazwę użytkownika na:</label><br>
        <input name="username" type="text" maxlength="255" value="" size="50"/><br>
        <button type="submit" name="submit" value="username">Zapisz</button><br>
        <label>Zmień hasło na:</label><br>
        <input name="password" type="password" maxlength="255" value="" size="50"/><br>
        <button type="submit" name="submit" value="password">Zapisz</button><br>
        
    </form>
</div>
</html>