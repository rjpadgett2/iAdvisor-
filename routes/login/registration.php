<?php
//include connection file
include_once("../../connect/config.php");
// require_once '/connect/config.php"';

$db = new dbObj();
$connString =  $db->getConnstring();

$params = $_REQUEST;
$action = $params['action'] !='' ? $params['action'] : '';
$stdCls = new Student($connString);
$advCls = new Advisor($connString);

switch($action) {
 case 'student_login':
	$stdCls->login();
 case 'student_register':
  $stdCls->register();
 case 'student_logout':
  $stdCls->logout();
 break;
 case 'advisor_register':
  $advCls->register();
 break;
 case 'advisor_login':
  $advCls->login();
 break;
 case 'advisor_logout':
  $advCls->logout();
 break;
 default:
 return;
}

Class Student {
 protected $con;
 protected $data = array();
 function __construct($connString) {
   $this->conn = $connString;
 }

 function login() {
    if(isset($_POST['student_login-submit'])) {
      $user_email = trim($_POST['username']);
      $user_password = trim($_POST['password']);
      $sql = "SELECT student_id, last_name, first_name, email, password FROM Students WHERE email='$user_email'";
      $resultset = mysqli_query($this->conn, $sql) or die("database error:". mysqli_error($this->conn));
      $row = mysqli_fetch_assoc($resultset);
      if(password_verify($user_password, $row['password'])){
        echo "1";
        $_SESSION['email'] = $user_email;
        $_SESSION['username'] = $row['first_name'];
        exit;
      } else {
        echo "Ohhh ! Wrong Credential."; // wrong details
      }
    }
  }


 function logout() {
   unset($_SESSION['username']);
   unset($_SESSION['email']);
   if(session_destroy()) {
     header("Location: ../../index.php");
   }
 }

 function register() {
   if(isset($_POST['register_button'])) {

     $password = trim($_POST['password']);
     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
     $advisor = 0;

     $user_email = mysqli_real_escape_string($this->conn, trim($_POST['email']));
     $f_name = mysqli_real_escape_string($this->conn, trim($_POST['f_name']));
     $l_name = mysqli_real_escape_string($this->conn, trim($_POST['l_name']));
     $user_password = mysqli_real_escape_string($this->conn, $hashed_password);
     $sql = "INSERT INTO `Students` (`email`, `last_name`, `first_name`, `password`) VALUES
         ('".$user_email."', '".$l_name."', '".$f_name."' , '".$user_password."');";
     $resultset = mysqli_query($this->conn, $sql) or die("database error:". mysqli_error($this->conn));
     //$row = mysqli_fetch_assoc($resultset);
     if($resultset){
       echo "1";
     } else {
       echo "Ohhh ! Something Wrong."; // wrong details
     }
   }
 }
}

Class Advisor {
 protected $con;
 protected $data = array();
 function __construct($connString) {
   $this->conn = $connString;
 }

 function login() {
    if(isset($_POST['advisor_login-submit'])) {
      $user_email = trim($_POST['username']);
      $user_password = trim($_POST['password']);
      $sql = "SELECT advisors_id, first_name, last_name,  email, password FROM Advisors WHERE email='$user_email'";
      $resultset = mysqli_query($this->conn, $sql) or die("database error:". mysqli_error($this->conn));
      $row = mysqli_fetch_assoc($resultset);
      if(password_verify($user_password, $row['password'])){
        echo "1";
        $_SESSION['email'] = $user_email;
        $_SESSION['username'] = $row['first_name'];
        exit;
      } else {
        echo "Ohhh ! Wrong Credential."; // wrong details
      }
    }
  }


 function logout() {
   unset($_SESSION['username']);
   unset($_SESSION['email']);
   if(session_destroy()) {
     header("Location: ../../index.php");
   }
 }

 function register() {
   if(isset($_POST['register_button'])) {

     $password = trim($_POST['password']);
     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

     $user_email = mysqli_real_escape_string($this->conn, trim($_POST['email']));
     $f_name = mysqli_real_escape_string($this->conn, trim($_POST['f_name']));
     $l_name = mysqli_real_escape_string($this->conn, trim($_POST['l_name']));
     $user_password = mysqli_real_escape_string($this->conn, $hashed_password);
     $sql = "INSERT INTO `Advisors` (`email`, `first_name`, `last_name`,  `password`) VALUES
         ('".$user_email."', '".$f_name."' , '".$l_name."', '".$user_password."');";
     $resultset = mysqli_query($this->conn, $sql) or die("database error:". mysqli_error($this->conn));
     //$row = mysqli_fetch_assoc($resultset);
     if($resultset){
       echo "1";
     } else {
       echo "Ohhh ! Something Wrong."; // wrong details
     }
   }
 }
}
?>
