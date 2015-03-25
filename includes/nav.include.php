<nav class="navbar navbar-default about"  role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php if($authorized) : ?>
				<?php if($_SESSION['isTeacher']) : ?>
				<a class="logo hidden-xs" href="index.php"><img src="../img/rocky_small.png"></a> 
				<ul class="nav nav-pills navbar-left red">
					<li><a href="teacher.php">Dashboard</a></li>
					<li><a href="classes.php">Classes</a></li>
					<li><a href="contact_us.php">Contact</a></li>
				</ul>
				<?php else : ?>
				<a class="logo hidden-xs" href="index.php"><img src="../img/rocky_small.png"></a> 
				<ul class="nav nav-pills navbar-left red">
					<li><a href="student.php">Student Home</a></li>
					<li><a href="#registerbox">Register</a></li>
					<li><a href="">Grades</a></li>
				</ul>
				<?php endif; ?>
			<?php else : ?>
			<a class="logo" href="index.php"><img src="../img/rocky_small.png"></a> 
				<ul class="nav nav-pills navbar-left red">
					<li><a href="index.php">Home</a></li>
					<li><a href="register.php">Register</a></li>
					<li><a href="contact_us.php">Contact</a></li>
				</ul>
			<?php endif; ?>
		</div>
		
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<?php if($authorized) : ?>
				<div class="pull-right" style="float:right">
					<div style="color:white; margin-top:2%; float:left;">
						<p style="font-size:17px;">Welcome <?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}?>
							&nbsp;&nbsp;<a class="btn btn-sm btn-success" href="logout.php"><i class="glyphicon glyphicon-off"> </i>  Log Out</a></p>
						</div>
					</div>
				<?php else : ?>

					<form method="post" action="index.php" id="loginform" class="navbar-form navbar-right signin" role="form">
						<div class="form-group">
							<input type="text" name="login_email" placeholder="E-Mail" class="form-control" required>
						</div>

						<div class="form-group">
							<input type="password" name="login_password" placeholder="Password" class="form-control" required>
						</div>
						<input type="submit" value="Log In" class="btn btn-sm btn-success">
					</form>
				<?php endif; ?>

			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
