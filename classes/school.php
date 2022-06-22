<?php

  class School{

      private static $sqlQuery;

      private static $name;
      private static $schoolId;

      private static $result;

      public function __construct(){

      }

      static function  getName($DB, $school_id){
        try{
              self::$schoolId = $school_id;

              self::$sqlQuery = "Select id, name from {newwaves_schools} where id=".self::$schoolId;

              self::$result = $DB->get_records_sql(self::$sqlQuery);

              foreach(self::$result as $row){
                self::$name = $row->name;
              }

              return self::$name;
        }catch(Exception $e){
              throw $e->getMessage();
        }


      }



  }



?>
