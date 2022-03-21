
<?php
      require_once(__DIR__.'/../../../config.php');
      $moe_dashboard = $CFG->wwwroot.'/local/newwaves/moe/moe_dashboard.php';
      $manage_schools = $CFG->wwwroot.'/local/newwaves/moe/manage_schools.php';
      $create_school = $CFG->wwwroot.'/local/newwaves/moe/create_school.php';

 ?>
<div>
  <button onclick="window.location='<?php echo $moe_dashboard; ?>'" border='0' class='btn btn-success btn-sm'>Dashboard</button>
  <button onclick="window.location='<?php echo $manage_schools; ?>'" border='0' class='btn btn-warning btn-sm'>Manage Schools</button>
  <button onclick="window.location='<?php echo $create_school; ?>'" border='0' class='btn btn-primary btn-sm'>Create School</button>
</div>

<hr/>
