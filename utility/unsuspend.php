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
 * @package     suspend
 * @author      Seyibab
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/classes/student.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/acadclass.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');

 //
 // if (!isset($_SERVER['HTTP_REFERER'])){
 //      redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'Unauthorised access.');
 // }


 $PAGE->set_url(new moodle_url('/local/newwaves/utility/suspend.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Utility');
 $PAGE->set_heading('Utility');

 global $DB, $USER;

 // Get School Id
 if (!isset($_GET['q']) || $_GET['q']==''){
     redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
 }else{
   $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
   $_GET_URL_school_id = $_GET_URL_school_id[1];
 }

 // Get Newwaves User Id
 if (!isset($_GET['h']) || $_GET['h']==''){
     redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
 }else{
   $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['h'])));
   $_GET_URL_user_id = $_GET_URL_user_id[1];
 }


 // Get Newwaves User Id
 if (!isset($_GET['pg']) || $_GET['pg']==''){
     redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
 }else{
   $_GET_URL_page = explode("-",htmlspecialchars(strip_tags($_GET['pg'])));
   $_GET_URL_page = $_GET_URL_page[1];
 }

 // Get Newwaves User Id
 if (!isset($_GET['mu']) || $_GET['mu']==''){
     redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
 }else{
   $_GET_URL_mu_id = explode("-",htmlspecialchars(strip_tags($_GET['mu'])));
   $_GET_URL_mu_id = $_GET_URL_mu_id[1];
 }

 //echo $_GET_URL_mu_id;


 $transaction = $DB->start_delegated_transaction();
 //update
 $recordtoupdate = new stdClass();
 $recordtoupdate->id =  $_GET_URL_mu_id;
 $recordtoupdate->suspended = 0;

 $DB->update_record('user', $recordtoupdate);

 $DB->commit_delegated_transaction($transaction);

 $page = '';


 if ($_GET_URL_page=='view_headadmin.php'){
   $page = "headadmin/view_headadmin.php?q=".mask($_GET_URL_school_id)."&u=".mask($_GET_URL_user_id);
 }else if ($_GET_URL_page=='view_schooladmin.php'){
   $page = "schooladmin/view_schooladmin.php?q=".mask($_GET_URL_school_id)."&u=".mask($_GET_URL_user_id);
 }else if ($_GET_URL_page=='view_teacher.php'){
   $page = "teacher/view_teacher.php?q=".mask($_GET_URL_school_id)."&u=".mask($_GET_URL_user_id);
 }if ($_GET_URL_page=='view_student.php'){
   $page = "student/view_student.php?q=".mask($_GET_URL_school_id)."&u=".mask($_GET_URL_user_id);
 }

 redirect($CFG->wwwroot."/local/newwaves/moe/school/".$page, 'User has been suspended.');
