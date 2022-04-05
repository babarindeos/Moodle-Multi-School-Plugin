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
 * @package     create_school_student
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */


require_once(__DIR__.'/../../../config.php');

require_once($CFG->dirroot.'/local/newwaves/classes/form/uploadpictures.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

global $DB, $USER;



$PAGE->set_url(new moodle_url('/local/newwaves/student_selfregistration/pre_registration.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Create School Student');
$PAGE->set_heading('Student Registration');


$mform = new Uploadpictures();







if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/student_selfregistration/pre_registration1.php', 'No School Student is created. You cancelled the operation.');

}else if($fromform = $mform->get_data()){

    $name = $fromform->userfile;
    $tempfile = '/path/to/photos/' . $name . '.JPG';
    if (file_exists($tempfile)) {
          $usericonid = process_new_icon( context_user::instance( $user->id, MUST_EXIST ), 'user', 'icon', 0, $tempfile );
          if ( $usericonid ) {
                        $DB->set_field( 'user', 'picture', $usericonid, array( 'id' => $USER->id ) );
          }
    }
    die;

    $schoolinfo_href = "preregistration3.php?q=".mask(1);
    $newStudent = $fromform->surname.' '.$fromform->firstname;
    redirect($CFG->wwwroot."/local/newwaves/studentselfregistration/{$schoolinfo_href}", "A Student with the name <strong>{$newStudent}</strong> has been successfully created.");






}else {
    // Get School Id if not redirect page
    if (!isset($_GET['q']) || $_GET['q'] == '') {
        redirect($CFG->wwwroot. '/local/newwaves/studentselfregistration/preregistration1.php', 'Sorry, the page is not fully formed with the required information.');
    }
    $_GET_URL_school_id = explode("-", htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];

}

echo $OUTPUT->header();

$active_menu_item = "students";

// retrieve school information from DB
$sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
$school =  $DB->get_records_sql($sql);

foreach($school as $row){
    $school_name = $row->name;
    $school_type = schoolTypes($row->type);
    $lga = $row->lga;
    $address = $row->address;
    echo "<h4>{$school_name}</h4>";
    echo "<div>{$address}, {$lga}</div>";
}

?>

<hr/>

<!-- end of navigation //-->

<div class="row d-flex justify-content-right mt-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h4 class='font-weight-normal'>Step 3 of 3 - Upload Photograph</h4>
    </div>
</div>


<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php



        // Get School Id if not redirect page
        if (!isset($_GET['q']) || $_GET['q']==''){
            redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'Sorry, the page is not fully formed with the required information.');
        }else{
            $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
            $_GET_URL_school_id = $_GET_URL_school_id[1];
        }

        //$data_packet = array("school_id"=>$_GET_URL_school_id);

        //$mform->set_data($data_packet);
        $avatar = $CFG->wwwroot.'/local/newwaves/assets/images/user_avatar_small.png';
        //echo $avatar;
        ?>

        <!-- Picture upload //-->
                      <div class="form col-xs-12">
                          <label for="file">
                              <div class="card-image">
                                  <img src="<?php echo $avatar; ?>" id='previewImage' class="img-responsive" width="250px"
                                  style='border:2px solid #f1f1f1;border-radius:5px;padding:10px;'>
                              </div>
                              <input type="file" name="file" id="file" style="display:none"/>
                              <div class="btn btn-primary btn-sm" id='btn_mpicture_upload' style="margin-top:10px;border-radius:5px;">
                                  <i class="fa fa-image"></i> Upload Picture
                              </div>

                          </label>
                      </div>
                      <div>

                          <!-- remove uploaded picture //-->
                          <div class="btn btn-sm btn-danger" id='btn_mpicture_remove' style="margin-top:10px;border-radius:5px;display:none">
                                  <i class="fa fa-trash"></i> Remove Picture
                          </div>
                          <!-- end of remove uploaded picture //-->

                       </div>
                      <!-- end of picture //-->

    </div><!-- end of column //-->
</div><!-- end of row //-->


<div class="row mt-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <button id='btnSubmit' style='display:none;' class='btn btn-success btn-primary'>Submit Registration</button>
    </div>
</div>








<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>

<script>
    $(document).ready(function(){
          $(document).on('change', '#file', function(){
                var property = document.getElementById("file").files[0];
                var image_name = property.name;
                var image_extension = image_name.split('.').pop().toLowerCase(1);


                if (jQuery.inArray(image_extension,['gif', 'png', 'jpg', 'jpeg'])==-1)
                {
                    alert("The selected file is invalid for upload as a picture");
                }else{
                    var image_size = property.size;

                    if (image_size>5000000){
                            alert("The selected picture is larger than the required picture size. Please resize the picture.");
                    }else{
                            $("#previewImage").attr('src','../assets/images/spinner.gif');
                            var form_data = new FormData();
                            form_data.append("file", property);
                            $.ajax({
                                url: '../server/upload_userpicture.php',
                                method: 'POST',
                                data: form_data,
                                dataType: 'json',
                                contentType: false,
                                processData: false,
                                beforeSend: function(){

                                },
                                success: function(data){
                                    //console.log(data);
                                    var  status = data.status;
                                    var location = data.location;
                                    var name = data.name;


                                    if (status==true)
                                    {
                                        $('#previewImage').attr('src','../assets/'+location);
                                        $('#btn_mpicture_upload').hide();
                                        $('#btn_mpicture_remove').show();
                                        $("#btnSubmit").show();
                                    }

                                }
                            })
                        } // end of if statement for image
                } // end of if statement jQuery






                $('#btn_mpicture_remove').on('click', function(){

                        $.ajax({
                            url: '../server/delete_uploaded_mpicture.php',
                            method: 'POST',
                            success: function(data){
                                console.log(data);
                                $('#btn_mpicture_remove').hide();
                                $('#btn_mpicture_upload').show();
                                $("#btnSubmit").hide();
                                $("#previewImage").attr('src','../assets/images/user_avatar_small.png');

                            }
                        });
                });




          });
    });

</script>
