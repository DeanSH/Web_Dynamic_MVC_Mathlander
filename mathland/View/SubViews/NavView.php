<!-- Nav Bar with Mobile Toggle -->
	<div class="row">
		<div class="col-md-12 myborder nopadding">
			<nav class="navbar navbar-expand-md navbar-light mynav">
  				<button class="navbar-toggler" type="button" data-toggle="collapse" 
  		            data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" 
  		            aria-expanded="false" aria-label="Toggle navigation">
    				<span class="navbar-toggler-icon"></span>
  				</button>
  				<!-- Logo on nav, clickable to go back to home page from each page -->
  				<a class="navbar-brand" href="?cmd=home">
  					<img style="width:150px; height:50px;"src="images//placeholder.png"
  						alt="Holdens R Us web logo, clicking navigates to the Home Page" 
  						title="Goto Holdens R Us Home Page">
  				</a>
  				<!-- navigation options -->
  				<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    				<ul class="navbar-nav mr-auto mt-2 mt-lg-0 mymargincenter">
      					<li class="nav-item">
        					<a class="nav-link" href="?cmd=home">Home</a>
      					</li>
      					<li class="nav-item">
        					<a class="nav-link" href="?cmd=tutorials">Tutorials</a>
      					</li>
                        <?php
                            // Checks if user is logged in before including these next 2 Nav option on Nav bar!
                            if(isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                            {
                        ?>
      					<li class="nav-item">
        					<a class="nav-link" href="?cmd=prac">Practice</a>
      					</li>
      					<li class="nav-item">
        					<a class="nav-link" href="?cmd=game">Games</a>
      					</li>
                        <?php
                            }
                        ?>
      					<li class="nav-item">
        					<a class="nav-link" href="?cmd=about">About</a>
      					</li>
    				</ul>
    			 </div>
    			 <!-- Dynamically Show the Login state on right side -->
    			 <div class="navbar-brand mygallerytext" style="text-align:center">
                    <?php
                        //Check if Session is storing a current user meaning they are logged in
                        if(isset($this->userModel->currentUser) && !empty($this->userModel->currentUser))
                        {
                    ?>
                    Welcome <?=$this->userModel->currentUser?>!<br>
                    <a href="?ctr=LoginController&cmd=showProfile&name=<?=$this->userModel->currentUser?>"><em>Profile</em></a> |
                    <a href="?ctr=LoginController&cmd=logout"><em>Logout</em></a>
                    <?php
                        } else {
                        // Else case for what to show if user is not logged in
                    ?> 
    			 	Welcome Guest!<br>
  				 	<a href="?ctr=LoginController&cmd=showLogin"><em>Login</em></a> |
                    <a href="?ctr=LoginController&cmd=showRegister"><em>Register</em></a>
                    <?php
                        }
                    ?>
  				 </div>
    		</nav>		
    	</div>
	</div>
        