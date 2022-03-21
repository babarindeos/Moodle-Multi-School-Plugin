<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center">
          <a href='schoolinfo.php?q=<?php echo mask($_GET_URL_school_id); ?>'>School Dashboard</a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center">
          <a href='manage_headadmin.php?q=<?php echo mask($_GET_URL_school_id); ?>'>Head Admin</a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center">
          <a href='schoolinfo_schooladmin.php?q=<?php echo mask($_GET_URL_school_id); ?>'>School Admins</a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center">
          <a href='schoolinfo_teachers.php?q=<?php echo mask($_GET_URL_school_id); ?>'>Teachers</a>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center">
          <a href='schoolinfo_students.php?q=<?php echo $school_id; ?>'>Students</a>
    </div>
</div>
