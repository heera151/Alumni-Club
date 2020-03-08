<!DOCTYPE HTML>
<?php
session_start();
include("include/connection.php");
include("functions/function.php");

?>
<?php 
if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}
else { ?>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Alumni club</title>
	<link rel="stylesheet" href="styles/home_style.css" media="all"/>
</head>
<body>
	<!--contents start-->
	<div class="container">
	<!--header wrapper starts here-->
	<div id ="head_wrap">
	
			<!-- head starts-->
			<div id ="header">
				<ul id ="menu">
						<li><a href="home.php">Home</a></li>
						<li><a href="members.php"> Members</a></li><!--vlink 17 18 e-->
						<li><a href="messages.php">Message</a></li>
						<li><a href="images.php">Image</a></li>
						</ul>
			
				    	<form action="results.php" method ="get" id="form1">
					         <input type="text" name="user_query" placeholder="search" />
					          <input type="submit" name ="search" value="search" />
					    </form>
			</div>
			<!--header ends-->
	</div>  
	<!-- header wrapper ends-->
	<!-- content area starts-->
	<div class="content">
		<!--user timeline starts-->
		<div id="user_timeline">
			<div id="user_details">
			<?php
			$user = $_SESSION['user_email'];
			$get_user = "select * from users where user_email = '$user' " ;
			$run_user = mysqli_query($con,$get_user);
			$row = mysqli_fetch_array ($run_user);
			
			$user_id =$row['user_id'];
			$user_name =$row['user_name'];
			$user_image=$row['user_image'];
			$register_date= $row['user_reg_date'];
			$last_login=$row ['user_last_logn'];
			
			
			$user_posts ="select * from posts where user_id= '$user_id' ";
			$run_posts =mysqli_query ($con, $user_posts);
			$posts = mysqli_num_rows($run_posts);
			
			
			$sel_msg = "select * from massages where receiver = '$user_id ' AND status  = 'unread' ORDER by 1 DESC";
			
			$run_msg = mysqli_query ($con,$sel_msg);
			
			$count_msg = mysqli_num_rows ($run_msg) ;
			
			
			echo " <center> 
						<img src='users/$user_image' width='200' height='200' />
				<div id='user_mention'>
				<p><strong>Name:</strong>$user_name</p>
				<p><strong>Last login:</strong>$last_login</p>
				<p><strong>Member since :</strong>$register_date</p>
				
				<p><a href='my_messages.php?inbox&u_id=$user_id'>Messages ($count_msg)</a></p>
				<p><a href='my_posts.php?u_id=$user_id'>My Posts ($posts)</a></p>
				<p><a href='edit_profile.php?u_id=$user_id'>Edit My Account</a></p>
				<p><a href='logout.php'>Logout</a></p>
				</div>" ;
			?>
			</div>
		</div><!--user timeline ends here-->
		<!--content timeline starts-->
		<div id ="content_timeline"> 
		<?php
				if(isset($_GET['post_id'])){
					$get_id=$_GET['post_id'];
					$get_post="select * from posts where post_id='$get_id'";
					$run_post=mysqli_query($con,$get_post);
					$row=mysqli_fetch_array($run_post);
					$post_title=$row['post_title'];
					$post_con=$row['post_content'];
					
				}
		
		
		?>
				<form method ="post" id ="f">
				<h2> Edit Your Post!</h2>
				<input type="text " name="title" value="<?php echo $post_title;?>" size ="82"  required ="required" /> <br />
				<textarea  name="content"  cols="83" rows="4"  ><?php echo$post_con;?></textarea><br />
				
				<input type="submit" name="update" value="update post" />
				</form>
				<?php
				if(isset($_POST['update'])){
					$title=$_POST['title'];
					$content=$_POST['content'];
					
					$update_post="update posts set post_title='$title',post_content='$content' where post_id='$get_id'";
					$run_update=mysqli_query($con,$update_post);
					
					if($run_update){
						echo"<script >alert('post has been updated')</script>";
						echo"<script >window.open('home.php','_self')</script>";
					}
				}
				
				?>
		
		
		
		
		</div>
		<!--content timeline ends-->
		
	</div>
	<!--content area ends-->
	
	</div>
	<!--container ends-->
	
</body>
</html>
<?php } ?>