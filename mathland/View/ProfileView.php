<html>
    <?php
        require_once("SubViews//HeadView.php")  // imports reusable HEAD for views
    ?>
    <body>
        <!-- Container fluid to make it full screen width -->
        <div class="container-fluid">
            <?php
                require_once("SubViews//NavView.php")   // imports reusable navigation bar
            ?>
            <!-- start of the box container for profile details / editing -->
            <div class="myform" style="text-align:center;">
                <h1><?=$this->viewModel->title?></h1>
                <h2 id="error" style="color:red;"><?=$this->viewModel->error?></h2> <!-- shows nothing unless there was an error or profile updated -->
                <br>
                <?php
                    // Checks first if any error was identified by the controller
                    if(!empty($this->userModel->username))
                    {
                ?>
                <!-- Display Username, Account Type, Gender and Age of profile account -->
                Username: <?=$this->userModel->username?><br>
                <br>
                Account Type: <?=$this->userModel->usertype?><br>
                <br>
                Gender: <?=$this->userModel->gender?><br>
                <br>
                Age: <?=$this->userModel->getAge($this->userModel->dob)?><br>
                <br>
                <?php
                        // Checks if profile viewed belongs to the veiwer to show/hide editing ability
                        if($this->userModel->username == $this->userModel->currentUser)
                        {
                ?>
                <!-- Script to enabled editing and make profile display support form functions if view own profile -->
                <script type="text/javascript">
                    function editDetails() {
                        x=document.getElementById("email")
                        x.type = "email";
                        x=document.getElementById("first")
                        x.type = "text";
                        x=document.getElementById("last")
                        x.type = "text";
                        x=document.getElementById("school")
                        x.type = "text";
                        x=document.getElementById("country")
                        x.type = "text";
                        x=document.getElementById("edit")
                        x.disabled = !x.disabled;
                        x=document.getElementById("update")
                        x.disabled = !x.disabled;
                    }
                    function editPassword() {
                        x=document.getElementById("oldpass")
                        x.disabled = !x.disabled;
                        x=document.getElementById("pass")
                        x.disabled = !x.disabled;
                        x=document.getElementById("newpass")
                        x.disabled = !x.disabled;
                        x=document.getElementById("updatepass")
                        x.disabled = !x.disabled;
                        x=document.getElementById("editpass")
                        x.disabled = !x.disabled;
                    }
                </script>
                <form name="frmProfile" method="post" action="?ctr=LoginController&cmd=updateProfile&name=<?=$this->userModel->username?>"
                    onsubmit="return validateProfileChange()">
                    <!-- Shows the private profile details, and has hidden input feilds for possibly supporting editing -->
                    Email: <?=$this->userModel->email?><br>
                    <input type="hidden" id="email" name="email" value="<?=$this->userModel->email?>" required><br>
                <?php
                        }
                ?>
                    <!-- Shows the public profile details, and has hidden input feilds for possibly supporting editing -->
                    First Name: <?=$this->userModel->firstname?><br>
                    <input type="hidden" id="first" name="first" value="<?=$this->userModel->firstname?>" required><br>
                    Last Name: <?=$this->userModel->lastname?><br>
                    <input type="hidden" id="last" name="last" value="<?=$this->userModel->lastname?>" required><br>
                    School: <?=$this->userModel->school?><br>
                    <input type="hidden" id="school" name="school" value="<?=$this->userModel->school?>" required><br>
                    Country: <?=$this->userModel->country?><br>
                    <input type="hidden" id="country" name="country" value="<?=$this->userModel->country?>" required><br>
                    <br>
                    <?php
                        // Checks if user is viewing their own profile to support showing buttons etc for editing profile or password
                        if($this->userModel->username == $this->userModel->currentUser)
                        {
                    ?>
                    <input type="button" id="edit" value="EDIT PROFILE" onclick="return editDetails()">
                    <button type="submit" id="update" disabled>UPDATE PROFILE</button>
                </form>
                <br>
                <h2>Change Password!</h2>
                <h2 id="error2" style="color:red;"></h2>
                <br>
                <form name="frmProfile" method="post" action="?ctr=LoginController&cmd=updatePassword&name=<?=$this->userModel->username?>"
                    onsubmit="return validatePassChange()"> 
                    <!-- Shows the password editing support -->
                    Current Password:<br>
                    <input type="password" id="oldpass" name="oldpass" value="" required disabled><br>
                    Desired New Password:<br>
                    <input type="password" id="pass" name="pass" value="" required disabled><br>
                    Retype New Password:<br>
                    <input type="password" id="newpass" name="newpass" value="" required disabled><br>
                    <br>
                    <input type="button" id="editpass" value="EDIT PASSWORD" onclick="return editPassword()">
                    <button type="submit" id="updatepass" disabled>UPDATE PASSWORD</button>
                </form>
                <?php
                        }
                    }
                ?>  
                <br>
                <br>
            </div>
            <?php
                require_once("SubViews//FooterView.php")   // imports reusable footer
            ?>
        </div>
        <!-- Load in the script containing form validations -->
        <script type="text/javascript" src="js//validation.js"></script>
    </body>
</html>