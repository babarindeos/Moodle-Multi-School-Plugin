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
        $state['1'] = "Adamawa";
        $state['2'] = "Akwa Ibom";
        $state['3'] = "Anambra";
        $state['4'] = "Bauchi";
        $state['5'] = "Bayelsa";
        $state['6'] = "Benue";
        $state['7'] = "Borno";
        $state['8'] = "Cross River";
        $state['9'] = "Delta";
        $state['10'] = "Ebonyi";
        $state['11'] = "Edo";
        $state['12'] = "Ekiti";
        $state['13'] = "Enugu";
        $state['14'] = "Gombe";
        $state['15'] = "Imo";
        $state['16'] = "Jigawa";
        $state['17'] = 'Kaduna';
        $state['18'] = "Kano";
        $state['19'] = "Katsina";
        $state['20'] = "Kebbi";
        $state['21'] = "Kogi";
        $state['22'] = "Kwara";
        $state['23'] = "Lagos";
        $state['24'] = "Nasarawa";
        $state['25'] = "Niger";
        $state['26'] = "Ogun";
        $state['27'] = "Ondo";
        $state['28'] = "Osun";
        $state['29'] = "Oyo";
        $state['30'] = "Plateau";
        $state['31'] = "Rivers";
        $state['32'] = "Sokoto";
        $state['33'] = "Taraba";
        $state['34'] = "Yobe";
        $state['35'] = "Zamfara";

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
