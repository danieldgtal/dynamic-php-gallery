<?php 

class Session {

  private $signed_in = false;
  public  $user_id;
  public  $message;
  public  $count;

  function __construct(){

    session_start();
    $this->visitor_count();
    $this->check_the_login();
  }
   public function message($msg=""){
      
      if(!empty($msg)){
         $_SESSION['message'] = $msg; 
      } else {

         return $this->message;
      }
   }

   private function check_message(){
      
      if(isset($_SESSION['message'])){
         
         $this->message = $_SESSION['message'];
         unset($_SESSION['message']);
      } else {
         $this->message = "";
      }
   }
   public function is_signed_in(){
      return $this->signed_in;
   }

   public function login($user){
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->signed_in = true;
   }

   public function logout(){
      
      unset($_SESSION['user_id']);
      unset($this->user_id);
      session_destroy();
      $this->signed_in = false;
   }

   private function check_the_login(){
      if(isset($_SESSION['user_id'])){

         $this->user_id = $_SESSION['user_id'];
         $this->signed_in = true;
      }else {

         unset($this->user_id);
         $this->signed_in = false;
      }

  }
  public function visitor_count(){
    // counts number of visit a page has
    if(isset($_SESSION['count'])){

      return $this->count = $_SESSION['count']++;

    }else{
      return $_SESSION['count'] = 1;
    }
  }
}

$session = new Session();














?>