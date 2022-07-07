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
 * @package     manage_gradebooks
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



 require_once(__DIR__.'/../../../../config.php');
 require_login();

 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/school.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/Coursecategory.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/gradebook.php');


//************************* Check page accessibility *********************************************************
// Check and Get School Id from URL if set
if (!isset($_GET['q']) || $_GET['q']==''){
    // URL ID not set redirect from page
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unauthorised to access the Gradebooks");
}else{
    // URL ID set collect ID into page variable and continue
    $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];
}

// Check user accessibility status using role
if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
    // if Session Variable Schoolid is not set, redirect from page
    redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unauthorised to access the Gradebooks");
}


// check if the page URL and the session variable are not the same
if($_SESSION['schoolid']!=$_GET_URL_school_id){
    redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unauthorised to access the Gradebooks");
}

//************************ End of Check page accessibility *****************************************************


// global database handler
global $DB;


// set page
$PAGE->set_url(new moodle_url('/local/newwaves/myschool/gradebook/books.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Gradebooks');
//$PAGE->set_heading('Course Information');

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolgradebookbooks','local_newwaves'), new moodle_url('/local/newwaves/myschool/gradebook/books.php'));


//get MySchool Name
$getMySchoolName = School::getName($DB, $_SESSION['schoolid']);


//get gradebooks created for a particular school
///$sql = "SELECT * FROM {newwaves_course} order by id desc";
// $course = $DB->get_records_sql($sql);

$gradebookItems = new Gradebook();
$getGradebookItems = $gradebookItems->getGradeBooksBySchoolId($DB, $_GET_URL_school_id);



//$schools = $DB->get_records('newwaves_schools');
//var_dump($schools);


echo $OUTPUT->header();
echo "<h2>{$getMySchoolName}<br/><small>Gradebooks (".number_format(count(($getGradebookItems))).")</small></h2>";






 ?>

 <hr/>



 <?php


  $sn = 1;
  echo "<div class='table-responsive'>";
  echo "<table class='table table-stripped border' id='tblData'>";
  echo "<thead>";
  echo "<tr class='font-weight-bold' >";
       echo "<th class='py-3'>SN</th><th>Course</th><th>Assessment</th><th>Type</th><th class='text-center'>Grade Max</th><th class='text-center'>Grade Pass</th><th>Teacher</th><th>Date Created</th></tr>";
  echo "</thead>";
  echo "<tbody>";
        $category = new Coursecategory();
        foreach($getGradebookItems as $row){
            $course_id = $row->courseid;
            $mdl_course_id = $row->courseid;

          //  $getCategory = $category->getCategoryById($DB, $row->categoryid);

            $categoryName = '';
            $itemModule = ucwords($row->itemmodule);
            $gradeMax = number_format($row->grademax);
            $gradeMin = number_format($row->grademin);

            $fullnameLink = "book_details.php?q=".mask($_GET_URL_school_id)."&c=".mask($row->courseid)."&item=".mask($row->id);
            $courseName = "<a title='See Gradebook details' style='color:blue; text-decoration:underline;' href={$fullnameLink}>{$row->full_name}</a>";

            echo "<tr>";
                echo "<td class='text-center'>{$sn}.</td>";
//                echo "<td>{$row->uuid}</td>";
                echo "<td class='text-left'>{$courseName}<br/><small>{$categoryName}</small></td>";
                echo "<td class='text-left'>{$row->itemname}</td>";
                echo "<td class='text-left'>{$itemModule}</td>";
                echo "<td class='text-center'>{$gradeMax}</td>";
                echo "<td class='text-center'>{$gradeMin}</td>";
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
