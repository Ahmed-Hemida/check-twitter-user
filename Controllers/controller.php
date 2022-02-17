<?php
include('database/db.php');
class controller{

        public static function login(){

                echo db::openConnectionWithDB()?"Connection open  <br>":"not open <br>";
                db::login();
                db::closeConnection();
                
            }
               
     public static function logOut(){
        session_unset();
        session_destroy();
        header("Location: /check-twitter-user/");
        }
        public static function createFeedback(){ 

            echo db::openConnectionWithDB()?"Connection open  <br>":"not open <br>";
            db::insertFeedBack();
            db::closeConnection();
            }
        public static function getUserFeedback() {
           
             db::openConnectionWithDB();
               db::getUserFeadBack();
             db::closeConnection();
            }
        public static function createUser(){ 
           echo db::openConnectionWithDB()?"Connection open  <br>":"not open <br>";
            db::insertUser();
        db::closeConnection();
         header("Location: /check-twitter-user/");
        }
      
        public static function migration(){
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
    }
    

    public static function DrobDB(){
        try {  
            echo  db::openConnectionWithoutDB()?"Connection open <br>":"not open  <br>";
                echo db::dropDB()?"dropDB  <br>":"not dropDB <br>";
          db::closeConnection();
          }catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
