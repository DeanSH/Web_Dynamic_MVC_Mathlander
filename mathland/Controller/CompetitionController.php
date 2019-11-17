<?php
    // Loads in the Data Models and functions
    require_once("Model//ViewModel.php");
    require_once("Model//CompetitionModel.php");
    require_once("Model//UserModel.php");

    // Creates a class that forms this controller
    class CompetitionController
    {

        //Declared Data Model Variables
        public $viewModel;
        public $userModel;
        public $competitionModel;
        
        // Contructor that runs the control checks against a command, 
        // sets general page properties and called model functions
        // according to state, and then returns appropriate views
        function __construct(){

            //Instantiate Data Models into Variables
            $this->viewModel = new ViewModel($this);
            $this->userModel = new UserModel($this);
            $this->competitionModel = new CompetitionModel($this);
            
            // Check first that there was a command
            if(isset($_REQUEST["cmd"]))
            switch($_REQUEST["cmd"]){
                case "load": 
                    // Then checks if login was successful by a model variable being blank or not
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                    {
                        // If logged in send user to competition page & check if has entered already
                        // First Checks Entry, and if none gets a random question
                        $this->competitionModel->get_entry($this->userModel->acc_id);
                        // Directs to the view
                        $this->viewModel->getView("CompetitionView.php","","","");
                        // If already entered the view will show Thanks and Details entered with
                        // If not already entered it shows the entry form with a random question
                    } else {
                        // If not logged in send user to login page
                        $this->viewModel->getView("LoginView.php","","You must be logged in to enter the competition!","");
                    }
                    break;
                case "enter": 
                    // Checks if creation was successful and user is now logged in
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                    {
                        // If logged in then process the competition entry submission and then reload the page
                        // Calls a method to try insert the submission to the database
                        $this->competitionModel->insert_entry($this->userModel->acc_id);
                        // Directs to the view!
                        $this->viewModel->getView("CompetitionView.php","","","");
                        // If successfully entered the view will show Thanks and Details entered with
                        // If not already entered it shows the entry form with a random question
                    } else {
                        //If registration fails and not now logged in, keep user on registration page
                        $this->viewModel->getView("LoginView.php","","","");
                    }
                    break;
                default: 
                    // By default load the home page
                    $this->viewModel->getView("HomeView.php","","","");
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                    { // If user logged in then get navigation and trainer statistics for display
                        $this->viewModel->getNavHistory($this->userModel->acc_id);
                        $this->userModel->getTrainerScores($this->userModel->acc_id);
                    }
            }

            // Track Navigation History if User is Logged in
            if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
            {
                $this->viewModel->insertNavHistory($this->userModel->acc_id);
            }
            // Loads in the appropriate view
            require_once("View//".$this->viewModel->view);
        }

    }

    // Instantiates the controller class, making everything happen
    $CompetitionController = new CompetitionController();
?>