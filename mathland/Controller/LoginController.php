<?php
    // Loads in the Data Models and functions
    require_once("Model//ViewModel.php");
    require_once("Model//TutorialModel.php");
    require_once("Model//UserModel.php");

    // Creates a class that forms this controller
    class LoginController
    {

        //Declared Data Model Variables
        public $viewModel;
        public $userModel;
        public $tutorialModel;
        
        // Contructor that runs the control checks against a command, 
        // sets general page properties and called model functions
        // according to state, and then returns appropriate views!
        function __construct(){

            //Instantiate Data Models into Variables
            $this->viewModel = new ViewModel($this);
            $this->userModel = new UserModel($this);
            $this->tutorialModel = new TutorialModel($this);
            
            // Check first that there was a command
            if(isset($_REQUEST["cmd"]))
            switch($_REQUEST["cmd"]){
                case "login": 
                    $this->userModel->login(); // Calls the function in model to do a login check
                    // Then checks if login was successful by a model variable being blank or not!
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                    {
                        //If login successful send user to the home page and load navigation history and trainer statistics
                        $this->viewModel->getView("HomeView.php","","","");
                        $this->viewModel->getNavHistory($this->userModel->acc_id);
                        $this->userModel->getTrainerScores($this->userModel->acc_id);
                    } else {
                        // If login failed keep user on login page and show error
                        $this->viewModel->getView("LoginView.php","","Incorrect Username or Password!","");
                    }
                    break;
                case "logout": 
                    // Calls the logout function in the data model and sends user to the login screen
                    $this->userModel->logout();
                    $this->viewModel->getView("LoginView.php","","","");
                    break;
                case "register": 
                    // Calls the register function in the data model that creates an account
                    $this->userModel->register();
                    // Checks if creation was successful and user is now logged in!
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                    {
                        // If now logged in then registration was a success, redirect user to home page
                        $this->viewModel->getView("HomeView.php","","","");
                        $this->viewModel->getNavHistory($this->userModel->acc_id);
                        $this->userModel->getTrainerScores($this->userModel->acc_id);
                    } else {
                        //If registration fails and not now logged in, keep user on registration page
                        $this->viewModel->getView("RegisterView.php","","Registration Failed!","");
                    }
                    break;
                case "showProfile": 
                    // Validate there is a name for the profile being requested
                    if (isset($_REQUEST["name"]) && !empty($_REQUEST["name"]))
                    {
                        // If valid name, Check if name requested exists?
                        // Currently setup to check the single account in model for testing
                        $who = $_REQUEST["name"];
                        if ($this->userModel->getprofile($who) == 1)
                        {
                            //If exist then show the profile
                            $this->viewModel->getView("ProfileView.php","Mathland - Profile for ".$who."!","",$who); 
                        } else {
                            //If no such account show error message on profile page
                            $this->viewModel->getView("ProfileView.php","","Error! Profile does not exist!","");
                        }
                    } else {
                        // If no name was given to get profile for, something has gone teribly wrong
                        // Likely foul play or user is no longer logged in, so double check logged out,
                        // Then direct user to the login page.
                        $this->userModel->logout();
                        $this->viewModel->getView("LoginView.php","","Something went wrong!","");
                    }
                    break;
                case "updateProfile": 
                    // Support for updating certain fields of a profile, email, first and last name, school and country.
                    // Checks user is logged in, a name value was passed in, and name matches the users name!
                    // Prevents others from modifying anyone elses profiles, only their own is possible.
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser) 
                        && isset($_GET["name"]) && !empty($_GET["name"]) && $this->userModel->currentUser==$_GET["name"])
                    {
                        $who = $_GET["name"];
                        // Calls to update the info and then refreshs the profile page to show new details
                        if ($this->userModel->updateProfile() == 1)
                        {
                            $this->viewModel->getView("ProfileView.php","Mathland - Profile for ".$who."!","Profile has been updated!",$who);
                        }
                        else
                        {
                            $this->viewModel->getView("ProfileView.php","Mathland - Profile for ".$who."!","Error! Profile update failed",$who);
                        }
                    } else {
                        // if failed security checks, logout user incase logged in, and direct to login window
                        // This should actually never happen, because profile edit features only ever show,
                        // When the logged in user views their own profile, edit options dont display if a
                        // Logged in user is looking at someone elses profile.
                        $this->userModel->logout();
                        $this->viewModel->getView("LoginView.php","","Something went wrong!","");
                    }
                    break;
                case "updatePassword": 
                    // Support for updating account password.
                    // Checks user is logged in, a name value was passed in, and name matches the users name!
                    // Prevents others from modifying anyone elses passwords, only their own is possible.
                    if (isset($this->userModel->currentUser) && !empty($this->userModel->currentUser) 
                        && isset($_GET["name"]) && !empty($_GET["name"]) && $this->userModel->currentUser==$_GET["name"])
                    {
                        $who = $_GET["name"];
                        // Calls to update the info and then refreshs the profile page to show new details
                        if ($this->userModel->updatePassword() == 1)
                        {
                            $this->viewModel->getView("ProfileView.php","Mathland - Profile for ".$who."!","Password has been updated!",$who);
                        }
                        else
                        { // If password updating fails
                            $this->viewModel->getView("ProfileView.php","Mathland - Profile for ".$who."!","Error! Password update failed",$who);
                        }
                    } else {
                        // if failed security checks, logout user incase logged in, and direct to login window
                        // This should actually never happen, because profile edit features only ever show,
                        // When the logged in user views their own profile, edit options dont display if a
                        // Logged in user is looking at someone elses profile.
                        $this->userModel->logout();
                        $this->viewModel->getView("LoginView.php","","Something went wrong!","");
                    }
                    break;
                case "showLogin": 
                    $this->viewModel->getView("LoginView.php","","","");
                    break;
                case "showRegister": 
                    $this->viewModel->getView("RegisterView.php","","","");
                    break;
                default: 
                    $this->viewModel->getView("LoginView.php","","","");
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
    $LoginController = new LoginController();
?>