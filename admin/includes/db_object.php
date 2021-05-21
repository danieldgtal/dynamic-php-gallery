<?php 
class Db_object {

   public $errors = array();
   public $upload_errors_array = array(


	UPLOAD_ERR_OK           => "There is no error",
	UPLOAD_ERR_INI_SIZE		=> "The uploaded file exceeds the upload_max_filesize directive in php.ini",
	UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
	UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
	UPLOAD_ERR_NO_FILE      => "No file was uploaded.",               
	UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
	UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
	UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload."					
    

   );

   //This is passing $_FILES['upload_files'] as an argument
  public function set_file($file){

   if(empty($file) || !$file || !is_array($file)) {
     
     $this->errors[] = "There was no file uploaded here";
       return false;
     
   } elseif($file['error'] != 0) {
     $this->errors[] = $this->upload_errors_array[$file['error']];
       return false;
   
   } else {

     $this->filename = basename($file['name']);
     $this->tmp_path = $file['tmp_name'];
     $this->type     = $file['type'];
     $this->size     = $file['size'];
 
   }
   
 }


    public static function find_all(){
      // This method finds all users in the database
      global $database; 
      
      return static::query_finder("SELECT * FROM ". static::$db_table. " ");

    }

    public static function query_finder($sql_statement){
      // This methods accepts sql query 
      global $database;
  
      $result_set = $database->query($sql_statement);
      $the_object_array = array();
  
      while($row = mysqli_fetch_array($result_set)){
        $the_object_array[] = static::instantiation($row);
      }
      return $the_object_array;
  
    }

    public static function find_by_id($id){
      // This method find user in the database by id
      global $database;
      
      $the_result_array = static::query_finder("SELECT * FROM  ". static::$db_table. " WHERE id = $id LIMIT 1");
      
      return !empty($the_result_array) ? array_shift($the_result_array) :false;  
    }


  private static function instantiation($the_record){

    $calling_class = get_called_class();
    $the_object = new $calling_class; //This line instantiate the Class

      // $the_object->id = $found_user['id'];
      // $the_object->username = $found_user['username'];
      // $the_object->password = $found_user['password'];
      // $the_object->firstname = $found_user['firstname'];
      // $the_object->lastname = $found_user['lastname'];

      // loop through the record(which is an array with properties and value) 
      foreach($the_record as $the_attribute => $value){
       
         if($the_object->has_the_attribute($the_attribute)){
               // checks if the objects has an attribute with the created has_the_attribute method
               // then assigns the attribute value to for each parameter called $value
          
            $the_object->$the_attribute = $value;

         }
      
      }
    return $the_object;
    
   }//End of user class

  private function has_the_attribute($the_attribute){
      
    $object_properties = get_object_vars($this);
    return array_key_exists($the_attribute, $object_properties);
  
  }

  public function properties(){
    //This function pull out the properties in the class static property and stores it in an array
    $properties = array();
    
    foreach(static::$db_table_fields as $db_fields){//loops through class static property named $db_table_fields
       if(property_exists($this, $db_fields)){ //checks if the property exists in the class

          $properties[$db_fields] = $this->$db_fields; //appends property into the created array in the function
          
       } 
       
    }
    return $properties;
    // echo array_values($properties);
  }

   protected function clean_properties(){
      // this function cleans the array of data form properties
      global $database;

      $clean_properties = array();

      foreach($this->properties() as $key => $values){

         $clean_properties[$key] = $database->escape_string($values);
      }
      return $clean_properties;
   }


  public function save(){ 
    //This function is an abstraction of create method
    return isset($this->id) ? $this->update() : $this->create();

 }


    public function create(){
      global $database;

      $properties = $this->clean_properties();
   
      $sql  = "INSERT INTO ".static::$db_table ."("  .implode(",", array_keys($properties)) . ")"; //implode seperate an array with a given symbol
      $sql .= "VALUES ('". implode("','",array_values($properties)) ."')";
 
      if($database->query($sql)){        
         $this->id = $database->the_insert_id();
         return true;

      }else {
         return false;

      }
      // return  $database->query($sql)?true:false; //using ternary operator to write the above code
    }//Create Method


  public function update(){
    global $database;

    $properties = $this->clean_properties();
    $properties_pairs  = array();

    foreach($properties as $key =>$value){
        $properties_pairs[] = "{$key} ='{$value}'";
    }

    $sql  = "UPDATE  ".static::$db_table . " SET ";  
    $sql  .= implode(",", $properties_pairs);
    $sql .= " WHERE id= " .$database->escape_string($this->id);
      
    $database->query($sql);

    return (mysqli_affected_rows($database->conn) == 1)? true : false;

  }//End of update method

  public function delete(){
    global $database;

    $id = $database->escape_string($this->id);
    $sql  = "DELETE FROM " .static::$db_table . " WHERE id = '{$id}' LIMIT 1 ";  
    $database->query($sql);

    return (mysqli_affected_rows($database->conn) == 1)? true: false;

  }

  public static function count_all(){
    global $database;

    $sql = "SELECT COUNT(*) FROM " . static::$db_table;
    $result_set = $database->query($sql);
    $row = mysqli_fetch_array($result_set);

    return array_shift($row);
    
  }

}


?>