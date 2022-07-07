<?php

class GradeBook{

  private $courseId;
  private $sqlQuery;
  private $result;
  private $output;

  public function __construct(){

  }

  public function getGradeBooksBySchoolId($DB, $schoolId){
      $this->sqlQuery = "Select gi.id, gi.courseid, gi.categoryid, gi.itemname, gi.itemtype, gi.itemmodule, gi.iteminstance,
                         gi.itemnumber, gi.iteminfo, gi.idnumber, gi.calculation, gi.gradetype, gi.grademax, gi.grademin,
                         gi.scaleid, gi.outcomeid, gi.gradepass, gi.multfactor, gi.aggregationcoef, gi.aggregationcoef2,
                         gi.sortorder, gi.display, gi.decimals, gi.hidden, gi.locked, gi. locktime, gi.needsupdate, gi.weightoverride,
                         gi.timecreated, gi.timemodified, nw.full_name, nw.short_code from {grade_items} gi inner join {newwaves_course} nw on
                         gi.courseid=nw.mdl_course_id where nw.school_id='{$schoolId}' and gi.itemname!='' order by gi.id desc";

      $this->output = $DB->get_records_sql($this->sqlQuery);
      $this->result = $this->output;
      return $this->result;
  }

}


?>
