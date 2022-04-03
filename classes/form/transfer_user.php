<?php

/**
 * @package     transfer_user
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */
 require_once(__DIR__.'/../../../../config.php');
 require_once("$CFG->libdir/formslib.php");

 class TransferUser extends moodleform{


        public function definition(){

            global $DB;
            global $CFG;




            // retrieve school data from database
            $mform = $this->_form;

            // schools
            $sql = "select id, name from {newwaves_schools}";
            $getSchools = $DB->get_records_sql($sql);
             $choices = array();
             foreach($getSchools as $school){
                $schoolname = $school->name;
                array_push($choices, $schoolname);
             }

             $mform->addElement('select', 'school_name', 'Name of School', $choices);
             $mform->setDefault('type', '1');


             // Remark
             $mform->addElement('textarea', 'purpose', 'Purpose for Transfer', 'wrap="virtual" rows="5" cols="102" required="^([0-9]{2}[a-zA-Z]?)?$"');
             $mform->setType('purpose', PARAM_NOTAGS);
             $mform->setDefault('purpose', '');

             // button
             $this->add_action_buttons();
        }

        function validation($data, $files){
           return array();

        }

 }
