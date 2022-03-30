<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center" <?php if($active_menu_item=='dashboard'){echo "style='background-color:#f1f1f1; color:white; font-weight:bold';"; } ?> >
          <a href='schoolinfo.php?q=<?php echo mask($_GET_URL_school_id); ?>'>School Dashboard</a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center" <?php if($active_menu_item=='schooladmins'){echo "style='background-color:#f1f1f1; color:white; font-weight:bold';"; } ?>>
          <a href='manage_schooladmin.php?q=<?php echo mask($_GET_URL_school_id); ?>'>School Admins</a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center" <?php if($active_menu_item=='teachers'){echo "style='background-color:#f1f1f1; color:white; font-weight:bold';"; } ?>>
          <a href='manage_teachers.php?q=<?php echo mask($_GET_URL_school_id); ?>'>Teachers</a>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 border py-2 text-center" <?php if($active_menu_item=='students'){echo "style='background-color:#f1f1f1; color:white; font-weight:bold';"; } ?>>
          <a href='manage_students.php?q=<?php echo mask($_GET_URL_school_id);; ?>'>Students</a>
    </div>
</div>
