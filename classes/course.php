<?php

// This file is part of Newwaves Integrator Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     course class
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 class Course{

   private $sqlQuery;
   private $emailfound;
   private $output;

   public function __construct(){
     $this->sqlQuery = null;
   }


   public function getNESCourseBySchoolAndCourse($DB, $schoolId, $courseId){
     $this->sqlQuery = "Select id, category_id, school_id, creator_id, full_name, short_code, description, timecreated, timemodified
                  from {newwaves_course} where school_id='{$schoolId}' and id='{$courseId}' order by full_name";
     $this->output = $DB->get_records_sql($this->sqlQuery);
     $result = $this->output;
     return $result;
   }

   public static function getMoodleCourseId($DB, $course_category, $name, $code, $description){
      $sqlQuery = "Select * from {course} where category='{$course_category}' and fullname='{$name}' and shortname='{$code}' and summary='{$description}'";
      $output = $DB->get_records_sql($sqlQuery);

      $mdl_course_id = '';
      foreach($output as $row){
            $mdl_course_id = $row->id;
      }
      return $mdl_course_id;
   }

 }




?>
