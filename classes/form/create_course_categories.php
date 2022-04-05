<?php

/**
 * @package     createSchoolStudent
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class createCourseCategories extends moodleform{

    public function definition(){


        global $CFG;
        $mform = $this->_form;


        // name
        $name_attributes = array('size'=>'100%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'name', 'Name.', $name_attributes);
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', '');



        // code
        $name_attributes = array('size'=>'100%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'code', 'Code', $name_attributes);
        $mform->setType('code', PARAM_NOTAGS);
        $mform->setDefault('code', '');


        // summary
        $mform->addElement('text', 'summary', 'Summary', $name_attributes);
        $mform->setType('summary', PARAM_NOTAGS);
        $mform->setDefault('summary', '');


        //school_id
        $mform->addElement('hidden', 'creator_id', 'creator_id');
        $mform->setType('creator_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
