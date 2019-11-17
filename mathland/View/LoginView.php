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
                <h2 id="error" style="color:red;"><?=$this->viewModel->error?></h2><!-- shows login errors if any -->
                <br>
                <!-- Login Form with all feilds required action="?ctr=LoginController&cmd=login"-->
                <form name="frmRegister" method="post" action="?ctr=LoginController&cmd=login" onsubmit="return validateLogin()">
                    Username:<br>
                    <input type="text" id="name" name="name" value="" required><br>
                    Password:<br>
                    <input type="password" id="pass" name="pass" value="" required><br>
                    <br>
                    <button type="submit" style="width:97%; max-width:200px;">LOGIN</button>
                </form>
                <br>
                <br>
                <h2>Not a Member? <a href="?ctr=LoginController&cmd=showRegister">Register Here!</a></h2>
                <br>
            </div>
            <?php
                require_once("SubViews//FooterView.php") // imports reusable footer
            ?>
        </div>
        <!-- Load in the script containing form validations -->
        <script type="text/javascript" src="js//validation.js"></script>
    </body>
</html>