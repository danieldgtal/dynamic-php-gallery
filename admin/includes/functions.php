<?php 
function classAutoLoader($class){
   // Auto loader function check for missing class and includes it
   $class = strtolower($class);
   $the_path = "includes/{$class}.php";

  if(is_file($the_path) && !class_exists($class)){
    include $the_path;
  }


}
spl_autoload_register('classAutoLoader');

function redirect($location){
   header("Location: {$location}");
}
?>