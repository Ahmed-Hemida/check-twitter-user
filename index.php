<?php 

include('Controllers/controller.php');
$filename =  $_SERVER['REQUEST_URI'];
 $auth= (isset($_SESSION['Auth'])&&$_SESSION['Auth'])?true:false;

switch($filename){
    case "/check-twitter-user/registration": 
        require __DIR__ . '/view/registration.html';
    break;
    case "/check-twitter-user/": 
        require __DIR__ . '/view/login.html';
    break;
    case "/check-twitter-user/profile": 
        if(!$auth)header("Location: /check-twitter-user/");
    require __DIR__ . '/view/profile.php';
    break;
    case "/check-twitter-user/logOut": 
        if(!$auth)header("Location: /check-twitter-user/");
        controller::logOut();
    break;
    case "/check-twitter-user/login": 
        controller::login();
        if(!$auth)header("Location: /check-twitter-user/");
    break;
    case "/check-twitter-user/feedback": 
        if(!$auth)header("Location: /check-twitter-user/");
        controller::createFeedback();
    break;
    case "/check-twitter-user/get/user/feedback": 
        if(!$auth)header("Location: /check-twitter-user/");
        controller::getUserFeedback();
    break;
    case "/check-twitter-user/create/user": 
        controller::createUser();
    break;
    case "/check-twitter-user/migration": 
        controller::migration();
    break;
    case "/check-twitter-user/Drop/DataBase/": 
        controller::DrobDB();
    break;
    default:
    if(!$auth)header("Location: /check-twitter-user/");
    break;

}
?>