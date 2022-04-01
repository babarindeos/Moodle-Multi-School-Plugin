<?php

/**
 * @package     local_message
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class createSchool extends moodleform{

    public function definition(){
        global $CFG;
        $mform = $this->_form;

        // school name
        $name_attributes=array('size'=>'100%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'name', 'School Name', $name_attributes);
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', '');

        // school type
        $choices = array();
        $choices['0'] = 'Primary School';
        $choices['1'] = 'Secondary School';
        $choices['2'] = 'College of Education';
        $choices['3'] = 'Polytechnic';
        $choices['4'] = 'University';

        $mform->addElement('select', 'type', 'School Type', $choices);
        $mform->setDefault('type', '1');


        // state
        $state = array();
        $state['0'] = "Abia";
        $state['1'] = "Abuja";
        $state['2'] = "Adamawa";
        $state['3'] = "Akwa Ibom";
        $state['4'] = "Anambra";
        $state['5'] = "Bauchi";
        $state['6'] = "Bayelsa";
        $state['7'] = "Benue";
        $state['8'] = "Borno";
        $state['9'] = "Cross River";
        $state['10'] = "Delta";
        $state['11'] = "Ebonyi";
        $state['12'] = "Edo";
        $state['13'] = "Ekiti";
        $state['14'] = "Enugu";
        $state['15'] = "Gombe";
        $state['16'] = "Imo";
        $state['17'] = "Jigawa";
        $state['18'] = 'Kaduna';
        $state['19'] = "Kano";
        $state['20'] = "Katsina";
        $state['21'] = "Kebbi";
        $state['22'] = "Kogi";
        $state['23'] = "Kwara";
        $state['24'] = "Lagos";
        $state['25'] = "Nasarawa";
        $state['26'] = "Niger";
        $state['27'] = "Ogun";
        $state['28'] = "Ondo";
        $state['29'] = "Osun";
        $state['30'] = "Oyo";
        $state['31'] = "Plateau";
        $state['32'] = "Rivers";
        $state['33'] = "Sokoto";
        $state['34'] = "Taraba";
        $state['35'] = "Yobe";
        $state['36'] = "Zamfara";

        $mform->addElement('select', 'state', 'State', $state);
        $mform->setDefault('state', 12);


        //Local government
        $mform->addElement('text', 'lga', 'Local Government Area', $name_attributes);
        $mform->setType('lga', PARAM_NOTAGS);
        $mform->setDefault('lga', '');

        // Address
        $mform->addElement('textarea', 'address', 'Address', 'wrap="virtual" rows="5" cols="102" required="^([0-9]{2}[a-zA-Z]?)?$"');
        $mform->setType('address', PARAM_NOTAGS);
        $mform->setDefault('address', '');

        $this->add_action_buttons();

    }

    function validation($data, $files){
       return array();
    }
 }
