<?php

/**
 * @package     createSchoolStudent
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");
 require($CFG->dirroot.'/local/newwaves/classes/Coursecategory.php');



 class updateCourse extends moodleform{

    public function definition(){


        global $CFG;
        global $DB;
        $mform = $this->_form;
        $school_id = $this->_customdata['my_array']['school_id'];

        //echo "School_id: ".$school_id;
        //exit;


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


        // description
        $mform->addElement('text', 'description', 'Description', $name_attributes);
        $mform->setType('description', PARAM_NOTAGS);
        $mform->setDefault('description', '');

//

//class
        $course_category = new Coursecategory();
        $getCourseCategory = $course_category->getCategoriesBySchool($DB, $school_id);

        $course_category = array();
        $course_category[0] = "-- Select Course Category --";

        foreach($getCourseCategory as $row){
            $course_category[$row->mdl_course_cat_id] = $row->name;
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
