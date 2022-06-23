<?php

class Coursecategory
{

    private $courseId;
    private $sqlQuery;
    private $result;


    public function __construct(){
        $this->sqlQuery = null;
    }

    public function getcoursecategoryById($DB, $courseId){
        $this->courseId = $courseId;

        $this->sqlQuery = "SELECT * from {course_categories}";
        $studentData = $DB->get_records_sql($this->sqlQuery);
        return $studentData;
    }

    public function getCourseCategory($DB){
      // retrieve school information from DB
        $this->sqlQuery = "SELECT * from {course_categories}";
        $categories =  $DB->get_records_sql($this->sqlQuery);
        return $categories;
    }

    public static function getLastCategoryId($DB){
        $sqlQuery = "SELECT * from {course_categories} order by id desc limit 0,1";
        $categories =  $DB->get_records_sql($sqlQuery);
        $lastId = 0;
        foreach($categories as $row){
          $lastId = $row->id;
        }
        return $lastId;
    }

    public static function getMoodleCourseCategoryId($DB, $name, $code){
        $sqlQuery = "SELECT id from {course_categories} where name='{$name}' order by id desc limit 0,1";
        $catId = $DB->get_records_sql($sqlQuery);
        foreach($catId as $row){
            $lastId = $row->id;
        }
        return $lastId;
    }

    public function getCategoriesBySchool($DB, $school_id){
        $this->sqlQuery = "SELECT  * from {newwaves_course_categories} where id='".$school_id."' order by id desc";

        $this->result = $DB->get_records_sql($this->sqlQuery);
        return $this->result;
    }


    public function getCourseCategoryBySchool($DB, $school_id){
        $this->sqlQuery = "SELECT  * from {newwaves_course_categories} where id={$school_id} order by id desc";

        $this->result = $DB->get_records_sql($this->sqlQuery);
        return $this->result;
    }



}
