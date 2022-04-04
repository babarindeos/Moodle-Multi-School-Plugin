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
 * @package     transfer_history
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

  $PAGE->set_url(new moodle_url('/local/newwaves/moe/transfer/transfer_history.php'));
  $PAGE->set_context(\context_system::instance());
  $PAGE->set_title('Transfer history');
  $PAGE->set_heading('Transfer');

  echo $OUTPUT->header();
  echo "<h2><small>[ Transfer History ]</small></h2>";
  $active_menu_item = "";

  $sql = "SELECT t.id, t.mdl_userid, t.nes_userid, nw.surname, nw.firstname, nw.middlename, sf.name as school_from, st.name as school_to, t.purpose, t.document, t.creator, t.timecreated, t.timemodified
          from {newwaves_transfers} t inner join {newwaves_schools_users} nw on t.nes_userid=nw.id left join {newwaves_schools} sf
          on t.school_from = sf.id left join {newwaves_schools} st on t.school_to = st.id  order by t.id desc";
  $getTransfers = $DB->get_records_sql($sql);
  // navigation  bar
  include_once($CFG->dirroot.'/local/newwaves/nav/moe_transfer_nav.php');

  echo "<div class='container-fluid'>";
      echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";

      echo "<table class='table table-stripped border' id='tblData'>";
      echo "<thead>";
      echo "<tr class='font-weight-bold' >";
           echo "<th class='py-3'>SN</th><th>From School</th><th>Candidate</th><th>To School</th><th>Document</th><th>Date</th><th class='text-center'>Action</th></tr>";
      echo "</thead>";
      echo "<tbody>";

      $sn = 1;
      foreach($getTransfers as $row){

             echo "<tr>";
                 echo "<td class='text-center'>{$sn}</td>";
                 echo "<td>{$row->school_from}</td>";
                 echo "<td>{$row->surname} {$row->firstname} {$row->middlename}</td>";
                 echo "<td>{$row->school_to}</td>";
                 echo "<td></td>";
                 echo "<td></td>";
                 echo "<td class='text-center'></td>";
             echo "</tr>";
            $sn++;
      }

      echo "</tbody>";
      echo "</table>";



      echo "</div>";
  echo "</div>";

  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
