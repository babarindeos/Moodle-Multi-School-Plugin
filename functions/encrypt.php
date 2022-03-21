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

      function generate_code(){
        $code = '';
        $i = 0;
         $characters = "012345689abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.!()";
         $character_length = strlen($characters);


         $randIndex = mt_rand(0, $character_length-1);
         for($i=0; $i<100; $i++ ){
            $randIndex = mt_rand(0, $character_length-1);
            $code .= $characters[$randIndex];
         }
         return $code;
      }

      function mask($item){
          $code_a = generate_code();
          $code_b = generate_code();

          $full_mask = $code_a."-{$item}-".$code_b;
          return $full_mask;
      }

      //$result = mask();
      //echo $result;
