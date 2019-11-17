<?php
    require_once("Model//DBconnection.php");
    // Class to support data for a user
    class UserModel
    {
        private $myController;
        
        // Single Account Information for testing purposes and proof of concept, set using register feature
        public $acc_id;
        public $username;
        public $usertype;
        public $firstname;
        public $lastname;
        public $email;
        public $dob;
        public $gender;
        public $school;
        public $country;

        public $currentUser; //Blank when logged out, Contains username when logged in (currently verifies if user is logged in)
        
        public $trainer_scores; // Holds the list of Trainer Scores for the logged in account, updated if navigating to the home page
        
        function __construct($pMyController)
        {
            $this->myController = $pMyController;
            // when the model class constructs it populates the model variables from currently stored session variables
            if (isset($_SESSION["acc_id"])) $this->acc_id = $_SESSION["acc_id"];
            if (isset($_SESSION["name"])) $this->username = $_SESSION["name"];
            if (isset($_SESSION["type"])) $this->usertype = $_SESSION["type"];
            if (isset($_SESSION["first"])) $this->firstname = $_SESSION["first"];
            if (isset($_SESSION["last"])) $this->lastname = $_SESSION["last"];
            if (isset($_SESSION["email"])) $this->email = $_SESSION["email"];
            if (isset($_SESSION["dob"])) $this->dob = $_SESSION["dob"];
            if (isset($_SESSION["gender"])) $this->gender = $_SESSION["gender"];
            if (isset($_SESSION["school"])) $this->school = $_SESSION["school"];
            if (isset($_SESSION["country"])) $this->country = $_SESSION["country"];
            if (isset($_SESSION["user"])) $this->currentUser = $_SESSION["user"];
        }

        function logout(){
        // Logout Logic  - 
            $this->currentUser = ""; // Set the variable and session variable blank to currently indicate not logged in
            $_SESSION["user"] = $this->currentUser;
        }

        function register(){
        // register Logic  -  
            //Doule check all feilds passed through
            if(isset($_POST["name"]) && isset($_POST["pass"]) && isset($_POST["type"]) 
               && isset($_POST["first"]) && isset($_POST["last"]) && isset($_POST["email"])
               && isset($_POST["dob"]) && isset($_POST["gender"]) && isset($_POST["school"]) 
               && isset($_POST["country"]))
            {
                //Double check no feilds have been manipulated into blank
                if(!empty($_POST["name"]) && !empty($_POST["pass"]) && !empty($_POST["type"]) 
                   && !empty($_POST["first"]) && !empty($_POST["last"]) && !empty($_POST["email"])
                   && !empty($_POST["dob"]) && !empty($_POST["gender"]) && !empty($_POST["school"]) 
                   && !empty($_POST["country"]))
                {
                    $aDB = new DBConnection();
                    $aDB->query($aDB->sql->get_acc_available());
                    if ($aDB->num_rows() > 0)
                    {
                        //Account already exists so do nothing and page displays an error
                    }
                    else
                    {
                        $aDB->free();
                        $aDB->query($aDB->sql->get_acc_type_id());
                        if ($aDB->num_rows() > 0)
                        {
                            $aRow = $aDB->next();
                            $aDB->query($aDB->sql->insert_new_acc($aRow["acctype_id"]));
                            $this->checklogin($_POST["name"],$_POST["pass"]);
                            return;
                        }
                    }
                    $aDB->free();
                }
            }
        }

        function updateProfile(){
        // update account/change password info Logic
            //Check all fields expected are passed, nothing more and nothing less for security reasons
            if(isset($_POST["email"]) && isset($_POST["first"]) && isset($_POST["last"])
                 && isset($_POST["school"]) && isset($_POST["country"]))
            {
                //Check no feilds have been manipulated to be blank
                if(!empty($_POST["email"]) && !empty($_POST["first"]) && !empty($_POST["last"])
                     && !empty($_POST["school"]) && !empty($_POST["country"]))
                {
                    $aDB = new DBConnection();
                    //Update the editable local variables
                    $this->email = $aDB->sql->sqlEsc($_POST["email"]);
                    $this->firstname = $aDB->sql->sqlEsc($_POST["first"]);
                    $this->lastname = $aDB->sql->sqlEsc($_POST["last"]);
                    $this->school = $aDB->sql->sqlEsc($_POST["school"]);
                    $this->country = $aDB->sql->sqlEsc($_POST["country"]);
                    //Update the stored session variables to match new changes
                    $_SESSION["email"] = $this->email;
                    $_SESSION["first"] = $this->firstname;
                    $_SESSION["last"] = $this->lastname;
                    $_SESSION["school"] = $this->school;
                    $_SESSION["country"] = $this->country;
                    //Update account details in the database
                    $aDB->query($aDB->sql->update_acc_info($this));
                    return 1;
                }
            }
            return 0;
        }

        function updatePassword(){
            // update account/change password info Logic
                //Check all fields expected are passed, nothing more and nothing less for security reasons
                if(isset($_POST["oldpass"]) && isset($_POST["pass"]) && isset($_POST["newpass"]))
                {
                    //Check no feilds have been manipulated to be blank
                    if(!empty($_POST["oldpass"]) && !empty($_POST["pass"]) && !empty($_POST["newpass"]))
                    {
                        //Double Check that password typed and then retyped truely matched
                        if ($_POST["pass"] == $_POST["newpass"])
                        {
                            //Update account password in the database
                            $aDB = new DBConnection();
                            $aDB->query($aDB->sql->get_acc_pass_auth($this->acc_id));
                            if($aDB->num_rows() > 0)
                            {
                                $aDB->query($aDB->sql->update_acc_pass($this->acc_id));
                                return 1;
                            }
                        }
                    }
                }
                return 0;
            }

        function login(){
        // Login Logic  -  Checks Name match, then password match before setting name for currentUser variable       
            if( isset($_POST["name"])) 
            {
                $name = $_POST["name"];
                if( isset($_POST["pass"])) 
                {
                    $pass = $_POST["pass"];
                    $this->checklogin($name,$pass);        
                }
            }
        }
        
        function checklogin($prName,$prPass){
        // Login Logic  -  Checks Name match, then password match before setting name for currentUser variable       
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->get_acc_login($prName,$prPass));
            if ($aDB->num_rows() > 0)
            {
                // Successfull login
                $aRow = $aDB->next();
                //Set the local account variables to be the account data returned from DB
                $this->acc_id = $aRow["acc_id"];
                $this->username = $aRow["acc_username"];
                $this->usertype = $aRow["acctype_name"];
                $this->firstname = $aRow["acc_firstname"];
                $this->lastname = $aRow["acc_lastname"];
                $this->email = $aRow["acc_email"];
                $this->dob = $aRow["acc_dob"];
                $this->gender = $this->getGender($aRow["acc_gender"]);
                $this->school = $aRow["acc_school"];
                $this->country = $aRow["acc_country"];
                //Save the logged in account to the current session for state persistance
                $_SESSION["acc_id"] = $this->acc_id;
                $_SESSION["name"] = $this->username;
                $_SESSION["type"] = $this->usertype;
                $_SESSION["first"] = $this->firstname;
                $_SESSION["last"] = $this->lastname;
                $_SESSION["email"] = $this->email;
                $_SESSION["dob"] = $this->dob;
                $_SESSION["gender"] = $this->gender;
                $_SESSION["school"] = $this->school;
                $_SESSION["country"] = $this->country;
                $this->currentUser = $this->username;
                $_SESSION["user"] = $this->currentUser;
                $aDB->free();
                return;        
            }
            //If makes it here then failed to login and double checks the state is set to logged out
            $this->currentUser = "";
            $_SESSION["user"] = $this->currentUser;
            $aDB->free();
        }

        function getprofile($prName){
            // Login Logic  -  Checks Name match, then password match before setting name for currentUser variable       
            $isFound = 0;
            $this->username = "";    
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->get_acc_profile($prName));
            if ($aDB->num_rows() > 0)
            {
                // Successfull login
                $aRow = $aDB->next();
                //Set the local account variables to be the account data returned from DB!
                $this->username = $aRow["acc_username"];
                $this->usertype = $aRow["acctype_name"];
                $this->firstname = $aRow["acc_firstname"];
                $this->lastname = $aRow["acc_lastname"];
                $this->dob = $aRow["acc_dob"];
                $this->gender = $this->getGender($aRow["acc_gender"]);
                $this->school = $aRow["acc_school"];
                $this->country = $aRow["acc_country"]; 
                $isFound = 1;    
            }
            $aDB->free();
            return $isFound;
        }
        
        function getAge($date) { // Y-m-d format to match database format
            return intval(substr(date('Ymd') - date('Ymd', strtotime($date)), 0, -4));
        }

        function getGender($prGender){ // Changes the single character into Word form for display on profiles
            if ($prGender == "M")
                return "Male";
            elseif ($prGender == "F")
                return "Female";
            else
                return "Other";
        }
        
        function insertTrainerScore($prAccID)
        { // Insert Trainer Score for an Acc
            // Checks each needed field exists
            if(isset($_POST["total"]) && isset($_POST["timeouts"]) && isset($_POST["mins"])
                 && isset($_POST["secs"]))
            {
                $aDB = new DBConnection();
                $aDB->query($aDB->sql->insert_trainer_score($prAccID,$_POST["total"],$_POST["timeouts"],$_POST["mins"],$_POST["secs"]));
            }
        }
        
        function getTrainerScores($prAccID){
        // Get Trainer Scores History for account built into a html list ready for display on home page
            $lcScores = "<dl>";
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->get_trainer_scores($prAccID));
            if ($aDB->num_rows() > 0)
            {
                for( $i = 0; $i<$aDB->num_rows(); $i++ ) {
                    $aRow = $aDB->next();
                    $lcScores = $lcScores.'<dt><b>'.$aRow['trainer_timestamp'].'</b></dt><dd>In '
                                .$aRow['trainer_mins'].' minutes you scored '.$aRow['trainer_score'].' correct answers!<br>You wiped out '
                                .$aRow['trainer_timeouts'].' times, at '.$aRow['trainer_secs'].' seconds per question!</dd><hr>';
                }
                $lcScores = $lcScores."</dl>"; 
            }
            else
            {
                $lcScores = "<dl><dt><b>No Speed Trainer Game Scores Recorded!</b></dt>
                                <dd>Challenge your speed skills and go play the Speed Trainer Game today!</dd></dl>";
            }
            $this->trainer_scores = $lcScores;
        }
        
    }
?>