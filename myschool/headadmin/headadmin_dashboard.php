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
 * @package     headadmin_dashboard
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../../config.php');
 require_login();
 $PAGE->set_url(new moodle_url('/local/newwaves/myschool/headadmin/headadmin_dashboard.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Head Admin Dashboard');

 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');

 $PAGE->navbar->ignore_active();
 $PAGE->navbar->add(get_string('myschoolheadadmindashboard', 'local_newwaves'), new moodle_url('/local/newwaves/myschool/headadmin/headadmin_dashboard.php'));

 echo $OUTPUT->header();
 echo "<div class='mb-5'><h2>Head Admin Dashboard</h2></div>";


 // row 1
 echo "<div class='row px-3'>";

     // col 1
     $manage_schooladmin = "manage_schooladmin.php?q=".mask($_SESSION['schoolid']);
     $manage_course = "../course/manage_course.php?q=".mask($_SESSION['schoolid']);

     echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 px-1 py-1 text-center'
           style='border:1px solid #f1f1f1;background-color:#E67E22;color:#ffffff;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
           href='{$manage_schooladmin}' title='Manage School Admins'>";
               echo "<h2 class='mt-2'>School Admins</h2>";
     echo "</a></div>";
     // end of col 1

    // col 1
    echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 px-1 py-1 text-center'
          style='border:1px solid #f1f1f1;background-color:#3498DB;color:#ffffff;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
          href='manage_schooladmin.php' title='Manage School Admins'>";
              echo "<h2 class='mt-2'>Teachers</h2>";
    echo "</a></div>";
    // end of col 1


    // col 2
    echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 px-1 py-1 text-center'
                    style='border:1px solid #f1f1f1;background-color:#F1C40F ;color:#ffffff;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
                    href='manage_students.php' title='Manage Students'>";
                        echo "<h2 class='mt-2'>Students</h2>";
    echo "</a></div>";
    // end of col 2

    // col 3
    echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 px-1 py-1 text-center'
                    style='border:1px solid #f1f1f1;background-color:#2ECC71;color:#ffffff;border-radius:10px;'><a class='px-5 py-5' style='color:#ffffff;'
                    href='$manage_course' title='Manage Courses'>";
                        echo "<h2 class='mt-2'>Courses</h2>";
    echo "</a></div>";
    // end of col 3

 echo "</div>";

 // end of row 1




 echo $OUTPUT->footer();
