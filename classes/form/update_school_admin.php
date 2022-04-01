<?php

/**
 * @package     update_school_admin
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class updateSchoolAdmin extends moodleform{

    public function definition(){


        global $CFG; //hello
        $mform = $this->_form;


        // title
        $title = array();
        $title['0'] = 'Mr.';
        $title['1'] = 'Mrs.';
        $title['2'] = 'Ms.';
        $title['3'] = 'Dr.';
        $title['4'] = 'Prof.';
        $mform->addElement('select', 'title', 'Title', $title);
        $mform->setDefault('title', '0');



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
        $mform->addElement('hidden', 'school_admin_id', 'School Admin ID');
        $mform->setType('school_admin_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
