<?php

/**
 * @package     createSchoolTeacher
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class createSchoolTeacher extends moodleform{

    public function definition(){
//hello

        global $CFG;
        $mform = $this->_form;


        // title
        $title = array();
        $title['0'] = '-- Select Title --';
        $title['1'] = 'Mr.';
        $title['2'] = 'Mrs.';
        $title['3'] = 'Ms.';
        $title['4'] = 'Dr.';
        $title['5'] = 'Prof.';
        $mform->addElement('select', 'title', 'Title', $title);
        $mform->setDefault('title', '0');


        // staff no
        $name_attributes = array('size'=>'30%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'staff_no', 'Staff No.', $name_attributes);
        $mform->setType('staff_no', PARAM_NOTAGS);
        $mform->setDefault('staff_no', '');

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

        
        // phone
        $phone_attributes = array('size'=>'40%');
        $mform->addElement('text', 'bvn', 'BVN', $phone_attributes);
        $mform->setType('bvn', PARAM_NOTAGS);
        $mform->setDefault('bvn', '');

        //school_id
        $mform->addElement('hidden', 'school_id', 'School_id');
        $mform->setType('school_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
