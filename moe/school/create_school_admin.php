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
 * @package     create_school_admin
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../../config.php');

require_login();
 require_once($CFG->dirroot.'/local/newwaves/classes/form/create_school_admin.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');
 require_once($CFG->dirroot.'/local/newwaves/cpanelapi/create_cpanel_email.php');



 global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/moe/school/schoolinfo_schooladmin.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Create School Admin');


$mform = new createSchoolAdmin();


if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'No School Admin is created. You cancelled the operation.');

}else if($fromform = $mform->get_data()){

    $auth = new Auth();
    $isEmailExist = $auth->isEmailExist($DB, $fromform->email);

    //unique email validation
    if ($isEmailExist>0){
            $create_school_admin_href = "create_school_admin.php?q=".mask($fromform->school_id);
            $email = $fromform->email;
            redirect($CFG->wwwroot."/local/newwaves/moe/school/{$create_school_admin_href}", "<strong>[Duplicate Email Error]</strong> A user record with that email <strong>{$email}</strong> already exist.");
    }else{
            $title = title($fromform->title);
            $gender = gender($fromform->gender);

            $recordtoinsert = new stdClass();
            $recordtoinsert->schoolid = $fromform->school_id;
            $recordtoinsert->title = $title;
            $recordtoinsert->surname = $fromform->surname;
            $recordtoinsert->firstname = $fromform->firstname;
            $recordtoinsert->middlename = $fromform->middlename;
            $recordtoinsert->gender = $gender;
            $recordtoinsert->email = $fromform->email;
            $recordtoinsert->phone = $fromform->phone;
            $recordtoinsert->role = "schooladmin";
            $recordtoinsert->status = "active";
            $recordtoinsert->creator = $USER->id;
            $recordtoinsert->timecreated = time();
            $recordtoinsert->timemodified = time();

            $DB->insert_record('newwaves_schools_users', $recordtoinsert);

            // write to moodle_users
            $createlogin = new stdClass();
            $createlogin->auth = 'manual';
            $createlogin->confirmed = '1';
            $createlogin->policyagreed = '0';
            $createlogin->deleted = '0';
            $createlogin->suspended = '0';
            $createlogin->mnethostid = '1';
            $createlogin->username = $fromform->email;
            $createlogin->password = md5('12345678');
            $createlogin->firstname = $fromform->firstname;
            $createlogin->lastname = $fromform->surname;
            $createlogin->email = $fromform->email;

            $DB->insert_record("user", $createlogin);

            //------------------------Get moodle user id -------------------------------------------------
            $auth = new Auth();
            $getMoodleUserId = $auth->getMoodleUserId($DB, $fromform->email);

            //------------------------Get newwaves user id -------------------------------------------------
            $auth = new Auth();
            $getNESUserId = $auth->getNESUserId($DB, $fromform->email);

            //----------------------- Update mdl_user_id on newwaves table -------------------------------
            $update_newwaves_user = new stdClass();
            $update_newwaves_user->id = $getNESUserId;
            $update_newwaves_user->mdl_userid = $getMoodleUserId;

            $DB->update_record('newwaves_schools_users', $update_newwaves_user);


            $schoolinfo_href = "manage_schooladmin.php?q=".mask($fromform->school_id);
            $newHeadAdmin = $fromform->surname.' '.$fromform->firstname;
            redirect($CFG->wwwroot."/local/newwaves/moe/school/{$schoolinfo_href}", "A School Admin with the name <strong>{$newHeadAdmin}</strong> has been successfully created.");

    }

//    $firstN=substr($fromform->firstname, 0,2);
//    $emailN=$fromform->surname.$firstN;
//
//    createEmail($emailN, md5('12345678'));


}else{
    // Get School Id if not redirect page
    if (!isset($_GET['q']) || $_GET['q']==''){
        redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'Sorry, the page is not fully formed with the required information.');
    }
    $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];

}


//------------------------------------------------------------------------------



echo $OUTPUT->header();
echo "<h2>School Information <small>[ School Admin ]</small></h2>";
$active_menu_item = "schooladmins";


// nav bar
include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');






// retrieve school information from DB
$sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
$school =  $DB->get_records_sql($sql);

foreach($school as $row){
    $school_name = $row->name;
    $school_type = schoolTypes($row->type);
    $lga = $row->lga;
    $address = $row->address;
    echo "<h4>{$school_name}</h4>";
    echo "<div>{$address}, {$lga}</div>";
}


?>

<hr/>
<!-- Navigation //-->
<?php
include_once($CFG->dirroot.'/local/newwaves/nav/moe_school_nav.php');
?>
<!-- end of navigation //-->

<div class="row d-flex justify-content-right mt-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h4 class='font-weight-normal'>Create School Admin</h4>
    </div>
</div>


<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php



        // Get School Id if not redirect page
        if (!isset($_GET['q']) || $_GET['q']==''){
            redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'Sorry, the page is not fully formed with the required information.');
        }else{
            $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
            $_GET_URL_school_id = $_GET_URL_school_id[1];
        }

        $data_packet = array("school_id"=>$_GET_URL_school_id);

        $mform->set_data($data_packet);
        $mform->display();



        ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->





<?php
   require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
   echo $OUTPUT->footer();
 ?>
