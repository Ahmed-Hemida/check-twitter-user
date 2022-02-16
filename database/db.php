<?php
// namespace db;
class db{
     const  servername = "localhost";
     const  username = "root";
     const  password = "";
     const  dbname="check_twitter";
     protected static  $connection;
    /*
    $stmt = $mysqli->prepare("SELECT * FROM myTable WHERE name = ? AND age = ?");
    $stmt->bind_param("si", $_POST['name'], $_POST['age']);
    $stmt->execute();
    */
    public static function openConnectionWithoutDB(){
        
        self::$connection = new mysqli(db::servername, db::username, db::password);
         return !self::$connection->connect_error;
    }
    public static function openConnectionWithDB(){
        self::$connection = new mysqli(db::servername, db::username, db::password,db::dbname);
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
        check_status bit NOT NULL, #1 to yes 0 to no 
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
        if($stmt){ 
            echo  ("not  error ");
        }
        else{
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
    public static function login(){
       
        $stmt =self::$connection->prepare("SELECT  `userName`,`firstname`, `img` FROM `users` WHERE userName=? AND password=?" );
         // die ($stmt);
         if($stmt){ 
             echo  ("not  error ");
         }
         else{
            die  (" error ");
         }
         $stmt->bind_param( "ss",
         $_POST['userName'],
         $_POST['password']);
          $check =$stmt->execute();
          $stmt_result = $stmt->get_result();
        echo var_dump($stmt_result);
        $stmt->store_result();
         $stmt->close();
         return $check;
     }

    public static function closeConnection(){
    return self::$connection->close();
    }

}
?>