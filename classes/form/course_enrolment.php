<?php

/**
 * @package     ccourseEnrolment
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");



 class courseEnrolment extends moodleform{



    public function definition(){
      global $CFG;
      global $DB;
      $mform = $this->_form;
      $studentData = $this->_customdata['my_array'];






      //school_id
      $mform->addElement('text', 'course_id', 'course_id');
      $mform->setType('course_id', PARAM_NOTAGS);



      //studentData
      $student_data_attributes = array('width'=>'80%');
      $mform->addElement('select', 'students', 'Students', $studentData, $student_data_attributes);
      $mform->setDefault('students', '0');




  }



 }
