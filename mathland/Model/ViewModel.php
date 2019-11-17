<?php
    // This View Model class contains a model of the variables that are shared across all views (dynamically),
    // and uses the name of a view to pull the variant data from the DB prior to displaying the page.
    // It also handles recording/tracking and displaying the navigation history of a logged in account

    // NOTE: this is infact a Model and behaves as such, so NO its not just a view helper and NO it does not belong in Views

    require_once("Model//DBconnection.php");
    // Class to support reusable dynamic feilds for views
    class ViewModel
    {
        private $myController;
        
        //Variables that are reusable by each view to dynamically change feilds
        public $view_id = 1;
        public $view =  "HomeView.php";
        public $title = "Mathland - Learning has never been more fun!";
        public $description = "";
        public $error = "";
        public $nav_info= "";
        public $nav_history = "";
        
        function __construct($pMyController)
        {
            $this->myController = $pMyController;
        }
        
        // reusable function that pulls view data from the DB, updating shared view variables with DB details and details from parameters
        function getView($prView, $prTitle, $prError, $prNavInfo)
        {
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->get_view($prView));
            if ($aDB->num_rows() > 0)
            {
                $aRow = $aDB->next();
                //Set the local view variables to be the view data returned from DB
                $this->view_id = $aRow["view_id"];
                $this->view = $aRow["view_name"];
                $this->title = $aRow["view_title"];
                $this->description = $aRow["view_description"];
                //Set local view variables to be the data passed in through parameters
                if (! $prTitle == "") // Override the Title returned from database if one was specified
                    $this->title = $prTitle;
                $this->error = $prError;
                $this->nav_info = $prNavInfo;
            }
        }
        
        function insertNavHistory($prAccID)
        {// Inserts Navigation history about logged in users to the DB, the View name and sometimes extra information like name of profile
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->insert_nav_history($prAccID,$this->view_id,$this->nav_info));
        }
        
        function getNavHistory($prAccID){
        // Get Nav History and build html list for display on home page to logged in users  - 
            $lcHistory = "<dl>";
            $aDB = new DBConnection();
            $aDB->query($aDB->sql->get_nav_history($prAccID));
            if ($aDB->num_rows() > 0)
            {
                for( $i = 0; $i<$aDB->num_rows(); $i++ ) {
                    $aRow = $aDB->next();
                    $lcHistory = $lcHistory.'<dt><b>'.$aRow['acc_nav_timestamp'].'</b></dt><dd>'.$aRow['view_name'].' '.$aRow['nav_info'].'</dd><hr>';
                }          
            }
            $lcHistory = $lcHistory."</dl>"; 
            $this->nav_history = $lcHistory;
        }
       

        function subViewName($prSubView){
        // Parse subview tutorial numbering into the word representation of said tutotial, this should really be moved to the DB in future
            $lcName;
            switch($prSubView){
                case "Tut1": 
                    $lcName = "Addition";
                    break;
                case "Tut2":
                    $lcName = "Subtraction";
                    break;
                case "Tut3":
                    $lcName = "Multiplication";
                    break;
                case "Tut4":
                    $lcName = "Subtraction";
                    break;
                default: 
                    $lcName = "Addition";
            }
            return $lcName;
        }
    }
?>