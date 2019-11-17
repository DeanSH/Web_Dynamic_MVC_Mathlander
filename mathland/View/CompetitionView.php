<html>
    <?php
        require_once("SubViews//HeadView.php") // imports reusable HEAD for views
    ?>
    <body>
        <!-- Container fluid to make it full screen width -->
        <div class="container-fluid">
            <?php
                require_once("SubViews//NavView.php") // imports reusable navigation bar
            ?>
            <div class="myform" style="text-align:center;">
                <h1><?=$this->viewModel->title?></h1>
                <h2 id="error" style="color:red;"><?=$this->viewModel->error?></h2><!-- shows entry errors if any -->
                <br>
                <?php
                    // Checks if logged in users account type is Learner
                    if($this->competitionModel->comp_email == "")
                    {
                ?>
                <!-- View data seen if user has not subscribed to the competition yet -->
                <br>
                <!-- Competition Subscribe Form with all feilds required -->
                <form name="frmCompetition" method="post" action="?ctr=CompetitionController&cmd=enter" 
                    onsubmit="return validateCompetition()">
                    Contact Email:<br>
                    <input type="email" id="email" name="email" value="" required><br>
                    Your Classroom:<br>
                    <input type="text" id="classroom" name="classroom" value="" required><br>
                    Nominated School:<br>
                    <input type="text" id="school" name="school" value="" required><br>
                    School Phone:<br>
                    <input type="text" id="phone" name="phone" value="" required><br>
                    <input type="hidden" id="ques_id" name="ques_id" value="<?=$this->competitionModel->comp_ques_id?>" required><br>
                    Math Question:<br>
                    <label name="question">
                        <?=$this->competitionModel->comp_ques_txt?>
                    </label><br>
                    <input type="radio" name="opt" value="<?=$this->competitionModel->comp_ques_opt1?>" checked>
                    <?=$this->competitionModel->comp_ques_opt1?> 
                    <input type="radio" name="opt" value="<?=$this->competitionModel->comp_ques_opt2?>"> 
                    <?=$this->competitionModel->comp_ques_opt2?> 
                    <input type="radio" name="opt" value="<?=$this->competitionModel->comp_ques_opt3?>"> 
                    <?=$this->competitionModel->comp_ques_opt3?><br>
                    <br>
                    <button type="submit">Enter Draw</button>
                </form>
                <br>
                Mathland is running a Competition to WIN your School a FREE Computer!!<br>
                Complete and Nominate a School in the form below to Enter!<br>
                Note: Limited to 1 Entry per User.<br>
                <h2>Answer the Equation Correctly to be in to WIN!</h2>
                <?php
                    // End Showing Competition Subscribe Form for When user has not yet Submitted
                    }
                    else //Else case starts the showing of the Thanks View for is user already Subscribed!
                    {
                ?>
                <!-- View data seen if user has subscribed to the competition (Thanks + Subscribed Details) -->
                <h2>Thanks you have Entered the Competition!!</h2>
                <br>
                Your in with a chance to WIN your School a FREE Computer!!<br>
                <br>
                Here's the details you entered!<br>
                <br>
                Contact Email: <?=$this->competitionModel->comp_email?><br>
                Your Classroom: <?=$this->competitionModel->comp_classroom?><br>
                Nominated School: <?=$this->competitionModel->comp_school?><br>
                School Phone: <?=$this->competitionModel->comp_school_ph?><br>
                <br>
                Math Question:<br>
                <?=$this->competitionModel->comp_ques_txt?><br>
                You Answered... <?=$this->competitionModel->comp_ques_opt?>!<br>
                <br>
                <?php
                    // End Showing Thanks message seen when a user has already Successfully Subscribed!
                    }
                ?>
            </div>
            <?php
                require_once("SubViews//FooterView.php") // imports reusable footer
            ?>
        </div>
        <!-- Load in the script containing form validations -->
        <script type="text/javascript" src="js//validation.js"></script>
    </body>
</html>