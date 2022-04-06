<?php

/**
 * @package     createSchoolStudent
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

 require_once("$CFG->libdir/formslib.php");



 class createassignCourse extends moodleform{

    public function definition(){


        global $CFG;
        global $DB;
        $mform = $this->_form;


//        // retrieve school information from DB
        $sql = "SELECT * from {newwaves_schools_users} where schoolid = 1  and role='teacher'";
        $school =  $DB->get_records_sql($sql);

//class
        $course_category = array();
//        for($i = 0; $i < count($school); $i++){
//            $course_category[(string)$i] = $school[$i]['code'] ." ".$school[$i]['name'];
//        }
        $i = 0;
        foreach($school as $row){
            $course_category[$i] = $row->surname ." ". $row->firstname ." ". $row->middlename;
            $i++;
        }
        //http://localhost:8888/moodle311/local/newwaves/schools/course/assign_course.php?q=WYsMve86g()Ue6mdqy)bQVOIgF2D4lP.uoW5PjzfloiYy5M.V0jQ)tN66N3u!kxaPJ.WZE6jZLD!yDyRi9rZeRQEcjajR)qRGLk1-2-15U52KT1QlpVXzwHfNPBAHh0HEIuGJTE!HNaqeiHYpmfst)1!oDCBwQDEvN8hOXLX59leTUXwfLm8T1ESdPhGd4AYdvMI.bj!vWJ&u=440Qb)W5zoXO5.iL68.mevjvFyoUo1DVnrJYExjEZOzHuxfnOYbqkBHO)oT1upzInC5KKVaU.gMdSr6g0Xg(5)4nqMftiIrB)l)U-2-QzXD2bbtmD4cqywJIknY0IcK)Y8FFiRc6Klk8E2i(dJJwyt1fMeFTQ6CJxK(wqel(!pZ)TsYuh5kkT5zviIz.ZUxzomk86zK0GE.

        $mform->addElement('select', 'course_category', 'Teacher name', $course_category);
        $mform->setDefault('course_category', '0');
        //school_id
        $mform->addElement('text', 'creator_id', 'creator_id');
        $mform->setType('creator_id', PARAM_NOTAGS);
        $mform->setDefault('creator_id', 'schoolid');

        $this->add_action_buttons();



    }
 }
