<?php
    require_once("Model//DBconnection.php");
    // Class to support multiple tutorials navigations
    class TutorialModel
    {
        private $myController;
        
        public $comments; // Variable that holds the list of comments for the current tutorial
        public $max = 4;
        public $min = 1;
        public $currentTutorial = 1;

        private function getCurrentTutorial(){
        // Checks if a specific Tut was requested.
        // Otherwise then checks for the last tut session if any.
        // Otherwise returns the current or default tutorial.

            $lcResult = $this->currentTutorial; 

            if( isset($_REQUEST["tut"])){
                $lcResult = intval($_REQUEST["tut"]);
                return $lcResult;
            }
            else if (isset($_SESSION["tut"])){
                $lcResult = intval($_SESSION["tut"]);
                return $lcResult;
            }
            return $lcResult;
        }

        //Constructor for when instantiated
        function __construct($pMyController)
        {
            $this->myController = $pMyController;
            $this->currentTutorial = $this->getCurrentTutorial();
        }

        function next(){
        // Next Logic  - 

            $proposedTut  = $this->currentTutorial;

            if( ($proposedTut + 1) <= $this->max)
             $proposedTut = $proposedTut + 1;

            $this->currentTutorial =  $proposedTut;
            $_SESSION["tut"] = $this->currentTutorial;
        }

        function prev(){
        // Previous Logic  - 

            $proposedTut  = $this->currentTutorial;

            if( ($proposedTut - 1) >= $this->min)
             $proposedTut = $proposedTut - 1;

            $this->currentTutorial =  $proposedTut;
            $_SESSION["tut"] = $this->currentTutorial;
        }
        
        function getComments($prSection){
        // Get comments from DB and constructs a HTML list ready for display with account names for comments clickable to goto profiles
            $lcComments = "<dl>";
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->get_comments($prSection));
            if ($aDB->num_rows() > 0)
            {
                for( $i = 0; $i<$aDB->num_rows(); $i++ ) {
                    $aRow = $aDB->next();
                    $lcComments = $lcComments.'<dt><b><a href="?ctr=LoginController&cmd=showProfile&name='.$aRow['acc_username'].'">'.$aRow['acc_username'].'</a>
                    </b> ('.$aRow['comment_timestamp'].'):</dt><dd>'.$aRow['comment_txt'].'</dd><hr>';
                }
                $lcComments = $lcComments."</dl>";
                $this->comments = $lcComments;            
            }
        }
        
        function sendComment($prSection,$prAccID){
        // Inserts a comment into the database, according to tutorial section, account id and the comment text
            //Check no feilds have been manipulated to be blank
            if(!empty($_POST["comment"]) && isset($_POST["comment"]))
            {   
                $aDB = new DBConnection();
                $aDB->query($aDB->sql->insert_comment($prSection,$prAccID,$_POST["comment"]));
            }
        }
    }
?>
    