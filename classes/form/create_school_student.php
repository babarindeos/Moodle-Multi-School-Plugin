<?php

/**
 * @package     createSchoolStudent
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class createSchoolStudent extends moodleform{

    public function definition(){


        global $CFG;
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
        $mform->addElement('text', 'middlename', 'Middlename', $name_attributes);
        $mform->setType('middlename', PARAM_NOTAGS);
        $mform->setDefault('middlename', '');

        //gender
        $gender = array();
        $gender[0] = '-- Select Gender --';
        $gender[1] = 'Male';
        $gender[2] = 'Female';
        $mform->addElement('select', 'gender', 'Gender', $gender);
        $mform->setDefault('gender', '0');


        //email
        $email_attributes = array('size'=>'80%');
        $mform->addElement('text', 'email', 'Email', $email_attributes);
        $mform->setType('email', PARAM_NOTAGS);
        $mform->addRule('email', 'Email', 'email', null, 'client');
        $mform->setDefault('email', '');


        // phone
        $phone_attributes = array('size'=>'80%');
        $mform->addElement('text', 'phone', 'Phone', $phone_attributes);
        $mform->setType('phone', PARAM_NOTAGS);
        $mform->setDefault('phone', '');

        //class
        $class = array();
        $class['0'] = '-- Select Class --';
        $class['1'] = 'Basic 3';
        $class['2'] = 'Basic 4';
        $class['3'] = 'Basic 5';
        $class['4'] = 'Basic 6';
        $class['5'] = 'JSS 1';
        $class['6'] = 'JSS 2';
        $class['7'] = 'JSS 3';
        $class['8'] = 'SSS 1';
        $class['9'] = 'SSS 2';
        $class['10'] = 'SSS 3';
        $class['11'] = 'Not Applicable';
        $mform->addElement('select', 'class', 'Class', $class);
        $mform->setDefault('class', '0');

        //school_id
        $mform->addElement('hidden', 'school_id', 'School_id');
        $mform->setType('school_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
