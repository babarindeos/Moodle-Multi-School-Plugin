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

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot.'/local/newwaves/classes/form/verify_school_id.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/myschool/teacherselfregistration/preregistration.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Create School Teacher');
$PAGE->set_heading('Teacher');


$mform = new VerifySchoolId();
if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/myschool/teacherselfregistration/preregistration1.php', 'No School found. You cancelled the operation.');

}else if($fromform = $mform->get_data()){
    $regcode = $fromform->enter_school_code;

    // retrieve school information from DB
    $sql = "SELECT * from {newwaves_schools} where regcode='{$regcode}'";
    $school =  $DB->get_records_sql($sql);
    foreach ($school as $row){
        $schoolid = $row->id;
    }

        $schoolinfo_href = "preregistration2.php?q=".mask($schoolid);
        redirect($CFG->wwwroot."/local/newwaves/myschool/teacherselfregistration/{$schoolinfo_href}");
//    }





}
echo $OUTPUT->header();
$active_menu_item = "teachers";


?>

<!-- end of navigation //-->

<div class="row d-flex justify-content-right mt-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h4 class='font-weight-normal'>Verify School teacher</h4>
    </div>
</div>


<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php

        $mform->display();

        ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->






<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
