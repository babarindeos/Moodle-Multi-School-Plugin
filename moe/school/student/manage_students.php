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
 * @package     manage_students
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../../../config.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');

 global $DB, $USER;

 require_login();
 $PAGE->set_url(new moodle_url('/local/newwaves/moe/school/student/manage_students.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Manage Students');
 $PAGE->set_heading('Students');

 echo $OUTPUT->header();
 echo "<div class='mb-5'><h2><small>[ Manage Students ]</small></h2></div>";



 include_once($CFG->dirroot.'/local/newwaves/nav/moe_school_student_nav.php');

 // retrieve Teachers
 $sql = "SELECT u.id, u.schoolid, s.name as schoolname, u.uuid, u.surname, u.firstname, u.middlename, u.gender, u.email, u.phone, u.role
        from {newwaves_schools_users} u left join {newwaves_schools} s on u.schoolid=s.id where u.role='student' order by u.id desc";

 $students = $DB->get_records_sql($sql);

 $sn = 1;

 echo "<table class='table table-stripped border' id='tblData'>";
 echo "<thead>";
 echo "<tr class='font-weight-bold' >";
      echo "<th class='py-3'>SN</th><th>School</th><th>Admission No.</th><th>Names</th><th>Phone</th><th>Email</th><th class='text-center'>Action</th></tr>";
 echo "</thead>";
 echo "<tbody>";
    $schoolid = '';
    foreach($students as $student){
        $schoolid = $student->schoolid;
        //$schoolType = schoolTypes($school->type);

        $viewHref = "window.location='".$CFG->wwwroot."/local/newwaves/moe/school/student/view_student.php?q=".mask($student->schoolid)."&u=".mask($student->id)."'";



        $editHref = "window.location='".$CFG->wwwroot."/local/newwaves/moe/school/edit_student.php?q=".mask($student->schoolid)."&u=".mask($student->id)."'";

        $deleteHref = "window.location='delete_teacher.php?q=".mask($student->id)."'";
        $viewBtn = "<button onclick={$viewHref} class='btn btn-sm btn-success rounded'>VIEW</button>";
        $editBtn = "<button onclick={$editHref} class='btn btn-sm btn-warning rounded'>EDIT</button>";
        $deleteBtn = "<button id='btn{$student->id}' class='btn btn-sm btn-danger rounded btn-delete' data-toggle='modal' data-target='#deleteModalCenter'>DELETE</button>";
        echo "<tr>";
            echo "<td class='text-center'>{$sn}.</td>";
            echo "<td>{$student->schoolname}</td>";
            echo "<td>{$student->uuid}</td>";
            echo "<td>{$student->surname} {$student->firstname}</td>";
            echo "<td>{$student->phone}</td>";
            echo "<td>{$student->email}</td>";
            echo "<td class='text-center'>{$viewBtn} {$editBtn} {$deleteBtn}</td>";
        echo "</tr>";
        $sn++;
    }
 echo "</tbody>";
 echo "</table>";










 echo "<input id='select_delete_record' type='hidden' value='' />";
 echo "<input id='school_id' type='hidden' value='{$schoolid}' />";
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/modal_delete.inc.php');
 echo $OUTPUT->footer();


?>
<script>
 $(document).ready(function(){
     $(".btn-delete").on("click", function(){
         var selectedBtnId = $(this).attr('id');
         var userId = $(this).attr('id').replace(/\D/g,'');
         $('#select_delete_record').val(userId);
     });

     $("#btn-delete-modal").on("click", function(){
         var school_id = $("#school_id").val();
         var userId = $("#select_delete_record").val();
         var qcode = generateMask(60);
         var zcode = generateMask(60);
         var page = 'manage_students.php';

         window.location='../student/delete_student.php?q='+qcode+'&uid='+userId+'&z='+zcode+'&sid='+school_id+'&pg='+page+'&j='+qcode;
     });
 });

 function generateMask(length){
     // declare all characters
     const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
     let result = ' ';
     const charactersLength = characters.length;
       for ( let i = 0; i < length; i++ ) {
           result += characters.charAt(Math.floor(Math.random() * charactersLength));
       }
       return result;
 }




</script>
