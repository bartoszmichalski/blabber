<?php

include_once 'library.php';

session_start();
if (isset($_SESSION['username']) || isset($_SESSION['user_id']) || isset($_SESSION['user'])) {
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user']);
    echo ('Sesja skasowana');
} else {
    echo ('Brak zmiennych sesyjnych');
}
header("Location: login.php");
