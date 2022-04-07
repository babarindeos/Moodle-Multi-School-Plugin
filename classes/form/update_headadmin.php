<?php

/**
 * @package     create_headadmin
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class updateSchoolHeadAdmin extends moodleform{

    public function definition(){


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
        $email_attributes = array('size'=>'80%', 'readonly'=>true);
        $mform->addElement('text', 'email', 'Email', $email_attributes);
        $mform->setType('email', PARAM_NOTAGS);
        $mform->addRule('email', 'Email', 'email', null, 'client');
        $mform->setDefault('email', '');


        // phone
        $phone_attributes = array('size'=>'80%');
        $mform->addElement('text', 'phone', 'Phone', $phone_attributes);
        $mform->setType('phone', PARAM_NOTAGS);
        $mform->setDefault('phone', '');

        //headadmin_id
        $mform->addElement('hidden', 'headadmin_id', 'Head Admin ID');
        $mform->setType('headadmin_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
