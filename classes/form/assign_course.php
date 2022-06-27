<?php

/**
 * @package     Assign Course
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");



 class assignCourse extends moodleform{



    public function definition(){
      global $CFG;
      global $DB;
      $mform = $this->_form;
      $teacherData = $this->_customdata['my_array'];


      //course_id
      $mform->addElement('hidden', 'course_id', 'course_id');
      $mform->setType('course_id', PARAM_NOTAGS);

      //mdl_course_id
      $mform->addElement('hidden', 'mdl_course_id', 'mdl_course_id');
      $mform->setType('mdl_course_id', PARAM_NOTAGS);


      //school_id
      $mform->addElement('hidden', 'school_id', 'school_id');
      $mform->setType('school_id', PARAM_NOTAGS);


      //teacherData
      $teacher_data_attributes = array('width'=>'80%');
      $mform->addElement('select', 'teacher_id', 'Teachers', $teacherData, $teacher_data_attributes);
      $mform->setDefault('teacher_id', '0');

      $this->add_action_buttons();


  }



 }
