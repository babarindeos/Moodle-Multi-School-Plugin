
<?php
      require_once(__DIR__.'/../../../config.php');
      $moe_dashboard = $CFG->wwwroot.'/local/newwaves/moe/moe_dashboard.php';
      $teacher_dashboard = $CFG->wwwroot.'/local/newwaves/moe/school/teacher/teacher_dashboard.php';
      $manage_teachers = $CFG->wwwroot.'/local/newwaves/moe/school/teacher/manage_teachers.php';
      $create_teacher = $CFG->wwwroot.'/local/newwaves/moe/school/teacher/create_teacher.php';

 ?>
<div>
  <button onclick="window.location='<?php echo $moe_dashboard; ?>'" border='0' class='btn btn-success btn-sm'>MOE Dashboard</button>
  <button onclick="window.location='<?php echo $teacher_dashboard; ?>'" border='0' class='btn btn-info btn-sm'>Teachers Dashboard</button>
  <button onclick="window.location='<?php echo $manage_teachers; ?>'" border='0' class='btn btn-warning btn-sm'>Manage Teachers</button>
  <button onclick="window.location='<?php echo $create_teacher; ?>'" border='0' class='btn btn-primary btn-sm'>Create Teacher</button>
</div>

<hr/>
