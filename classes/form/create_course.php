<?php

/**
 * @package     createSchoolStudent
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");



 class createCourse extends moodleform{

    public function definition(){


        global $CFG;
        global $DB;
        $mform = $this->_form;


        // name
        $name_attributes = array('size'=>'100%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'name', 'Name', $name_attributes);
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', '');



        // code
        $name_attributes = array('size'=>'100%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'code', 'Code', $name_attributes);
        $mform->setType('code', PARAM_NOTAGS);
        $mform->setDefault('code', '');


        // description
        $mform->addElement('text', 'description', 'Description', $name_attributes);
        $mform->setType('description', PARAM_NOTAGS);
        $mform->setDefault('description', '');

//
        // retrieve school information from DB
        $sql = "SELECT * from {course_categories}";
        $school =  $DB->get_records_sql($sql);

//class
        $course_category = array();
//        for($i = 0; $i < count($school); $i++){
//            $course_category[(string)$i] = $school[$i]['code'] ." ".$school[$i]['name'];
//        }
        $i = 0;
        foreach($school as $row){
            $course_category[$i] = $row->name;
            $i++;
        }

        $mform->addElement('select', 'course_category', 'Course Category', $course_category);
        $mform->setDefault('course_category', '0');

        //creator_id
        $mform->addElement('hidden', 'creator_id', 'creator_id');
        $mform->setType('creator_id', PARAM_NOTAGS);

        //school_id
        $mform->addElement('hidden', 'school_id', 'school_id');
        $mform->setType('school_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
