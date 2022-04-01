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
 * @package     title
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 function title($option){
    $title = '';

    switch($option){
      case 0:
        $title = 'Mr.';
        break;
      case 1:
        $title = "Mrs.";
        break;
      case 2:
        $title = "Ms.";
        break;
      case 3:
        $title = "Dr.";
        break;
      case 4:
        $title = "Prof.";
        break;
    }

    return $title;
 }
