<?php

/**
 * @package     update_stude
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class updateSchoolStudent extends moodleform{

    public function definition(){


        global $CFG; //hello
        $mform = $this->_form;





        // admission no

        $name_attributes = array('size'=>'30%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'admission_no', 'Admission No.', $name_attributes);
        $mform->setType('admission_no', PARAM_NOTAGS);
        $mform->setDefault('admission_no', '');


        // Surname
        $name_attributes = array('size'=>'100%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'surname', 'Surname', $name_attributes);
        $mform->setType('surname', PARAM_NOTAGS);
        $mform->setDefault('surname', '');


        // Firstname
        $mform->addElement('text', 'firstname', 'Firstname', $name_attributes);
        $mform->setType('firstname', PARAM_NOTAGS);
        $mform->setDefault('firstname', '');


        // Middlename
        $mform->addElement('text', 'middlename', 'Middlename');
        $mform->setType('middlename', PARAM_NOTAGS);
        $mform->setDefault('middlename', '');

        //gender
        $gender = array();
        $gender[0] = 'Male';
        $gender[1] = 'Female';
        $mform->addElement('select', 'gender', 'Gender', $gender);
        $mform->setDefault('gender', '0');


        //email
        $email_attributes = array('size'=>'80%','readonly'=>true);
        $mform->addElement('text', 'email', 'Email', $email_attributes);
        $mform->setType('email', PARAM_NOTAGS);
        $mform->addRule('email', 'Email', 'email', null, 'client');
        $mform->setDefault('email', '');


        // phone
        $phone_attributes = array('size'=>'80%');
        $mform->addElement('text', 'phone', 'Phone', $phone_attributes);
        $mform->setType('phone', PARAM_NOTAGS);
        $mform->setDefault('phone', '');

        //school_id
        $mform->addElement('hidden', 'student_id', 'Student ID');
        $mform->setType('student_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
