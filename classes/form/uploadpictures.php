<?php

/**
 * @package     local_message
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class Uploadpictures extends moodleform{

    public function definition(){


        global $CFG;
        $mform = $this->_form;


        // admission no
        $maxbytes = 200000;

        //$name_attributes = array('size'=>'30%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('filepicker', 'userfile', 'Upload your Picture.', null, array('maxbytes'=>$maxbytes, 'accepted_types'=>'*'));
        $mform->setType('userfile', PARAM_NOTAGS);





        //school_id
        $mform->addElement('hidden', 'school_id', 'School_id');
        $mform->setType('school_id', PARAM_NOTAGS);

        $this->add_action_buttons();



    }
 }
