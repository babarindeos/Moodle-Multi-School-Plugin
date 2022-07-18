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
 * @package     reportsheet_studentslist
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



 require_once(__DIR__.'/../../../../config.php');
 require_login();

 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/acadclass.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/school.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/Coursecategory.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/gradebook.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/student.php');


//************************* Check page accessibility *********************************************************
// Check and Get School Id from URL if set
if (!isset($_GET['q']) || $_GET['q']==''){
    // URL ID not set redirect from page
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unauthorised to access the ReportSheet");
}else{
    // URL ID set collect ID into page variable and continue
    $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];
}

// Check user accessibility status using role
if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
    // if Session Variable Schoolid is not set, redirect from page
    redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unauthorised to access the ReportSheet");
}


// check if the page URL and the session variable are not the same
if($_SESSION['schoolid']!=$_GET_URL_school_id){
    redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unauthorised to access the ReportSheet");
}

//************************ End of Check page accessibility *****************************************************


// global database handler
global $DB;


// set page
$PAGE->set_url(new moodle_url('/local/newwaves/myschool/gradebook/books.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Students Report Sheets');
//$PAGE->set_heading('Course Information');

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolreportsheetstudentslist','local_newwaves'), new moodle_url('/local/newwaves/myschool/reportsheet/studentslist.php'));


//get MySchool Name
$getMySchoolName = School::getName($DB, $_SESSION['schoolid']);


//get records of student in $_SESSION['schoolid'] or $_GET_URL_school_id
$student = new Student();
$getStudentsList = $student->getStudentsProfileBySchoolId($DB, $_SESSION['schoolid']);


echo $OUTPUT->header();
echo "<h2>{$getMySchoolName}<br/><small>Report Sheets - Students (".number_format(count(($getStudentsList))).")</small></h2>";






 ?>

 <hr/>



 <?php


  $sn = 1;
  echo "<div class='table-responsive'>";
  echo "<table class='table table-stripped border' id='tblData'>";
  echo "<thead>";
  echo "<tr class='font-weight-bold' >";
       echo "<th class='py-3 text-center'>SN</th><th>Admission No.</th><th>Fullname</th></th><th>Class</th></tr>";
  echo "</thead>";
  echo "<tbody id='tblBody'>";
        $category = new Coursecategory();
        foreach($getStudentsList as $row){
            $student_nw_id = $row->id;
            $student_mdl_id = $row->mdl_userid;
            $surname = ucwords($row->surname);
            $firstname = $row->firstname;
            $middlename = $row->middlename;
            $admission_no = $row->uuid;
            $class_id = acadclass($row->class);
            $fullname = '<strong>'.$surname.'</strong> '.$firstname.' '.$middlename;
            $fullnameHref = "reportsheet.php?sid=".mask($student_nw_id)."&mdl=".mask($student_mdl_id)."&schoolid=".mask($_GET_URL_school_id);
            $fullnameLink = "<a style='text-decoration:underline; color:blue;' href={$fullnameHref}>{$fullname}</a>";


            echo "<tr>";
                echo "<td class='text-center'>{$sn}.</td>";
                echo "<td>{$admission_no}</td>";
                echo "<td class='text-left'>{$fullnameLink}</td>";
                echo "<td class=''>{$class_id}</td>";

                echo "<td></td>";//                echo "<td class='text-left'>{$statusPane}</td>";
                echo "<td class='text-right'></td>";
            echo "</tr>";

            $sn++;
        }
  echo "</tbody>";
  echo "</table>";
  echo "</div>";



  require_once($CFG->dirroot.'/local/newwaves/includes/modal_delete.inc.php');
  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
?>


 <?php
  $page = "manage_course.php";

  echo "<input id='select_delete_record' type='hidden' value='' />";
  echo "<input id='school_id' type='hidden' value='{$_GET_URL_school_id}' />";
  echo "<input id='page' type='hidden' value='{$page}' />";
  require_once($CFG->dirroot.'/local/newwaves/includes/modal_delete.inc.php');
  //require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  //require_once($CFG->dirroot.'/local/newwaves/lib/mask.js');
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
          var courseId = $("#select_delete_record").val();
          var qcode = generateMask(60);
          var zcode = generateMask(60);
          var page = 'manage_students.php';

          window.location='delete_course.php?q='+qcode+'&cid='+courseId+'&z='+zcode+'&sid='+school_id+'&pg='+page+'&j='+qcode;
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
