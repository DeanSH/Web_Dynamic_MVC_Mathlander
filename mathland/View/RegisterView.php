<html>
    <?php
        require_once("SubViews//HeadView.php")  // imports reusable HEAD for views
    ?>
    <body>
        <!-- Container fluid to make it full screen width -->
        <div class="container-fluid">
            <?php
                require_once("SubViews//NavView.php")  // imports reusable navigation bar
            ?>
            <!-- Boxes in the Register Form -->
            <div class="myform" style="text-align:center;">
                <h1><?=$this->viewModel->title?></h1>
                <h2 id="error" style="color:red;"><?=$this->viewModel->error?></h2>
                <br>
                <!-- The Register Form, all feilds required -->
                <form name="frmRegister" method="post" action="?ctr=LoginController&cmd=register" onsubmit="return validateRegister()">
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            Username:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <input type="text" class="myformtextbox" id="name" name="name" value="" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            Password:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <input type="password" class="myformtextbox" id="pass" name="pass" value="" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            Email:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <input type="email" class="myformtextbox" id="email" name="email" value="" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            First Name:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <input type="text" class="myformtextbox" id="first" name="first" value="" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            Last Name:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <input type="text" class="myformtextbox" id="last" name="last" value="" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            School Name:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <input type="text" class="myformtextbox" id="school" name="school" value="" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            Country Name:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <input type="text" class="myformtextbox" id="country" name="country" value="" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            Date Of Birth:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <input type="date" class="myformtextbox" id="dob" name="dob" value="2000-01-30" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            Gender:<br>
                        </div>
                        <div class="col-6" style="text-align:left; height:35px;">
                            <select name="gender" class="myformtextbox">
                                <option value="M" selected>Male</option>
                                <option value="F">Female</option>
                                <option value="O">Other</option>
                            </select><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6" style="text-align:right;">
                            Account Type:<br>
                        </div>
                        <div class="col-6" style="text-align:left;">
                            <input type="radio" name="type" value="Learner" checked> Learner<br>
                            <input type="radio" name="type" value="Educator"> Educator<br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <br>
                            <button type="submit" style="width:97%; max-width:400px;">SIGN UP</button>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <h2>Already a Member? <a href="?ctr=LoginController&cmd=showLogin">Login Here!</a></h2>
                <br>
            </div>
            <?php
                require_once("SubViews//FooterView.php")  // imports reusable footer
            ?>
        </div>
        <!-- Load in the script containing form validations -->
        <script type="text/javascript" src="js//validation.js"></script>
    </body>
</html>