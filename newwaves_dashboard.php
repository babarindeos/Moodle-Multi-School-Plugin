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
 * @package     Newwaves Dashboard
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../config.php');
 require_login();
 $PAGE->set_url(new moodle_url('/local/newwaves/newwaves_dashboard.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Newwaves Learning Management System Administrative Dashboard');

 echo $OUTPUT->header();
 echo "<div class='mb-5'><h2>Newwaves Learning Management System<br/><small>Administrative Dashboard</small>  </h2></div>";


 // container
 echo "<div class='container'>";

 // row 1
 echo "<div class='row px-3'>";

   // col 1
   echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 px-1 py-1 text-center'
         style='border:1px solid #f1f1f1;background-color:#1aD68d;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
         href='moe/ministry_analytics.php' title='Ministries'>";
             echo "<h2 class='mt-2'>Ministries</h2>";
   echo "</a></div>";
   // end of col 1

    // col 1
    echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 px-1 py-1 text-center'
          style='border:1px solid #f1f1f1;background-color:#58D68D;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
          href='moe/school_dashboard.php' title='Schools'>";
              echo "<h2 class='mt-2'>Schools</h2>";
    echo "</a></div>";
    // end of col 1

    // col 2
    echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 px-1 py-1 text-center'
          style='border:1px solid #f1f1f1;background-color:#3498DB;color:#ffffff;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
          href='#' title='Manage Teachers'>";
              echo "<h2 class='mt-2'>Teachers</h2>";
    echo "</a></div>";
    // end of col 2



 echo "</div>";

 // end of row 1


 // row 2
 echo "<div class='row px-3 mt-3'>";
     // col 1
     echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 px-1 py-1 text-center'
           style='border:1px solid #f1f1f1;background-color:#F1C40F ;color:#ffffff;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
           href='#' title='Manage Students'>";
               echo "<h2 class='mt-2'>Students</h2>";
     echo "</a></div>";
     // end of col 1

     // col 2
     echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 py-1 text-center'
           style='border:1px solid #f1f1f1;background-color:#A569BD ;color:#ffffff;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
           href='#' title='Manage Transfers'>";
               echo "<h2 class='mt-2'>Transfers</h2>";
     echo "</div>";
     // end of col 2

     // col 3
     echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4py-1 text-center'
           style='border:1px solid #f1f1f1;background-color:#EB984E;color:#ffffff;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
           href='#' title='Reports'>";
               echo "<h2 class='mt-2'>Reports</h2>";
     echo "</div>";
     // end of col 3

 echo "</div>";
 // end of row 2

 echo "</div>"; // end of container



 echo $OUTPUT->footer();
