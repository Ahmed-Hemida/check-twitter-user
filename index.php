<?php 

include('Controllers/controller.php');
$filename =  $_SERVER['REQUEST_URI'];
 $auth= (isset($_SESSION['Auth'])&&$_SESSION['Auth'])?true:false;
 $project_name = basename(dirname(__FILE__));
 $auth= (isset($_SESSION['Auth'])&&$_SESSION['Auth'])?true:false;
 $url=preg_replace('/^\/'.$project_name.'/','',$filename);
 switch($url){
     case "/registration": 
        require __DIR__ . '/view/registration.html';
        break;
        case "/": 
        require __DIR__ . '/view/login.html';
    break;
    case "/profile": 
        if(!$auth)header("Location: /localhost/".$project_name);
    require __DIR__ . '/view/profile.php';
    break;
    case "/logOut": 
        if(!$auth)header("Location: /localhost/".$project_name);
        controller::logOut();
    break;
    case "/login": 
        controller::login();
        if(!$auth)header("Location: /localhost/".$project_name);
    break;
    case "/feedback": 
        if(!$auth)header("Location: /localhost/".$project_name);
        controller::createFeedback();
    break;
    case "/get/user/feedback": 
        if(!$auth)header("Location: /localhost/".$project_name);
        controller::getUserFeedback();
    break;
    case "/create/user": 
        controller::createUser();
    break;
    case "/migration": 
        controller::migration();
    break;
    case "/Drop/DataBase/": 
        controller::DrobDB();
    break;
    default:
    if(!$auth)header("Location: /localhost/".$project_name);
    break;

}
?>