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
     case 0:
        $state = 'Abia';
        break;
     case 1:
        $state = 'Abuja';
        break;
     case 2:
        $state = 'Adamawa';
        break;
      case 3:
        $state = 'Akwa Ibom';
        break;
      case 4:
        $state = 'Anambra';
        break;
      case 5:
        $state = 'Bauchi';
        break;
      case 6:
        $state = 'Bayelsa';
        break;
      case 7:
        $state = 'Benue';
        break;
      case 8:
        $state = 'Borno';
        break;
      case 9:
        $state = 'Cross River';
        break;
      case 10:
        $state = 'Delta';
        break;
      case 11:
        $state = 'Ebonyi';
        break;
      case 12:
        $state = 'Edo';
        break;
      case 13:
        $state = 'Ekiti';
        break;
      case 14:
        $state = 'Enugu';
        break;
      case 15:
        $state = 'Gombe';
        break;
      case 16:
        $state = 'Imo';
        break;
      case 17:
        $state = 'Jigawa';
        break;
      case 18:
        $state = 'Kaduna';
        break;
      case 19:
        $state = 'Kano';
        break;
      case 20:
        $state = 'Katsina';
        break;
      case 21:
        $state = 'Kebbi';
        break;
      case 22:
        $state = 'Kogi';
        break;
      case 23:
        $state = 'Kwara';
        break;
      case 24:
        $state = 'Lagos';
        break;
      case 25:
        $state = 'Nasarawa';
        break;
      case 26:
        $state = 'Niger';
        break;
      case 27:
        $state = 'Ogun';
        break;
      case 28:
        $state = 'Ondo';
        break;
      case 29:
        $state = 'Osun';
        break;
      case 30:
        $state = 'Oyo';
        break;
      case 31:
        $state = 'Plateau';
        break;
      case 32:
        $state = 'Rivers';
        break;
      case 33:
        $state = 'Sokoto';
        break;
      case 34:
        $state = 'Taraba';
        break;
      case 35:
        $state = 'Yobe';
        break;
      case 36:
        $state = 'Zamfara';
   }

   return $state;


 }
