<?php 
include('database/db.php');
$filename =  $_SERVER['REQUEST_URI'];


switch($filename){
    case "/check-twitter-user/registration": 
        require __DIR__ . '/view/registration.html';
    break;
    case "/check-twitter-user/": 
        require __DIR__ . '/view/login.html';
    break;
    case "/check-twitter-user/profile": 
    require __DIR__ . '/view/profile.php';
break;
    case "/check-twitter-user/login": 
       
        echo db::openConnectionWithDB()?"Connection open  <br>":"not open <br>";
           db::login();
         db::closeConnection();
    break;
    case "/check-twitter-user/create/user": 
    echo db::openConnectionWithDB()?"Connection open  <br>":"not open <br>";
        db::insertUser();
    db::closeConnection();
     header("Location: /check-twitter-user/");
    break;
    case "/check-twitter-user/migration/": 
        // require __DIR__ . '/view/login.html'; 
      try{  
      echo  db::openConnectionWithoutDB()?"Connection open <br>":"not open  <br>";
      echo db::createDB()?"createDB  <br>":"not createDB <br>";
      /*echo*/ db::closeConnection();
      echo db::openConnectionWithDB()?"Connection open  <br>":"not open <br>";
      echo db::createUserTable()?"createUserTable  <br>":"not createUserTable <br>";
      echo db::createUserFeedBackTable()?"createUserFeedBackTable  <br>":"not createUserFeedBackTable <br>";
      echo ' <div class="registration">
      <a  href="/check-twitter-user/"> login now</a>
     </div>';
     db::closeConnection();
     }catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    break;
    case "/check-twitter-user/Drop/DataBase/": 
      try{  
        echo  db::openConnectionWithoutDB()?"Connection open <br>":"not open  <br>";
            echo db::dropDB()?"dropDB  <br>":"not dropDB <br>";
      db::closeConnection();
      }catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    break;
    default:
    echo $filename,"<br> asd";
    http_response_code(404);
    break;

}
?>