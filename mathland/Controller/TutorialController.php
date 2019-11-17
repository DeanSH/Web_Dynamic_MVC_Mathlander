<?php 
    // Loads in the Data Models and functions
    require_once("Model//ViewModel.php");
    require_once("Model//TutorialModel.php");
    require_once("Model//UserModel.php");
    
    // Creates a class that forms this controller
    class TutController
    {

        //Declared Data Model Variables
        public $viewModel;
        public $userModel;
        public $tutorialModel;
        
        // Contructor that runs the control checks against a command, 
        //sets general page properties and then returns appropriate views!
        function __construct(){

            //Instantiate Data Models into Variables
            $this->viewModel = new ViewModel($this);
            $this->userModel = new UserModel($this);
            $this->tutorialModel = new TutorialModel($this);
            
            // Check case, and for all cases it must get and build the comments html list for current tutorial being displayed
            if(isset($_REQUEST["cmd"]))
               switch($_REQUEST["cmd"]){

                    case "next":   // Goto next tutorial              
                        $this->tutorialModel->next();
                        $lcTutorial = "Tut".$this->tutorialModel->currentTutorial;
                        $this->tutorialModel->getComments($lcTutorial);
                        $this->viewModel->getView("TutorialView.php","","",$this->viewModel->subViewName($lcTutorial));
                        break;

                    case "prev":  // goto previous tutorial
                        $this->tutorialModel->prev();
                        $lcTutorial = "Tut".$this->tutorialModel->currentTutorial;
                        $this->tutorialModel->getComments($lcTutorial);
                        $this->viewModel->getView("TutorialView.php","","",$this->viewModel->subViewName($lcTutorial));
                        break;

                   case "send":  // Support for Ajax http request Javascript style not Jquery. Sends comment only if logged in.
                        $lcTutorial = "Tut".$this->tutorialModel->currentTutorial;
                        if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                        {
                            $this->tutorialModel->sendComment($lcTutorial,$this->userModel->acc_id);
                        }
                        $this->tutorialModel->getComments($lcTutorial); // refresh the comments list for display
                        echo $this->tutorialModel->comments; // echo the updated comments list for the response to update display
                        return;

                    default: // by default load the current tutorial
                        $lcTutorial = "Tut".$this->tutorialModel->currentTutorial;
                        $this->tutorialModel->getComments($lcTutorial);
                        $this->viewModel->getView("TutorialView.php","","",$this->viewModel->subViewName($lcTutorial));
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
    $TutController = new TutController();
?>