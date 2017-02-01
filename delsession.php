<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'library.php';
session_start();


    if (isset($_SESSION['username']) || isset($_SESSION['user_id']) || isset($_SESSION['user'])) {
        var_dump($_SESSION['username']);
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user']);
        echo ('Sesja skasowana');
    } else {
        echo ('Brak zmiennych sesyjnych');
    }
 header("Location: http://localhost/blabber/login.php");
