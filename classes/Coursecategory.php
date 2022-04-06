<?php

class Coursecategory
{

    private $courseId;
    private $sqlQuery;


    public function __construct(){
        $this->sqlQuery = null;
    }

    public function getcoursecategoryById($DB, $courseId){
        $this->courseId = $courseId;

        $this->sqlQuery = "SELECT * from {course_categories} ";
        $studentData = $DB->get_records_sql($this->sqlQuery);
        return $studentData;
    }
}