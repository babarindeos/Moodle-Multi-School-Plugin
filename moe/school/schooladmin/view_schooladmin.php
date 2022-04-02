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
 * @package     view_schooladmin
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/classes/schooladmin.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/acadclass.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');


 $PAGE->set_url(new moodle_url('/local/newwaves/moe/school/teacher/view_schooladmin.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('School Admin Profile');
 $PAGE->set_heading('School Admin');

 global $DB, $USER;

 // Get School Id
 if (!isset($_GET['q']) || $_GET['q']==''){
     redirect($CFG->wwwroot.'/local/newwaves/moe/school/manage_schools.php');
 }else{

    $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];
 }


// Student id
if (!isset($_GET['u']) || $_GET['u']==''){
    redirect($CFG->wwwroot.'/local/newwaves/moe/school/manage_schools.php');
}else{
    $_GET_URL_schooladmin_id = explode("-",htmlspecialchars(strip_tags($_GET['u'])));
    $_GET_URL_schooladmin_id = $_GET_URL_schooladmin_id[1];
}

// retrieve user data
 $schoolAdmin = new SchoolAdmin();
 $getSchoolAdmin = $schoolAdmin->getSchooladminProfileById($DB, $_GET_URL_schooladmin_id);

 // read teacherData object
 foreach($getSchoolAdmin as $row){
   $surname = $row->surname;
   $firstname = $row->firstname;
   $middlename = $row->middlename;
   $gender = $row->gender;
   $email = $row->email;
   $phone = $row->phone;
   $school = $row->name;

 }


 $user_avatar_small = $CFG->wwwroot.'/local/newwaves/assets/images/user_avatar_small.png';




 echo $OUTPUT->header();
 echo "<div class='mb-1'><h2><small> [ School Admin Profile ]</small></h2></div>";

 include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');


?>
<div class="container">
    <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <img src="<?php echo $user_avatar_small ?>"  />

          </div>
          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                  <div class='text-right'>
                          <button class='btn btn-danger btn-sm rounded'>Suspend</button>
                  </div>

                  <table class="table table-stripped table-hover">                      
                      <tr><td class="font-weight-bold">Surname</td><td><?php echo $surname; ?></td></tr>
                      <tr><td class="font-weight-bold">Firstname</td><td><?php echo $firstname; ?></td></tr>
                      <tr><td class="font-weight-bold">Middlename</td><td><?php echo $middlename; ?></td></tr>
                      <tr><td class="font-weight-bold">Gender</td><td><?php echo gender($gender); ?></td></tr>
                      <tr><td class="font-weight-bold">School</td><td><?php echo $school; ?></td></tr>




                  </table>
          </div>
    </div>


</div>








<?php
  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
