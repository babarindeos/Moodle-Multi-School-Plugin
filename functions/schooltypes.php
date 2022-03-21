<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     local_message
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */


 function schoolTypes($typeId){
      $schoolType = '';
      switch($typeId){
        case 1:
          $schoolType = 'Primary School';
          break;
        case 2:
          $schoolType = 'Secondary School';
          break;
        case 3:
          $schoolType = 'College of Education';
          break;
        case 4:
          $schoolType = 'Polytechnic';
          break;
        case 5:
          $schoolType = 'University';
          break;
      }

      return $schoolType;
 }


 
