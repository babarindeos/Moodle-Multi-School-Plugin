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


//************************* Check page accessibility *********************************************************
// Check and Get School Id from URL if set
if (!isset($_GET['q']) || $_GET['q']==''){
    // URL ID not set redirect from page
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Manage Courses page");
}else{
    // URL ID set collect ID into page variable and continue
    $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];
}

// Check user accessibility status using role
if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
    // if Session Variable Schoolid is not set, redirect from page
    redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Manage Courses page");
}


// check if the page URL and the session variable are not the same
if($_SESSION['schoolid']!=$_GET_URL_school_id){
    redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Manage Courses page");
}

//************************ End of Check page accessibility *****************************************************


// global database handler
global $DB;


// set page
$PAGE->set_url(new moodle_url('/local/newwaves/schools/manage_course.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Manage Courses');
//$PAGE->set_heading('Course Information');

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolcoursemanagecourse','local_newwaves'), new moodle_url('/local/newwaves/schools/manage_course.php'));


//get MySchool Name
$getMySchoolName = School::getName($DB, $_SESSION['schoolid']);


//get courses created for a particular school
$sql = "SELECT * FROM {newwaves_course} order by id desc";
$course = $DB->get_records_sql($sql);



//$schools = $DB->get_records('newwaves_schools');
//var_dump($schools);


echo $OUTPUT->header();
echo "<h2>{$getMySchoolName}<br/><small>Manage Courses (".number_format(count(($course))).")</small></h2>";






 ?>

 <hr/>

 <div class="row d-flex justify-content-right mt-2 mb-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <?php
                $create_course_href = "create_course.php?q=".mask($_GET_URL_school_id);
                $create_category_href = "create_category.php?q=".mask($_GET_URL_school_id);
          ?>
                <button onClick="window.location='<?php echo $create_category_href; ?>'" class='btn btn-sm btn-success rounded'>
                    <i class="far fa-file-alt"></i> Create Category
                </button>
                <button onClick="window.location='<?php echo $create_course_href; ?>'" class='btn btn-sm btn-primary rounded'>
                    <i class="far fa-file-alt"></i> Create Course
                </button>
    </div>
 </div>


 <?php


  $sn = 1;

  echo "<table class='table table-stripped border' id='tblData'>";
  echo "<thead>";
  echo "<tr class='font-weight-bold' >";
       echo "<th class='py-3'>SN</th><th>Name</th><th>Short code</th><th class='text-center'>Action</th></tr>";
  echo "</thead>";
  echo "<tbody>";
        $category = new Coursecategory();
        foreach($course as $row){
            $course_id = $row->id;
            $mdl_course_id = $row->mdl_course_id;

            $getCategory = $category->getCategoryById($DB, $row->category_id);

            $categoryName = '';
            if (Count($getCategory)){
              foreach($getCategory as $gc){
                  $categoryName = $gc->name;
                  $categoryName = "<span style='border-radius:10px;background-color:lightblue;padding-left:10px; padding-right:10px'><a title='Course Category information' href=''>{$categoryName}</a></span>";
              }
            }



            $assign_href = "window.location='assign_course.php?q=".mask($_GET_URL_school_id)."&c=".mask($course_id)."&m=".mask($mdl_course_id)."'";//
            $edit_href =  "window.location='edit_course.php?q=".mask($_GET_URL_school_id)."&c=".mask($course_id)."&m=".mask($mdl_course_id)."'";
            $enrol_href = "window.location='enrol_students.php?q=".mask($_GET_URL_school_id)."&c=".mask($course_id)."&m=".mask($mdl_course_id)."'";
            $delete_href = "window.location='delete_course.php?q=".mask($_GET_URL_school_id)."&c=".mask($course_id)."&m=".mask($mdl_course_id)."'";

            $btnAssign = "<button title='Assign Course to Teacher' onclick={$assign_href} class='btn btn-success btn-sm rounded' ><i class='fas fa-chalkboard-teacher'></i> <small>Assign course</small></button>";
            $btnEdit = "<button title='Edit Course' onclick={$edit_href} class='btn btn-warning btn-sm rounded' ><i class='far fa-edit'></i> <small>Edit</small></button>";
            $btnEnrol = "<button title='Enrol Student to Course' onclick={$enrol_href} class='btn btn-primary btn-sm rounded' ><i class='fas fa-user-graduate'></i> <small>Enrol</small></button>";
            $btnDelete = "<button id='btn{$mdl_course_id}' title='Delete Course' class='btn btn-danger btn-sm rounded btn-delete' data-toggle='modal' data-target='#deleteModalCenter'><i class='far fa-trash-alt'></i><small> Delete</small> </button>";
            echo "<tr>";
                echo "<td class='text-center'>{$sn}.</td>";
//                echo "<td>{$row->uuid}</td>";
                echo "<td class='text-left'>{$row->full_name}<br/><small>{$categoryName} &nbsp; <a href='#' title='Course information'>Course Details</a></small></td>";
                echo "<td class='text-left'>{$row->short_code}</td>";
//                echo "<td class='text-left'>{$statusPane}</td>";
                echo "<td class='text-right'>{$btnEdit} {$btnDelete} {$btnEnrol} {$btnAssign}  </td>";
            echo "</tr>";

            $sn++;
        }
  echo "</tbody>";
  echo "</table>";



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
