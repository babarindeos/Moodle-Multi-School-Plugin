<?php

/**
 * @package     createSchool
 * @author      Seyibabs
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
        $choices['0'] = '-- Select School Type --';
        $choices['1'] = 'Primary School';
        $choices['2'] = 'Secondary School';
        $choices['3'] = 'College of Education';
        $choices['4'] = 'Polytechnic';
        $choices['5'] = 'University';

        $mform->addElement('select', 'type', 'School Type', $choices);
        $mform->setDefault('type', '0');


        // state
        $state = array();
        $state['0'] = '-- Select State --';
        $state['1'] = "Abia";
        $state['2'] = "Abuja";
        $state['3'] = "Adamawa";
        $state['4'] = "Akwa Ibom";
        $state['5'] = "Anambra";
        $state['6'] = "Bauchi";
        $state['7'] = "Bayelsa";
        $state['8'] = "Benue";
        $state['9'] = "Borno";
        $state['10'] = "Cross River";
        $state['11'] = "Delta";
        $state['12'] = "Ebonyi";
        $state['13'] = "Edo";
        $state['14'] = "Ekiti";
        $state['15'] = "Enugu";
        $state['16'] = "Gombe";
        $state['17'] = "Imo";
        $state['18'] = "Jigawa";
        $state['19'] = 'Kaduna';
        $state['20'] = "Kano";
        $state['21'] = "Katsina";
        $state['22'] = "Kebbi";
        $state['23'] = "Kogi";
        $state['24'] = "Kwara";
        $state['25'] = "Lagos";
        $state['26'] = "Nasarawa";
        $state['27'] = "Niger";
        $state['28'] = "Ogun";
        $state['29'] = "Ondo";
        $state['30'] = "Osun";
        $state['31'] = "Oyo";
        $state['32'] = "Plateau";
        $state['33'] = "Rivers";
        $state['34'] = "Sokoto";
        $state['35'] = "Taraba";
        $state['36'] = "Yobe";
        $state['37'] = "Zamfara";

        $mform->addElement('select', 'state', 'State', $state);
        $mform->setDefault('state', 0);


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
