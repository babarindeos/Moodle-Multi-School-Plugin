<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     manage_schooladmin
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

// Get School Id
if (!isset($_GET['q']) || $_GET['q']==''){
    redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
}

$_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
$_GET_URL_school_id = $_GET_URL_school_id[1];


global $DB;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/schoolinfo.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('School Information');
 //$PAGE->set_heading('School Information');
 $PAGE->navbar->ignore_active();
 $PAGE->navbar->add(get_string('moedashboard', 'local_newwaves'), new moodle_url('/local/newwaves/moe/moe_dashboard.php'));
 $PAGE->navbar->add(get_string('moemanageschools', 'local_newwaves'), new moodle_url('/local/newwaves/manage_schools.php'));

 echo $OUTPUT->header();
 echo "<h2>School Information<small> [ Manage School Admin ]</small></h2>";
 $active_menu_item = 'schooladmins';


 // navigation  bar
 include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');


 // retrieve school information from DB
 $sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
 $school =  $DB->get_records_sql($sql);
//var_dump($school);
//die;
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
 <!-- Navigation //-->
 <?php
    include_once($CFG->dirroot.'/local/newwaves/nav/moe_school_nav.php');
 ?>
 <!-- end of navigation //-->

 <div class="row d-flex justify-content-right mt-2 mb-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
       <?php
          $create_head_href = "create_school_admin.php?q=".mask($_GET_URL_school_id);
       ?>
        <button onClick="window.location='<?php echo $create_head_href; ?>'" class='btn btn-sm btn-primary rounded'>Create School Admin</button>
    </div>
 </div>


 <?php
  $sql = "SELECT id, title, surname, firstname, middlename , gender, email, phone, role, status FROM
          {newwaves_schools_users} where role='schooladmin' and schoolid = {$_GET_URL_school_id} order by id desc";

  $headadmin = $DB->get_records_sql($sql);

  //$schools = $DB->get_records('newwaves_schools');
  //var_dump($schools);

  $sn = 1;

  echo "<table class='table table-stripped border' id='tblData'>";
  echo "<thead>";
  echo "<tr class='font-weight-bold' >";
       echo "<th class='py-3'>SN</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th class='text-center'>Action</th></tr>";
  echo "</thead>";
  echo "<tbody>";
        foreach($headadmin as $row){
            $title = title($row->title);

            $statusPane = '';
            if ($row->status=='active'){
                $statusPane = "<span class='badge badge-pill badge-success px-3 py-1'>Active</span>";
            }else if($row->status=='suspended'){
                $statusPane = "<span class='badge badge-pill badge-danger px-3 py-1'>Suspended</span>";
            }

            $viewHref = "window.location='schooladmin/view_schooladmin.php?q=".mask($_GET_URL_school_id)."&u=".mask($row->id)."'";
            $editHref = "window.location='edit_schooladmin.php?q=".mask($_GET_URL_school_id)."&u=".mask($row->id)."'";

            $btnView = "<button onclick={$viewHref} class='btn btn-success btn-sm rounded'>View</button>";
            $btnEdit = "<button onclick={$editHref} class='btn btn-warning btn-sm rounded'>Edit</button>";
            $btnDelete = "<button id='btn{$row->id}' class='btn btn-danger btn-sm rounded btn-delete' data-toggle='modal' data-target='#deleteModalCenter'>Delete</button>";
            echo "<tr>";
                echo "<td class='text-center'>{$sn}.</td>";
                echo "<td class='text-left'>{$title} {$row->surname} {$row->firstname}</td>";
                echo "<td class='text-left'>{$row->email}</td>";
                echo "<td class='text-left'>{$row->phone}</td>";
                echo "<td class='text-left'>{$statusPane}</td>";
                echo "<td class='text-center'>{$btnView} {$btnEdit} {$btnDelete}</td>";
            echo "</tr>";

            $sn++;
        }
  echo "</tbody>";
  echo "</table>";



  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
?>



<?php
 $page = "manage_schooladmin.php";

 echo "<input id='select_delete_record' type='hidden' value='' />";
 echo "<input id='school_id' type='hidden' value='{$_GET_URL_school_id}' />";
 echo "<input id='page' type='hidden' value='{$page}' />";
 require_once($CFG->dirroot.'/local/newwaves/includes/modal_delete.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
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
         var userId = $("#select_delete_record").val();
         var qcode = generateMask(60);
         var zcode = generateMask(60);
         var page = 'manage_schooladmin.php';

         window.location='schooladmin/delete_schooladmin.php?q='+qcode+'&uid='+userId+'&z='+zcode+'&sid='+school_id+'&pg='+page+'&j='+qcode;
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
