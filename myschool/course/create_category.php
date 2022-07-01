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
 * @package     create_course_category
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */


require_once(__DIR__ . '/../../../../config.php');

require_once($CFG->dirroot.'/local/newwaves/classes/form/create_course_category.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');
require_once($CFG->dirroot.'/local/newwaves/classes/school.php');
require_once($CFG->dirroot.'/local/newwaves/classes/Coursecategory.php');



global $DB;


$PAGE->set_url(new moodle_url('/local/newwaves/myschool/course/create_category.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Create Course Category');
//$PAGE->set_heading('Course Cartegories');

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolcoursecreatecategory', 'local_newwaves'), new moodle_url('/local/newwaves/myschool/course/create_category.php'));


$mform = new createCourseCategory();


if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', 'No Course Category is created. You cancelled the operation.');

}else if($fromform = $mform->get_data()){

          //get last category id
          $getLastId = Coursecategory::getLastCategoryId($DB);


          // write to moodle_course_categories
          $mdlcoursecat = new stdClass();
          $mdlcoursecat->name = $fromform->name;
          $mdlcoursecat->idnumber = $fromform->code;
          $mdlcoursecat->description = $fromform->summary;
          $mdlcoursecat->descriptionformat = 1;
          $mdlcoursecat->parent = 0;
          $mdlcoursecat->visible = 1;
          $mdlcoursecat->visibleold = 1;
          $mdlcoursecat->timemodified = time();
          $mdlcoursecat->depth = 1;
          $mdlcoursecat->path = $getLastId + 1;

          $DB->insert_record("course_categories", $mdlcoursecat);


          //get mdl_course_categories_id
          $getMdlCategoryId = Coursecategory::getMoodleCourseCategoryId($DB, $fromform->name, $fromform->code);



          $recordtoinsert = new stdClass();
          $recordtoinsert->name = $fromform->name;
          $recordtoinsert->code = $fromform->code;
          $recordtoinsert->summary = $fromform->summary;
          $recordtoinsert->creator_id = $fromform->creator_id;
          $recordtoinsert->school_id = $fromform->school_id;
          $recordtoinsert->mdl_course_cat_id = $getMdlCategoryId;
          $recordtoinsert->timecreated = time();
          $recordtoinsert->timemodified = time();

          $DB->insert_record('newwaves_course_categories', $recordtoinsert);





    $schoolinfo_href = "create_category.php?q=".mask($fromform->school_id);
    $newCategory = $fromform->name;
    redirect($CFG->wwwroot."/local/newwaves/myschool/course/create_category.php?q={$schoolinfo_href}", "A Category with the name <strong>{$newCategory}</strong> has been successfully created.");


}else {

    //************************* Check page accessibility *********************************************************
            // Check and Get School Id from URL if set
            if (!isset($_GET['q']) || $_GET['q']==''){
                // URL ID not set redirect from page
                redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Create Category page");
            }else{
                // URL ID set collect ID into page variable and continue
                $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
                $_GET_URL_school_id = $_GET_URL_school_id[1];
            }

            // Check user accessibility status using role
            if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
                // if Session Variable Schoolid is not set, redirect from page
                redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Create Category page");
            }


            // check if the page URL and the session variable are not the same
            if($_SESSION['schoolid']!=$_GET_URL_school_id){
                redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Create Category page");
            }

    //************************ End of Check page accessibility *****************************************************


}


//get MySchool Name
$getMySchoolName = School::getName($DB, $_SESSION['schoolid']);

echo $OUTPUT->header();
echo "<h2>{$getMySchoolName}<br/><div class='mt-2'><small>Create Category</small></div></h2>";



?>

<hr/>




<div class="row border rounded py-4 ml-1 mr-1">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php

              $data_packet = array("school_id"=>$_GET_URL_school_id, "creator_id"=>$USER->id);

              $mform->set_data($data_packet);
              $mform->display();

        ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->



<div class="row border rounded py-4 mt-2 ml-1 mr-1">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h4>Course Categories</h4>

          <table class="table table-striped" id="tblData">
              <thead>
                  <tr>
                      <th>#</th><th>Name</th><th>Shortname</th><th>Summary</th><th class='text-center'>Actions</th>
                  </tr>
              </thead>
              <tbody class="tblBody">

                <?php

                    $courseCategory = new Coursecategory();
                    $getCourseCategory = $courseCategory->getCategoriesBySchool($DB, $_GET_URL_school_id);



                    $sn = 1;
                    foreach($getCourseCategory as $row){
                        $edit_href= "window.location='edit_category.php?q=".mask($_GET_URL_school_id)."&c=".mask($row->id)."&m=".mask($row->mdl_course_cat_id)."'";//
                        $btn_edit_href = "<button title='Edit Category' onClick={$edit_href} class='btn btn-warning btn-sm rounded'><i class='far fa-edit'></i> <small>Edit</small> </button>";

                        $delete_href= "window.location='delete_category.php?q=".mask($_GET_URL_school_id)."&c=".mask($row->id)."&m=".mask($row->mdl_course_cat_id)."'";//
                        $btn_delete_href = "<button title='Delete Category' onClick={$delete_href} class='btn btn-danger btn-sm rounded'><i class='far fa-trash-alt'></i><small> Delete</small> </button>";

                        echo "<tr>";
                          echo "<td>{$sn}.</td>";
                          echo "<td>{$row->name}</td>";
                          echo "<td>{$row->code}</td>";
                          echo "<td>{$row->summary}</td>";
                          echo "<td class='text-center' width='25%'>{$btn_edit_href} {$btn_delete_href}</td>";
                        echo "</tr>";
                        $sn++;
                    }
                ?>

              </tbody>
          </table>

    </div>
</div>






<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
