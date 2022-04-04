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
 * @package     Teacher Dashboard
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../../../config.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');

 require_login();
 $PAGE->set_url(new moodle_url('/local/newwaves/moe/school/teacher/teacher_dashboard.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Teacher Dashboard');
 $PAGE->set_heading('Teachers');

 echo $OUTPUT->header();
 echo "<div class='mb-5'><h2><small>[ Teachers Dashboard ]</small></h2></div>";
 $active_menu_item='dashboard';


 include_once($CFG->dirroot.'/local/newwaves/nav/moe_school_teacher_nav.php');


//  // retrieve school information from DB
//  $sql = "SELECT s.name, count(u.id) as schoolcount from {newwaves_schools} s left join {newwaves_schools_users} u on
//                             u.schoolid=s.id where role='teacher' group by s.name";
//  $schools = $DB->get_records_sql($sql);
//  // var_dump($schools);
//  //die;
//
//
//  $chart_data = array();
//
//  $schools_array = array();
//  array_push($schools_array, 'School', 'Count');
//  array_push($chart_data, $schools_array);
//
//  foreach($schools as $row){
//      $schools_array = array();
//      array_push($schools_array, $row->name, 2);
//      array_push($chart_data, $schools_array);
//  }
//
//  $chart_data = json_encode($chart_data);
//   var_dump($chart_data);
//  // var_dump($schools_array);



  ?>

  <div class="row mt-3"><!-- beginning of row //-->
      <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 border"><!-- column 1 //-->

          <?php
          include_once('../../stats/schools_total_teachers.php');
          include_once('../../stats/schools_total_teachers_gender.php');
          ?>

      </div><!-- end of column 1 //-->
      <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
          <h4>Number of Teachers</h4>

          <table class='table table-stripped mt-5 border rounded'>
              <?php
              $sql = "SELECT name, id from {newwaves_schools} ";
              $schoollist = $DB->get_records_sql($sql);
              foreach($schoollist as $row) {
                  $sql = "SELECT * from {newwaves_schools_users} where schoolid = {$row->id} and role='teacher'";
                  $schoolcountid = count($DB->get_records_sql($sql));
                  echo "<tr>";
                  echo " <td class='font-weight:bold;'><strong>{$row->name}</strong></td><td>{$schoolcountid}</td>";
                  echo "</td>";
                  echo "</tr>";
              }
              ?>

          </table>


      </div><!-- end of column 2 //-->
  </div><!-- end of row //-->


  <?php
  echo $OUTPUT->footer();

  ?>
