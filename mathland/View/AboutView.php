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
            <!-- Container for boxing all mathland details for the about page and contact email -->
            <div class="myinfo" style="text-align:center;">
                <h1><?=$this->viewModel->title?></h1>
                <br>
                <p class="myinfotext">Mathland was designed from the ground up by Dean Stanley-Hunt, New Zealand. The focus of this web application is for school kids of all ages to have a easy to use application for developing mathematical speed and skills, where self learning is encouraged and supported in an audio/video modern style, and Mathlanders can watch video tutorials again if unable to understand the first time, or try learn the same concepts from alternative video or practical options. Activity by Mathlanders is Tracked for personal statistics information and record keeping of results from speed training or a quiz! Mathlanders can communicate through commenting systems for tutorials, and teacher or parents can create educator accounts where it is possible to manage groups of learners, view individual learner statistics and activity, delegate homework activities or send positive feedback!</p>
                <br>
                <br>
                <h2>Contact Us: <a href="mailto:admin@mathland.com">admin@mathland.com</a></h2>
                <br>
            </div>
            <?php
                require_once("SubViews//FooterView.php") // imports reusable footer
            ?>
        </div>
    </body>
</html>