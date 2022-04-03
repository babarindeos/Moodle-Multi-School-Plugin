
<?php
      require_once(__DIR__.'/../../../config.php');
      $moe_dashboard = $CFG->wwwroot.'/local/newwaves/moe/moe_dashboard.php';
      $student_dashboard = $CFG->wwwroot.'/local/newwaves/moe/school/student/student_dashboard.php';
      $manage_students = $CFG->wwwroot.'/local/newwaves/moe/school/student/manage_students.php';
      $create_student = $CFG->wwwroot.'/local/newwaves/moe/school/student/create_student.php';

 ?>
<div>
  <button onclick="window.location='<?php echo $moe_dashboard; ?>'" border='0' class='btn btn-success btn-sm'>MOE Dashboard</button>
  <button onclick="window.location='<?php echo $student_dashboard; ?>'" border='0' class='btn btn-info btn-sm'>Students Dashboard</button>
  <button onclick="window.location='<?php echo $manage_students; ?>'" border='0' class='btn btn-warning btn-sm'>Manage Students</button>
  
</div>

<hr/>
