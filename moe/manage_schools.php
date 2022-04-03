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
 * @package     manage_schools
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */


 require_once(__DIR__.'/../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/state.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');



 global $DB;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/manage_schools.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Manage Schools');
 $PAGE->set_heading('Manage Schools');

 echo $OUTPUT->header();


 $pageTitle = pageHeader("Manage Schools");
 //echo $pageTitle;

 // nav bar
 include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');
?>



<?php
 $sql = "SELECT id, name, type, state, lga, address, creator FROM {newwaves_schools} order by id desc";

 $schools = $DB->get_records_sql($sql);

 //$schools = $DB->get_records('newwaves_schools');
 //var_dump($schools);

 $sn = 1;

 echo "<table class='table table-stripped border' id='tblData'>";
 echo "<thead>";
 echo "<tr class='font-weight-bold' >";
      echo "<th class='py-3'>SN</th><th>School Name</th><th>School Type</th><th>State</th><th>LGA</th><th>Address</th><th class='text-center'>Action</th></tr>";
 echo "</thead>";
 echo "<tbody>";

    foreach($schools as $school){
        $schoolType = schoolTypes($school->type);
        $state = state($school->state);

        $viewHref = "window.location='school/schoolinfo.php?q=".mask($school->id)."'";
        $editHref = "window.location='school/edit_schoolinfo.php?q=".mask($school->id)."'";
        $viewBtn = "<button onclick={$viewHref} class='btn btn-sm btn-success rounded'>VIEW</button>";
        $editBtn = "<button onclick={$editHref} class='btn btn-sm btn-warning rounded'>EDIT</button>";
        echo "<tr>";
            echo "<td class='text-center'>{$sn}.</td>";
            echo "<td>{$school->name}</td>";
            echo "<td>{$schoolType}</td>";
            echo "<td>{$state}</td>";
            echo "<td>{$school->lga}</td>";
            echo "<td>{$school->address}</td>";
            echo "<td class='text-center'>{$viewBtn} {$editBtn}</td>";
        echo "</tr>";
        $sn++;
    }
 echo "</tbody>";
 echo "</table>";



 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
 echo $OUTPUT->footer();
