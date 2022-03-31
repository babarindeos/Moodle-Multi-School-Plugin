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

 echo $OUTPUT->header();
 echo "<div class='mb-5'><h2>Teacher Dashboard</h2></div>";
 $active_menu_item='dashboard';


 include_once($CFG->dirroot.'/local/newwaves/nav/moe_school_teacher_nav.php');









 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
 echo $OUTPUT->footer();
