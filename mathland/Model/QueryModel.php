<?php
    // Class to contain all sql queries for db interactivity
    class QueryModel
    {
        public $dbRs;
        
        // Function used for SQL escaping to make using it elsewhere less bulky
        public function sqlEsc($prText){
            return mysqli_real_escape_string($this->dbRs, $prText);
        }
        
        public function get_comments($prSection){
        // Gets all comments for specified tutorial section
            return "SELECT t1.comment_section,t2.acc_username,t1.comment_txt,t1.comment_timestamp FROM tbl_comment AS t1 
                    INNER JOIN tbl_account AS t2 ON t1.comment_from = t2.acc_id 
                    WHERE t1.comment_section = '".$this->sqlEsc($prSection)."' ORDER BY t1.comment_timestamp DESC";
        }
        
        public function insert_comment($prSection,$prAccID, $prComment){
        // Inserts comments to specified tutorial section
            return "INSERT INTO tbl_comment (comment_section,comment_from,comment_txt) VALUES ('".$this->sqlEsc($prSection)."',"
                    .$this->sqlEsc($prAccID).",'".$this->sqlEsc($prComment)."')";
        }
        
        public function get_nav_history($prAccID){
        // Gets existing navigation history for a specified account ID
            return "SELECT t1.acc_nav_timestamp,t2.view_name,t2.view_title,t1.nav_info FROM tbl_account_nav_history AS t1 
                    INNER JOIN tbl_view AS t2 ON t1.view_id = t2.view_id 
                    WHERE t1.acc_id=".$this->sqlEsc($prAccID)." ORDER BY t1.acc_nav_timestamp DESC";
        }
        
        public function insert_nav_history($prAccID, $prViewID, $prNavInfo){
        // inserts a logged in users navigation history each time navigating the web app
            return "INSERT INTO tbl_account_nav_history (acc_id,view_id,nav_info) 
                    VALUES (".$this->sqlEsc($prAccID).",".$this->sqlEsc($prViewID).",'".$this->sqlEsc($prNavInfo)."')";
        }
      
        public function get_trainer_scores($prAccID){
        // Gets a users speed trainer game scores history
            return "SELECT * FROM tbl_account_trainer_score WHERE acc_id=".$this->sqlEsc($prAccID)." ORDER BY trainer_timestamp DESC";
        }
        
        public function insert_trainer_score($prAccID, $prScore, $prTimeouts, $prMins, $prSecs){
        // inserts a logged in users speed trainer game score
            return "INSERT INTO tbl_account_trainer_score (acc_id,trainer_score,trainer_timeouts,trainer_mins,trainer_secs) 
                    VALUES (".$this->sqlEsc($prAccID).",".$this->sqlEsc($prScore).",".$this->sqlEsc($prTimeouts).
                    ",".$this->sqlEsc($prMins).",".$this->sqlEsc($prSecs).")";
        }
        
        public function get_question(){
        // Gets a random question for competition entry form
            return "SELECT * FROM tbl_comp_question ORDER BY RAND() LIMIT 1";
        }
        
        public function get_view($prView){
        // Gets a random question for competition entry form
            return "SELECT * FROM tbl_view WHERE view_name='".$prView."' LIMIT 1";
        }
        
        public function get_entry($prAccID){
            // Gets existing Competition entry data for an account if exists, used to get entry data for thanks page
            return "SELECT * FROM tbl_comp_subscription WHERE acc_id=".$this->sqlEsc($prAccID)." LIMIT 1";
        }
        
        public function get_question_text($prComp_ques_id){
            // Gets the Text for a given Competition question based on the Question ID, used to load thanks page.
            return "SELECT comp_ques_txt FROM tbl_comp_question WHERE comp_ques_id=".$this->sqlEsc($prComp_ques_id)." LIMIT 1";
        }
        
        public function insert_entry($prAccID){
            // Inserts a Competition entry into the database for an account
            return "INSERT INTO tbl_comp_subscription (
                        acc_id,
                        comp_ques_id,
                        comp_ques_opt,
                        comp_email,
                        comp_classroom,
                        comp_school,
                        comp_school_ph 
                        ) VALUES ("
                        .$this->sqlEsc($prAccID).","
                        .$this->sqlEsc($_POST["ques_id"]).",'"
                        .$this->sqlEsc($_POST["opt"])."','"
                        .$this->sqlEsc($_POST["email"])."','"
                        .$this->sqlEsc($_POST["classroom"])."','"
                        .$this->sqlEsc($_POST['school'])."','"
                        .$this->sqlEsc($_POST['phone'])."')";
        }
        
        public function get_acc_available(){
            // Checks if an account exists by a specified name, used to check if name is taken before allowing registration
            return "SELECT acc_username FROM tbl_account WHERE acc_username='".$this->sqlEsc($_POST["name"])."'";
        }
        
        public function get_acc_type_id(){
            // Gets the Acc Type ID according to users selected Account type at registration, needed to register new accounts
            return "SELECT acctype_id FROM tbl_account_type WHERE acctype_name='".$this->sqlEsc($_POST["type"])."'";
        }
        
        public function insert_new_acc($prTypeID){
            // Inserts a new registered account into the database
            return "INSERT INTO tbl_account (
                                        acc_username,
                                        acc_pass,
                                        acc_type_id,
                                        acc_firstname,
                                        acc_lastname,
                                        acc_email,
                                        acc_dob,
                                        acc_gender,
                                        acc_school,
                                        acc_country
                                        ) VALUES ('"
                                        .$this->sqlEsc($_POST["name"])."','"
                                        .$this->sqlEsc($_POST["pass"])."',"
                                        .$this->sqlEsc($prTypeID).",'"
                                        .$this->sqlEsc($_POST["first"])."','"
                                        .$this->sqlEsc($_POST["last"])."','"
                                        .$this->sqlEsc($_POST["email"])."','"
                                        .$this->sqlEsc($_POST["dob"])."','"
                                        .$this->sqlEsc($_POST["gender"])."','"
                                        .$this->sqlEsc($_POST["school"])."','"
                                        .$this->sqlEsc($_POST["country"])."')";
        }
        
        public function update_acc_info($prAcc){
            // Updates the editable feilds for and account! used on users own profile page
            return "UPDATE tbl_account SET
                        acc_firstname = '".$this->sqlEsc($prAcc->firstname)."',
                        acc_lastname = '".$this->sqlEsc($prAcc->lastname)."',
                        acc_email = '".$this->sqlEsc($prAcc->email)."',
                        acc_school = '".$this->sqlEsc($prAcc->school)."',
                        acc_country = '".$this->sqlEsc($prAcc->country)."' 
                        WHERE acc_id=".$this->sqlEsc($prAcc->acc_id);
        }
        
        public function get_acc_pass_auth($prAccID){
            // Checks old password supplied is correct to authorize the changing of Old pass to a New pass
            return "SELECT acc_id FROM tbl_account 
                        WHERE acc_id=".$this->sqlEsc($prAccID).
                        " AND acc_pass = '".$this->sqlEsc($_POST["oldpass"])."'";
        }
        
        public function update_acc_pass($prAccID){
            // Updates the Password of an account, used on users own profile page for editing acc pass
            return "UPDATE tbl_account SET 
                        acc_pass = '".$this->sqlEsc($_POST["newpass"])."' 
                        WHERE acc_id=".$this->sqlEsc($prAccID).
                        " AND acc_pass='".$this->sqlEsc($_POST["oldpass"])."'";
        }
        
        public function get_acc_login($prName,$prPass){
            // Checks if Login name and pass are correct, if so pulls the account details, used to login an acc
            return "SELECT 
                        acc.acc_id,
                        acc.acc_username,
                        typ.acctype_name,
                        acc.acc_firstname,
                        acc.acc_lastname,
                        acc.acc_email,
                        acc.acc_dob,
                        acc.acc_gender,
                        acc.acc_school,
                        acc.acc_country 
                        FROM tbl_account acc 
                        INNER JOIN tbl_account_type typ 
                        ON acc.acc_type_id=typ.acctype_id
                        WHERE acc.acc_username='".$this->sqlEsc($prName)."' 
                        AND acc.acc_pass='".$this->sqlEsc($prPass)."'";
        }
        
        public function get_acc_profile($prName){
            // gets the publically visible account details to show the profile of any user when requested.
            return "SELECT 
                        acc.acc_username,
                        typ.acctype_name,
                        acc.acc_firstname,
                        acc.acc_lastname,
                        acc.acc_dob,
                        acc.acc_gender,
                        acc.acc_school,
                        acc.acc_country 
                        FROM tbl_account acc 
                        INNER JOIN tbl_account_type typ 
                        ON acc.acc_type_id=typ.acctype_id
                        WHERE acc.acc_username='".$this->sqlEsc($prName)."'";
        }
    }
?>