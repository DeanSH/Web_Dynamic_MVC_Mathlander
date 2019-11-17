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
            <!-- forms the box to contain the math quiz generator and generated quiz questions -->
            <div class="myinfo" style="text-align:center;">
                <h1>Practice Math!</h1>
                <br>
                <p class="myinfotext">Math Quiz Generator and Options will be here!</p>
                <br>
                <br>
                1+1=Window!<br>
                <br>
            </div>
            <?php
                require_once("SubViews//FooterView.php") // imports reusable footer
            ?>
        </div>
    </body>
</html>