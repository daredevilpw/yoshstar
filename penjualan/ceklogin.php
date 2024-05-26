<?php

require 'function.php';

if (isset($_SESSION['login'])){

}else{
    //belumlogin
    header('location:login.php');
} 

?>