<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function isInSession() {
    if (isset($_SESSION['username']) && isset($_SESSION['user_id']) && isset($_SESSION['user'])) {
        return true;
    } else {
        header("Location: http://localhost/blabber/login.php");
    }
};