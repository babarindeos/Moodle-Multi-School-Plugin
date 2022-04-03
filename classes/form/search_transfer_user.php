
<?php

/**
 * @package     SearchUserTransfer
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");

 class SearchUserTransfer extends moodleform{

    public function definition(){
//hello

        global $CFG;
        $mform = $this->_form;

        // staff no
        $name_attributes = array('size'=>'60%', 'required'=>'^([0-9]{2}[a-zA-Z]?)?$');
        $mform->addElement('text', 'search_user', 'Search User (enter user email)', $name_attributes);
        $mform->setType('search_user', PARAM_NOTAGS);
        $mform->addRule('search_user', 'Email', 'email', null, 'client');
        $mform->setDefault('staff_no', "");

        $this->add_action_buttons();



    }
 }
