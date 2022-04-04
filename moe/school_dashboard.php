<?php
// This file is part of Moodle Integrator Plugin
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
 * @package     School Dashboard
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



 require_once(__DIR__.'/../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/convertType.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 $PAGE->set_url(new moodle_url('/local/newwaves/moe/school_dashboard.php'));

 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('School Dashboard');
 $PAGE->set_heading('School Dashboard');

 echo $OUTPUT->header();
 //echo "<div class='mb-5'><h2>School Dashboard</h2></div>";

 include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');




 ?>




 <div class="row mt-3"><!-- beginning of row //-->
 <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 border"><!-- column 1 //-->

     <h4>Schools Stats</h4>

          <?php

                include_once('stats/schools_total_users.php');
                include_once('stats/school_types.php');
                include_once('stats/schools_total_headadmin.php');
                include_once('stats/schools_total_schooladmin.php');
                include_once('stats/schools_total_teachers.php');

                include_once('stats/schools_total_teachers_gender.php');
                include_once('stats/schools_total_students.php');
                include_once('stats/schools_total_students_gender.php');

           ?>

 </div><!-- end of column 1 //-->

 <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
    <h4>Number of Users</h4>

    <table class='table table-stripped mt-5 border rounded'>
        <tr>
            <td class='font-weight:bold;'><strong>Head Admins</strong></td><td><?php //echo $headadmincount; ?></td>
        </td>
        <tr>
            <td class='font-weight:bold;'><strong>School Admins</strong></td><td><?php //echo $headadmincount; ?></td>
        </td>

        <tr>
            <td class='font-weight:bold;'><strong>Teachers</strong></td><td><?php //echo $teachercount; ?></td>
        </td>

        <tr>
            <td class='font-weight:bold;'><strong>Students</strong></td><td><?php //echo $studentcount; ?></td>
        </td>

    </table>


 </div><!-- end of column 2 //-->
 </div><!-- end of row //-->



<?php
 echo $OUTPUT->footer();

?>
