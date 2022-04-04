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
 * @package     auth class
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



 class Auth{

     private $sqlQuery;
     private $emailfound;
     private $output;

     public function __construct(){
       $this->sqlQuery = null;


     }

     public function isEmailExist($DB, $email){
       $this->sqlQuery = "Select count(email) as emailcount from {newwaves_schools_users} where email='{$email}'";
       $this->emailfound = $DB->get_records_sql($this->sqlQuery);
       foreach($this->emailfound as $row){
          $result = $row->emailcount;
       }

       return $result;
     }

     public function getMoodleUserId($DB, $email){

         $result = '';
         $this->sqlQuery = "Select id from {user} where email='{$email}'";
         $this->output = $DB->get_records_sql($this->sqlQuery);
         foreach($this->output as $row){
            $result = $row->id;
         }
         return $result;
     }

     public function getNESUserId($DB, $email){

         $result = '';
         $this->sqlQuery = "Select id from {newwaves_schools_users} where email='{$email}'";
         $this->output = $DB->get_records_sql($this->sqlQuery);
         foreach($this->output as $row){
            $result = $row->id;
         }
         return $result;
     }


 }



?>
