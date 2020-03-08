<?php
include ("include/connection.php");


	if(isset($_POST['sign_up'])){
		 $name= mysqli_real_escape_string($con,$_POST['u_name']);
		$email= mysqli_real_escape_string($con,$_POST['u_email']);
		$pass= mysqli_real_escape_string($con,$_POST['u_pass']);
		$gender= mysqli_real_escape_string($con,$_POST['u_gender']);
		$birthday= mysqli_real_escape_string($con,$_POST['u_birthday']);
		$status="unverified";
		$posts="no";
		$ver_code = mt_rand();
		
		
		if ( strlen ($pass)<8){
			echo "<script>alert ('minimum 8 characters') </script>";
			exit();
		}
		$check_email = "select * from users where user_email = '$email' ";
		$run_email = mysqli_query ($con , $check_email);
		
		$check = mysqli_num_rows( $run_email );
		
		if ($check==1)
		{
			echo "<script>alert ('this email has already taken,please try another') </script>";
			exit();
			}
			$insert = "insert into users ( user_name,user_pass,user_email,user_gender,user_birthday,user_image,user_reg_date,status,ver_code,posts) 
								values('$name','$pass','$email','$gender','$birthday','default.jpg',NOW(),'$status','$ver_code','$posts')";
	
	 $query = mysqli_query($con,$insert);
	 
	 if ($query){
		 echo "<h3 style='width:400px; text-align:justify; color:green;' > Hi ,$name Congratulations ,registration successful.check your email</h3>";
		 
	 }
	 else {
		 echo "registration error ,Try again!";
	 }
	
	
	
	
	}

?>