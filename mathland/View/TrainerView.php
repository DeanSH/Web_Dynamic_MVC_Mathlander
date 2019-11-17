<!-- 
    Original Source Code GitHub URL: https://github.com/ljacqu/mathtrainer
    This HTML is to support the Game... Math Trainer for Speed training and practice of mathematics.
    Modified extensively by Dean Stanley-Hunt 08/2018
    -Added second timer for question answering time limits, then shows correct answer when time is up!
    -Added Numpad for touchscreen support
    -Added addition option to customize the seconds per question to answer it
    -Removed skip question support since plater can find the answer when question time runs out
    -Added Wipeouts count to count how many times the player failed to answer before question time was up.
    -Added Bootstrap and got it all responsive and stacking for mobile and cross platform devices
-->

<html>
    <?php
        require_once("SubViews//HeadView.php") // imports reusable HEAD for Views
    ?>
    <body>
        <!-- Container fluid to make it full screen width -->
        <div class="container-fluid">
            <?php
                require_once("SubViews//NavView.php") // imports reusable navigation bar
            ?>
            
            <!-- Creates a Box to show the Math Trainer in -->
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12" style="text-align: center;">
                    <br>
                    <h2><b>Mathland Speed Trainer Game!</b></h2>
                    <!-- Show logged in player details -->
                    <b>Player:</b> <?=$this->userModel->username?><br>
                    <div class="d-none d-sm-block">
                        <b>School:</b> <?=$this->userModel->school?><br>
                        <b>Location:</b> <?=$this->userModel->country?><br>
                        <b>Age:</b> <?=$this->userModel->getAge($this->userModel->dob)?><br>
                    </div>
                    <!-- Game over view shown at end of game with final score details -->
                    <div id="score" style="display: none;">
                        <br>
                        <h2><b>Game Over!</b></h2>
                        In <span id="score_time">a certain time</span> Minutes,<br>
                        You Scored <span id="score_total">n</span> Correct Answers!<br>
                        <br>
                        You Wiped Out <span id="score_failed">n</span> Times,<br>
                        At <span id="score_question_time">a certain time</span> Seconds Per Question.
                    </div>
                </div>
                <!-- Game Play container shows Math question and answer text box, question time remaining and numpad -->
                <div id="user" class="col-lg-6 col-md-6 col-sm-12" style="display: none; text-align: center;">
                    <div id="question_math"></div>
                    <input type="number" id="result" /><br>
                    <span style="font-size: 28px;"><b>Question Time: </b><label id="timer_q"></label></span><br>
                    <div id="touch_numpad">
                        <input type="submit" value="7" id="numpad_7" style="width: 25%;" />
                        <input type="submit" value="8" id="numpad_8" style="width: 25%;" />
                        <input type="submit" value="9" id="numpad_9" style="width: 25%;" /><br>
                        <input type="submit" value="4" id="numpad_4" style="width: 25%;" />
                        <input type="submit" value="5" id="numpad_5" style="width: 25%;" />
                        <input type="submit" value="6" id="numpad_6" style="width: 25%;" /><br>
                        <input type="submit" value="1" id="numpad_1" style="width: 25%;" />
                        <input type="submit" value="2" id="numpad_2" style="width: 25%;" />
                        <input type="submit" value="3" id="numpad_3" style="width: 25%;" /><br>
                        <input type="submit" value="<" id="numpad_del" style="width: 25%;" />
                        <input type="submit" value="0" id="numpad_0" style="width: 25%;" />
                        <input type="submit" value="-" id="numpad_neg" style="width: 25%;" /><br>
                    </div>
                    <!-- Hides/Shows the Numpad for touch screen game play support -->
                    <input type="submit" value="Hide the Numpad" id="hide_numpad" style="width: 78%;" />
                </div>
                <!-- Game statistics shown during game play to see current score values and total game time remaining -->
                <div id="question" class="col-lg-3 col-md-3 col-sm-12" style="display: none; text-align: center;">
                    <br>
                    <h2><b>Statistics</b></h2>
                    <b>Total: </b><span id="questions_total"></span><br>
                    <b>Score: </b><span id="questions_correct"></span><br>
                    <b>Wipe Outs: </b><span id="questions_failed"></span><br>
                    <b>Time Left: </b><label id="timer"></label><br>
                    <br>
                    <!-- End game and hide game play then show options again -->
                    <input type="submit" value="End Game" id="quit_to_options" style="width: 75%;" />
                </div>
                <!-- Options container seen before and after game play, users can setup custom parameters -->
                <div id="options" class="col-lg-6 col-md-6 col-sm-12" style="text-align: center;">
                    <br>
                    <h2><b>Options!</b></h2>
                    Train your mind, improve your speed and earn high scores!<br>
                    <div id="error_wrapper" style="display: none"><span id="options_error"></span></div><br>
                    Run Trainer for (Minutes)  <input type="number" name="timer length" min="1" id="timer_length" value="5" /><br>
                    Run Questions for (Seconds)  <input type="number" name="question timer length" min="1" id="timer_q_length" value="12" /><br>
                    Create problems with numbers in the following range:<br>
                    Min: <input type="number" id="min" value="1" /><br>
                    Max: <input type="number" id="max" value="10" /><br>
                    <br>
                    <label for="avoid_negative">Avoid negative results for subtraction?</label>
                    <input type="checkbox" id="avoid_negative" checked="checked" /><br>
                    <span style="font-size: 0.9em">Only applicable if min and max aren't negative.</span><br>
                    <br>
                    <div id="op_wrapper" style="text-align: center;">Include: <br>
                        <label for="op_add">Addition </label> <input type="checkbox" id="op_add" checked="checked" /><br>
                        <label for="op_sub">Subtraction </label> <input type="checkbox" id="op_sub" checked="checked" /><br>
                        <label for="op_mul">Multiplication </label> <input type="checkbox" id="op_mul" /><br>
                        <label for="op_div">Division </label> <input type="checkbox" id="op_div" />
                    </div>
                    <!-- Starts the Client Side JQuery based Game -->
                    <br /><input type="submit" id="start" value="Start" href="#" style="display:none; width: 80%;" />
                </div>
            </div>
            <?php
                require_once("SubViews//FooterView.php") // imports reusable footer
            ?>
            <!-- Just incase the browser doesnt support JS notify the user to enable it -->
            <noscript>
                <h2>JavaScript Required</h2>
                <p>JavaScript is required to run this trainer; please enable it in your browser.</p>
            </noscript>
            <!-- Boot strap JS and Jquery Frameworks required to work trainer -->
            <script crossorigin="anonymous" 
                    integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" 
                    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js">
            </script>
            <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
            <!-- Load external Timer and the Trainer code that makes the client side game functional -->
            <script type="text/javascript" src="js//timer.js"></script>
            <script type="text/javascript" src="js//trainer.js"></script>
        </div>
    </body>
</html>