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
 * @package     state
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 function state($option){
   $state = '';
   switch($option){
     case 1:
        $state = 'Abia';
        break;
     case 2:
        $state = 'Abuja';
        break;
     case 3:
        $state = 'Adamawa';
        break;
      case 4:
        $state = 'Akwa Ibom';
        break;
      case 5:
        $state = 'Anambra';
        break;
      case 6:
        $state = 'Bauchi';
        break;
      case 7:
        $state = 'Bayelsa';
        break;
      case 8:
        $state = 'Benue';
        break;
      case 9:
        $state = 'Borno';
        break;
      case 10:
        $state = 'Cross River';
        break;
      case 11:
        $state = 'Delta';
        break;
      case 12:
        $state = 'Ebonyi';
        break;
      case 13:
        $state = 'Edo';
        break;
      case 14:
        $state = 'Ekiti';
        break;
      case 15:
        $state = 'Enugu';
        break;
      case 16:
        $state = 'Gombe';
        break;
      case 17:
        $state = 'Imo';
        break;
      case 18:
        $state = 'Jigawa';
        break;
      case 19:
        $state = 'Kaduna';
        break;
      case 20:
        $state = 'Kano';
        break;
      case 21:
        $state = 'Katsina';
        break;
      case 22:
        $state = 'Kebbi';
        break;
      case 23:
        $state = 'Kogi';
        break;
      case 24:
        $state = 'Kwara';
        break;
      case 25:
        $state = 'Lagos';
        break;
      case 26:
        $state = 'Nasarawa';
        break;
      case 27:
        $state = 'Niger';
        break;
      case 28:
        $state = 'Ogun';
        break;
      case 29:
        $state = 'Ondo';
        break;
      case 30:
        $state = 'Osun';
        break;
      case 31:
        $state = 'Oyo';
        break;
      case 32:
        $state = 'Plateau';
        break;
      case 33:
        $state = 'Rivers';
        break;
      case 34:
        $state = 'Sokoto';
        break;
      case 35:
        $state = 'Taraba';
        break;
      case 36:
        $state = 'Yobe';
        break;
      case 37:
        $state = 'Zamfara';
   }

   return $state;


 }
