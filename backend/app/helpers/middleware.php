<?php
 
    function userOnly($redirect = "/index.php"){
        if(empty($_SESSION['id'])){
            $_SESSION['message'] = "You need to login first!";
            $_SESSION['type'] = "error";
            header('location: ' . BASE_URL . $redirect);
            exit();
        }
    }

    function adminOnly($redirect = "/index.php"){
        if(empty($_SESSION['id']) || empty($_SESSION['admin'])){
            $_SESSION['message'] = "You are not authorised!";
            $_SESSION['type'] = "error";
            header('location: ' . BASE_URL . $redirect);
            exit();
        }
    }

    function guestsOnly($redirect = "/index.php"){
        if(empty($_SESSION['id'])){
            header('location: ' . BASE_URL . $redirect);
            exit();
        }
    }

?>