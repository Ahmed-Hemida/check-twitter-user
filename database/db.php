<?php
  session_start();
// namespace db;
class db{
     const  servername = "localhost";
     const  username = "root";
     const  password = "";
     const  dbname="check_twitter";
     const  dbPort="4306";
     protected static  $connection;
    /*
    $stmt = $mysqli->prepare("SELECT * FROM myTable WHERE name = ? AND age = ?");
    $stmt->bind_param("si", $_POST['name'], $_POST['age']);
    $stmt->execute();
    */
    public static function openConnectionWithoutDB(){
        
        self::$connection = new mysqli(db::servername, db::username, db::password,'',db::dbPort);
         return !self::$connection->connect_error;
    }
    public static function openConnectionWithDB(){
        self::$connection = new mysqli(db::servername, db::username, db::password,db::dbname,db::dbPort);
        return !self::$connection->connect_error;
    }
    public static function createDB(){
        $sql="CREATE DATABASE check_twitter";
        return self::$connection->query($sql) === TRUE;
    }
    public static function dropDB(){
        $sql="DROP DATABASE check_twitter";
        return self::$connection->query($sql) === TRUE;
    }
    public static function createUserTable(){
       
        $sql="CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            userName VARCHAR(50)NOT NULL,
            password VARCHAR(50)NOT NULL,
            phone VARCHAR(15),
            img VARCHAR(512),
            gender VARCHAR(512),
            create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
        return self::$connection->query($sql) === TRUE;
    }
    public static function createUserFeedBackTable(){
       
        $sql="CREATE TABLE feedback ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        userID INT(6) UNSIGNED,
         FOREIGN KEY (userID) REFERENCES users(id),
        check_status INT(1) NOT NULL, #1 to yes 0 to no 
        feedback VARCHAR(512), 
        create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
        )";
        return self::$connection->query($sql) === TRUE;
    }
    public static function insertUser(){
       
       $stmt =self::$connection->prepare("INSERT INTO `users`
        (`firstname`, `lastname`, `userName`, `password`, `phone`, `img`, `gender`)
         VALUES (?,?,?,?,?,?,?)");
        // die ($stmt);
        if(!$stmt){
           die  (" error ");
        }

        $stmt->bind_param( "sssssss",
        $_POST['firstName'],
        $_POST['lastName'],
        $_POST['userName'],
        $_POST['password'],
        $_POST['phone'],
        $_POST['img'],
        $_POST['gender']);
        $check =$stmt->execute();

        $stmt->close();
        return $check;
    }
    public static function insertFeedBack(){
       
        $stmt =self::$connection->prepare("INSERT INTO `feedback`
         (`userID`, `check_status`, `feedback`)
          VALUES (?,?,?)");
         // die ($stmt);
         if($stmt){ 
             echo  ("not  error ");
         }
         else{
            die  (" error ");
         }
        
         $stmt->bind_param( "sss",
         $_SESSION['userID'],
         $_POST['check_status'],
         $_POST['feedback']);
         $check =$stmt->execute();
         
         $stmt->close();
         header("Location: /check-twitter-user/profile");
         return $check;
     }
       public static function getUserFeadBack(){
        $stmt =self::$connection->prepare("SELECT * FROM `feedback` WHERE userID=?" );
         // die ($stmt);
         if(!$stmt){ 
            die  (" error ");
         }
         $stmt->bind_param( "s", $_SESSION['userID']);
          $check =$stmt->execute();
          $stmt_result = $stmt->get_result();
        //   die(var_dump($stmt_result));
      
        $data=array();
        if ($stmt_result->num_rows > 0) {
            // output data of each row
            while($row = $stmt_result->fetch_assoc()) {
                $data[] = ['id'=>$row['id'],'check_status'=>$row['check_status'],'feedback'=>$row['feedback']];
            //   header("Location: /check-twitter-user/profile");
            }
          } 

        //   $stmt->store_result();
         $stmt->close();
         print_r(json_encode($data));
     }
    public static function login(){
       
        $stmt =self::$connection->prepare("SELECT `id`, `userName`,`firstname`,`lastname`, `img` FROM `users` WHERE userName=? AND password=?  LIMIT 1" );
         // die ($stmt);
         if(!$stmt){ 
            die  (" error ");
         }
        
        
         $stmt->bind_param( "ss",
         $_POST['userName'],
         $_POST['password']);
          $check =$stmt->execute();
          $stmt_result = $stmt->get_result();
        //   die(var_dump($stmt_result));
        if ($stmt_result->num_rows > 0) {
            // output data of each row
            while($row = $stmt_result->fetch_assoc()) {
            
              $_SESSION['userID']= $row["id"];
              $_SESSION['userName']= $row["userName"];
              $_SESSION['imgUrl']= $row["img"];
              $_SESSION['Auth']=true;
              $_SESSION['name']= $row["firstname"]." ".$row["lastname"];
              $_SESSION['token']=hash("sha256",  rand());
              header("Location: /check-twitter-user/profile");
            }
          } else {
            echo "username or password isn't correct ";
          }
        $stmt->store_result();
         $stmt->close();
         return $check;
     }


    public static function closeConnection(){
    return self::$connection->close();
    }

}
