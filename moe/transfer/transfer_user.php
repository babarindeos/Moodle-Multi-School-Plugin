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
 * @package     transfer user
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



 require_once(__DIR__.'/../../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/form/search_transfer_user.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/transfer.php');



  global $DB;

  $PAGE->set_url(new moodle_url('/local/newwaves/moe/transfer/initiate_transfer.php'));
  $PAGE->set_context(\context_system::instance());
  $PAGE->set_title('Transfer request');
  $PAGE->set_heading('Transfer');

  echo $OUTPUT->header();
  echo "<h2><small>[ Transfer Request ]</small></h2>";
  $active_menu_item = "";


  // navigation  bar
  include_once($CFG->dirroot.'/local/newwaves/nav/moe_transfer_nav.php');

  echo "<div class='container-fluid'>";
      echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";

      echo "<table class='table table-stripped border' id='tblData'>";
      echo "<thead>";
      echo "<tr class='font-weight-bold' >";
           echo "<th class='py-3'>SN</th><th>Applying School</th><th>Applicant</th><th>Transfer School</th><th>Document</th><th>Date</th><th class='text-center'>Action</th></tr>";
      echo "</thead>";
      echo "<tbody>";

             echo "<tr>";
                 echo "<td class='text-center'></td>";
                 echo "<td></td>";
                 echo "<td></td>";
                 echo "<td></td>";
                 echo "<td></td>";
                 echo "<td></td>";
                 echo "<td class='text-center'></td>";
             echo "</tr>";

      echo "</tbody>";
      echo "</table>";



      echo "</div>";
  echo "</div>";

  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
