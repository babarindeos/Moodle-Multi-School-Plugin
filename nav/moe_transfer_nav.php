
<?php
      require_once(__DIR__.'/../../../config.php');
      $moe_dashboard = $CFG->wwwroot.'/local/newwaves/moe/moe_dashboard.php';
      $initiate_transfer = $CFG->wwwroot.'/local/newwaves/moe/transfer/initiate_transfer.php';
      $transfer_history = $CFG->wwwroot.'/local/newwaves/moe/transfer/transfer_history.php';


 ?>
<div>
  <button onclick="window.location='<?php echo $moe_dashboard; ?>'" border='0' class='btn btn-info btn-sm'>MOE Dashboard</button>
  <button onclick="window.location='<?php echo $initiate_transfer; ?>'" border='0' class='btn btn-success btn-sm'>Initiate Transfer</button>
  <button onclick="window.location='<?php echo $transfer_history; ?>'" border='0' class='btn btn-warning btn-sm'>Transfer History</button>

</div>

<hr/>
