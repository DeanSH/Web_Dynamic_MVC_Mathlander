<?php
    // Loads in the Data Models and functions
    require_once("Model//ViewModel.php");
    require_once("Model//TutorialModel.php");
    require_once("Model//UserModel.php");

    // Creates a class that forms this controller
    class NavController
    {
        //Declared Data Model Variables
        public $viewModel;
        public $userModel;
        public $tutorialModel;
        
        // Contructor that runs the control checks against a command, 
        // sets general page properties and then returns appropriate views
        function __construct(){

            //Instantiate Data Models into Variables
            $this->viewModel = new ViewModel($this);
            $this->userModel = new UserModel($this);
            $this->tutorialModel = new TutorialModel($this);
            
            if(isset($_REQUEST["cmd"]))
            switch($_REQUEST["cmd"]){
                case "home": 
                    $this->viewModel->getView("HomeView.php","","","");
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                    { // If user logged in then get navigation and trainer statistics for display
                        $this->viewModel->getNavHistory($this->userModel->acc_id);
                        $this->userModel->getTrainerScores($this->userModel->acc_id);
                    }
                    break;
                case "about":
                    $this->viewModel->getView("AboutView.php","","","");
                    break;
                case "prac":
                    $this->viewModel->getView("PracticeView.php","","","");
                    break;
                case "game":
                    $this->viewModel->getView("TrainerView.php","","","");
                    break;
                case "tutorials": // Load comments for current tutorial being viewed, and get view data
                    $lcTutorial = "Tut".$this->tutorialModel->currentTutorial;
                    $this->tutorialModel->getComments($lcTutorial);
                    $this->viewModel->getView("TutorialView.php","","",$this->viewModel->subViewName($lcTutorial));
                    break;
                case "score":
                    // Track Scores from Trainer! Only if logged in, uses Jquery Ajax call to do this, hence the return and not break
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                    {
                        $this->userModel->insertTrainerScore($this->userModel->acc_id);
                    }
                    echo "Trainer Score Saved!";
                    return;
                default: 
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
    $NavController = new NavController();
?>