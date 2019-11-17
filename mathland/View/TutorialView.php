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
            <div class="myinfo" style="text-align:center;">
                <?php
                    // imports current tutorial based on current tutorial number
                    include("TutorialDetails//Tut".$this->tutorialModel->currentTutorial.".php");

                    // Below Shows the Previous or Next tutorial navigations accordingly
                    if($this->tutorialModel->currentTutorial > $this->tutorialModel->min){
                ?>    
                <a href="?ctr=TutorialController&cmd=prev"> << Prev Tutorial |</a>
                <?php 
                    } else { 
                ?>
                First Tutorial | 
                <?php 
                    }
                    if($this->tutorialModel->currentTutorial < $this->tutorialModel->max)
                    {
                ?>    
                <a href="?ctr=TutorialController&cmd=next"> Next Tutorial >></a>
                <?php 
                    } else { 
                ?>
                Last Tutorial
                <?php 
                    } 
                ?>
                <br>
                <!-- Tutorial Comment Box and Display -->
                <div class="row">
                    <div class="col-lg-3 col-md-3 d-none d-sm-block"></div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <br>
                        <h2>Comments:</h2><!-- Display comments in a scrolly box -->
                        <div id="comments" class="myinfoborder myscrollybox">
                            <?=$this->tutorialModel->comments?>
                        </div>
                        <br>
                        <?php
                            // Checks if the user is logged in, if so the text box and button for commenting is displayed
                            if(isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                            {
                        ?>
                        <input type="text" id="commentField" value="" style="width:90%; max-width:500px;"><br>
	                    <input type="button" value="Send Comment" onclick="send((document.getElementById('commentField')).value);">
                        <?php
                            } //NOTE: Commenting displays current tutorials comments only, and sends using javascripts xmlhttprequest.
                        ?>
                    </div>
                    <div class="col-lg-3 col-md-3 d-none d-sm-block"></div>
                </div>
            </div>
            <?php
                require_once("SubViews//FooterView.php") // imports reusable footer
            ?>
        </div>
        <!-- Comment Box Script To Send New Comment and Update in page display -->
        <script src="js//ajaxcomments.js"></script>
        <!-- Video player JavaScript to support 5 players per tutorial sub view -->
        <script src="js//video.popup.js"></script>
        <script src="js//video.handlers.js"></script>
    </body>
</html>