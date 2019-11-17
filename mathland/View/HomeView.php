<html>
    <?php
        require_once("SubViews//HeadView.php") // imports reusable HEAD for views
    ?>
    <body>
        <!-- Container fluid to make it full screen width -->
        <div id="wrapper" class="container-fluid">
            <?php
                require_once("SubViews//NavView.php"); // imports reusable navigation bar
            ?>
            <!-- Bootstrap Alert to advertise the Competition for winning a Computer for Nominated School -->
            <div class="alert alert-info alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>FREE!</strong> Win a powerful computer for your school! <a href="?ctr=CompetitionController&cmd=load" class="alert-link">Enter The Draw Here!</a>.
            </div>
            <!-- Animated Star to advertise the Competition for winning a Computer for Nominated School -->
            <a href="?ctr=CompetitionController&cmd=load"><img id="bouncing-star" src="images//competitionstar.png"></a>
            
            <?php
                // Checks if user is logged in and then returns the home page view according to account type
                if(isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                {
                    // Checks if logged in users account type is Learner
                    if($this->userModel->usertype == "Learner")
                    {
            ?>
            
            <!-- Only Shows if a Learner Logged In / Stacks on mobile -->
            <div class="row">
                <!-- Larger square Area left column for statistics display -->
                <div class="col-lg-8 col-md-8 col-sm-12 nopadding">
                    <div class="mygallerylarge" style="padding-left:10px; padding-right:10px;">
                        <h3 class="myslidetext" style="text-align:center">Statistics Display!</h2>
                        <div class="myinfoborder mysilverbg">
                            <div class="myscrollybox" style="height:86%">
                                <?=$this->userModel->trainer_scores?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right Column split into 2 row areas, Navigation history and Messages -->
                <div class="col-lg-4 col-md-4 col-sm-12 nopadding">
                    <div class="mygallerysmalltext" style="padding-left:10px; padding-right:10px;">
                        <h3 class="myslidetext" style="text-align:center">Activity History</h3>
                        <div class="myinfoborder mysilverbg">
                            <div class="myscrollybox" style="height:71%">
                                <?=$this->viewModel->nav_history?>
                            </div>
                        </div>
                    </div>
                    <div class="mygallerysmall" style="padding-left:10px; padding-right:10px;">
                        <h3 class="myslidetext" style="text-align:center">Messages</h3>
                        <div class="myinfoborder mysilverbg">
                            <div class="myscrollybox" style="height:71%">
                                <p class="mygallerytext" style="text-align:center">
                                Messages From Educators Will Show Here! Tasks To Do, Feedback, Etc!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
                } else {
            ?>
            
            <!-- Only Shows if an Educator Logged In / Stacks on mobile -->
            <div class="row">
                <!-- 1st column Text Areas -->
                <div class="col-lg-4 col-md-4 col-sm-12 nopadding myinfoborder">
                    <div class="mygallerysmalltext myborder" style="padding-left:10px; padding-right:10px;">
                        <br>
                        <br>
                        <br>
                        <h3 class="myinfotext" style="text-align:center">Groups</h3>
                        <p class="mygallerytext" style="text-align:center">
                        Groups Selection / Management Goes Here!
                        </p>
                    </div>
                    <div class="mygallerysmall nopadding myinfoborder d-none d-md-block">
                        <br>
                        <br>
                        <br>
                        <h3 class="myinfotext" style="text-align:center">Learners</h3>
                        <p class="mygallerytext" style="text-align:center">
                        Learners For Currently Selected Group Show Here!
                        </p>
                    </div>
                </div>
                <!-- 2nd Coloumn larger square area for statistics display -->
                <div class="col-lg-8 col-md-8 col-sm-12 mygallerylarge nopadding myinfoborder">
                    <img class="mygalleryimages" alt="Space to Show Statistics" 
                        src="images//placeholder.png">
                    <div class="carousel-caption">
                        <h2 class="myslidetext">Statistics Display!</h2>
                    </div>
                </div>
            </div>
            
            <?php
                    }
                } else {
                // Else case for if user is not logged in, then show standard home page!
            ?>
            
            <!-- Slideshow with Header 1 Text and Header 2 for seo on captions -->
            <div class="row myslide myborder">
                <div class="col-md-12 nopadding">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li class="active" data-slide-to="0" data-target="#carouselExampleIndicators">
                            </li>
                            <li data-slide-to="1" data-target="#carouselExampleIndicators">
                            </li>
                            <li data-slide-to="2" data-target="#carouselExampleIndicators">
                            </li>
                        </ol>
                        <!-- Images and captions for images-->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100 myslideimage" src="images//placeholder.png" 									alt="Slide Image 1">
                                <!-- Captions for images, hides on mobile view -->
                                <div class="carousel-caption d-none d-md-block">
                                    <h1 class="myheadertext">Mathland</h1>
                                    <h2 class="myslidetext">Making it Fun</h2>
                                    <p style="color:black;">
                                        <strong><em>Easy</em> for all ages!</strong>
                                    </p>
                                </div>
                            </div>						
                            <div class="carousel-item">
                                <img class="d-block w-100 myslideimage" src="images//placeholder.png"
                                     alt="Slide Image 2">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1 class="myheadertext">Tutorials</h1>
                                    <h2 class="myslidetext">Hints and Tips</h2>
                                    <p style="color:black;">
                                        <strong>Accompanied by <em>Visual Aids</em></strong>
                                    </p>
                                </div>
                            </div>						
                            <div class="carousel-item">
                                <img class="d-block w-100 myslideimage" src="images//placeholder.png"
                                     alt="Slide image 3">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1 class="myheadertext">Math Trainer</h1>
                                    <h2 class="myslidetext">Master your skills</h2>
                                    <p style="color:black;">
                                        <strong>Add, Subtract, Divide or Multiply, <em>Help is here!</em></strong>
                                    </p>
                                </div>
                            </div>				
                        </div>
                        <!-- Navigate next or previous image slide -->
                        <a class="carousel-control-prev" data-slide="prev" href="#carouselExampleIndicators" 							role="button">
                        <span aria-hidden="true" class="carousel-control-prev-icon">
                        </span><span class="sr-only">Previous</span> </a>
                        <a class="carousel-control-next" data-slide="next" href="#carouselExampleIndicators" 							role="button">
                        <span aria-hidden="true" class="carousel-control-next-icon">
                        </span><span class="sr-only">Next</span> </a>
                    </div>
                </div>
            </div>
            
            <!-- Internal Linking Info Adverts with images to encourage user to sign up or login -->
            <!-- Style sits 3 side by side then for mobile sets 2 side by side as last one hides -->
            <div class="row myinfo">
                <!-- Learners Internal Link Advert -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-6 myinfo">
                    <div class="myinfoborder">
                        <h2 class="myinfotext" style="text-align:center">Learners</h2>
                        <div class="myinfoimage nopadding myborder">
                            <img class="mygalleryimages" alt="Catergory Image 1" 
                                title="Catergory 1" src="images//placeholder.png">
                        </div>
                        <br>
                        <p class="mygallerytext" style="text-align:center">
                        Wanting to Learn Math?<br>
                        Struggling at School?<br>
                        Using Mathland in Class?<br>
                        Mastering Math's is now Fun and Easy!<br>
                        <em>Become a Mathlander for FREE Today!</em></p>
                        <p style="text-align:center"><a class="btn" href="?cmd=home"><br>Register &gt;&gt;</a></p>
                    </div>
                </div>
                <!-- Educators Internal Link Advert -->
                <div class="col-lg-4 col-md-4 col-sm-6 col-6 myinfo">
                    <div class="myinfoborder">
                        <h2 class="myinfotext" style="text-align:center">Educators</h2>
                        <div class="myinfoimage nopadding myborder">
                            <img class="mygalleryimages" alt="Catergory Image 2" 
                                title="Catergory 2" src="images//placeholder.png">
                        </div>
                        <br>
                        <p class="mygallerytext" style="text-align:center">
                        <em>Teaching</em> Mathematics?<br>
                        <em>Tutoring</em> Strugling Learners?<br>
                        Parent wanting to <em>Help</em> your Child?<br>
                        <em>Progress</em> tracking and <em>Statistics</em> sound good?<br>
                        Use Mathland for FREE and start Educating Today!</p>
                        <p style="text-align:center"><a class="btn" href="?cmd=home"><br>Register &gt;&gt;</a></p>
                    </div>
                </div>
                <!-- Members Internal Link Advert, hides on mobile making 2 side by side not 3 -->
                <div class="col-lg-4 col-md-4 myinfo d-none d-md-block">
                    <div class="myinfoborder">
                        <h2 class="myinfotext" style="text-align:center">Members</h2>
                        <div class="myinfoimage nopadding myborder">
                            <img class="mygalleryimages" alt="Catergory Image 3" 
                                title="Catergory 3" src="images//placeholder.png">
                        </div>
                        <br>
                        <p class="mygallerytext" style="text-align:center">
                        <em>Returning Learner/Educator?</em><br>
                        If you have an existing account!<br>
                        Then you need to <em>Login</em> to see your Portal!<br>
                        Mathland is always changing, come see whats new!<br>
                        Remember Mathland is FREE!!</p>
                        <p style="text-align:center"><a class="btn" href="?cmd=home"><br>Sign In &gt;&gt;</a></p>
                    </div>
                </div>
            </div>
            
            <!-- Images and Text using Cues, Clues and 3 second views -->
            <div class="row">
                <!-- Larger square Image -->
                <div class="col-lg-8 col-md-8 col-sm-12 mygallerylarge nopadding myborder d-none d-md-block">
                     <img class="mygalleryimages" alt="Big Image 1" 
                        src="images//placeholder.png">
                </div>
                <!-- 2nd Coloumn Text Area and smaller rectangle image below it -->
                <div class="col-lg-4 col-md-4 col-sm-12 nopadding myborder">
                    <div class="mygallerysmalltext myborder" style="padding-left:10px; padding-right:10px;">
                        <br>
                        <br>
                        <br>
                        <h3 class="myinfotext" style="text-align:center">We Have Tutorials</h3>
                        <p class="mygallerytext" style="text-align:center">
                        Struggling with <em>Mathematics?</em> We have all been there before
                        and using the tools we provide makes it easy!</p>
                    </div>
                    <div class="mygallerysmall nopadding myborder">
                        <img class="mygalleryimages" alt="Small Image 1" 
                            src="images//placeholder.png">
                    </div>
                </div>
            </div>
            <!-- Images and Text using Cues, Clues and 3 second views / thies part Hides for mobile -->
            <div class="row">
                <!-- Text Area and smaller rectangle image below it -->
                <div class="col-lg-4 col-md-4 col-sm-12 nopadding myborder">
                    <div class="mygallerysmalltext myborder" style="padding-left:10px; padding-right:10px;">
                        <br>
                        <br>
                        <br>
                        <h3 class="myinfotext" style="text-align:center">Bored of Math?</h3>
                        <p class="mygallerytext" style="text-align:center">
                        Fear not because Mathland aims at making it fun to learn Mathematics
                        at your <em>own pace</em> and lending a hand all the way!
                        </p>
                    </div>
                    <div class="mygallerysmall nopadding myborder d-none d-md-block">
                        <img class="mygalleryimages" alt="Small Image 2" 
                            src="images//placeholder.png">
                    </div>
                </div>
                <!-- 2nd Coloumn larger square area to show website statistic?recent high scores?leader board? -->
                <div class="col-lg-8 col-md-8 col-sm-12 mygallerylarge nopadding myborder">
                    <img class="mygalleryimages" alt="Space to Show Statistics" 
                        src="images//placeholder.png">
                    <div class="carousel-caption">
                        <h2 class="myslidetext">Statistics Display!</h2>
                    </div>
                </div>
            </div>

            <?php
            }
                require_once("SubViews//FooterView.php") // imports reusable footer
            ?>
            
            <!-- Carousel Image Touch Screen Slide JQuery -->
            <script>
                $(".carousel").on("touchstart", function(event){
                    var xClick = event.originalEvent.touches[0].pageX;
                    $(this).one("touchmove", function(event){
                        var xMove = event.originalEvent.touches[0].pageX;
                        if( Math.floor(xClick - xMove) > 5 ){
                            $(this).carousel('next');
                        }
                        else if( Math.floor(xClick - xMove) < -5 ){
                            $(this).carousel('prev');
                        }
                    });
                    $(".carousel").on("touchend", function(){
                            $(this).off("touchmove");
                    });
                });
            </script>
            <!-- Script to animate the competition star -->
            <script type="text/javascript" src="js//competition.js"></script>
        </div>
    </body>
</html>