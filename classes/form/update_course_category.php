<?php

/**
 * @package     createSchoolStudent
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class updateCourseCategory extends moodleform{

    public function definition(){


        global $CFG;
        $mform = $this->_form;


        // name
        $name_attributes = array('size'=>'100%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'name', 'Name', $name_attributes);
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', '');



        // code
        $name_attributes = array('size'=>'100%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'code', 'Shortname', $name_attributes);
        $mform->setType('code', PARAM_NOTAGS);
        $mform->setDefault('code', '');


        // summary
        $mform->addElement('text', 'summary', 'Summary', $name_attributes);
        $mform->setType('summary', PARAM_NOTAGS);
        $mform->setDefault('summary', '');

        //course_category_id
        $mform->addElement('hidden', 'course_category_id', 'Course Category ID');
        $mform->setType('course_category_id', PARAM_NOTAGS);

        //creator_id
        $mform->addElement('hidden', 'creator_id', 'creator_id');
        $mform->setType('creator_id', PARAM_NOTAGS);


        //school_id
        $mform->addElement('hidden', 'school_id', 'school_id');
        $mform->setType('school_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
