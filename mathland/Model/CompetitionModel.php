<?php
    require_once("Model//DBconnection.php");

    // Class to support data competition entries
    class CompetitionModel
    {
        private $myController;
        
        // Single Account Information for Competition Entry, set using Competition Form 1 time per account
        public $comp_ques_txt;
        public $comp_ques_opt;
        public $comp_email;
        public $comp_classroom;
        public $comp_school;
        public $comp_school_ph;
        
        // Random Math Question Variables for Competition Subscriptions Math Question
        public $comp_ques_id;
        public $comp_ques_opt1;
        public $comp_ques_opt2;
        public $comp_ques_opt3;

        function __construct($prMyController)
        {
            $this->myController = $prMyController;
        }

        function get_question(){
        // Gets a random question for competition entry  - 
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->get_question());
            if ($aDB->num_rows() == 0)
            {
                // should never happen unless table empty?
            }
            else 
            {
                $aRow = $aDB->next();
                $this->comp_ques_id = $aRow['comp_ques_id'];
                $this->comp_ques_txt = $aRow['comp_ques_txt'];
                $this->comp_ques_opt1 = $aRow['comp_ques_opt1'];
                $this->comp_ques_opt2 = $aRow['comp_ques_opt2'];
                $this->comp_ques_opt3 = $aRow['comp_ques_opt3'];
            }
            $aDB->free();
            $this->comp_ques_opt = "";
            $this->comp_email = "";
            $this->comp_classroom = "";
            $this->comp_school = "";
            $this->comp_school_ph = "";
        }

        public function get_entry($prAccID){
        // Called each time navigating to the Competition View to populate the model variables from currently
        // stored competition entry for the user in the database if exists, 
        // otherwise they remain empty, and calls get_question
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->get_entry($prAccID));
            if ($aDB->num_rows() > 0)
            {
                $aRow = $aDB->next();
                $this->comp_ques_id = $aRow['comp_ques_id'];
                $this->comp_ques_opt = $aRow['comp_ques_opt'];
                $this->comp_email = $aRow['comp_email'];
                $this->comp_classroom = $aRow['comp_classroom'];
                $this->comp_school = $aRow['comp_school'];
                $this->comp_school_ph = $aRow['comp_school_ph'];
                $aDB->free();
                $aDB->query($aDB->sql->get_question_text($this->comp_ques_id));
                if ($aDB->num_rows() > 0)
                {
                    $aRow = $aDB->next();
                    $this->comp_ques_txt = $aRow['comp_ques_txt'];
                    $this->comp_ques_opt1 = "";
                    $this->comp_ques_opt2 = "";
                    $this->comp_ques_opt3 = "";                
                }
            }
            else
            {
                $this->get_question();
            }
            $aDB->free();
        }

        public function insert_entry($prAccID){
            // Insert new competition entry to the database
            // Check all fields expected are passed, nothing more and nothing less for security reasons
            if(isset($_POST["email"]) && isset($_POST["school"]) && isset($_POST["phone"]) 
                && isset($_POST["classroom"]) && isset($_POST["opt"]) && isset($_POST["ques_id"]))
            {
                // Check no fields have been manipulated to be blank
                if(!empty($_POST["email"]) && !empty($_POST["school"]) && !empty($_POST["phone"]) 
                    && !empty($_POST["classroom"]) && !empty($_POST["opt"]) && !empty($_POST["ques_id"]))
                {   
                    $aDB = new DBConnection();
                    $aDB->query($aDB->sql->insert_entry($prAccID));
                }
            }
            // Once inserted now check it exist in DB and retrieve it to display thanks view
            $this->get_entry($prAccID);
        }
        
    }
?>