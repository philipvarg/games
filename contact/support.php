 <?php 
	// Message Vars    Travesty
	$msg = '';
	$msgClass = '';

	// Check For Submit
	if(filter_has_var(INPUT_POST, 'submit')){
		// Get Form Data
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
		$message = htmlspecialchars($_POST['message']);

		// Check Required Fields
		if(!empty($email) && !empty($name) && !empty($message)){
			// Passed all fields
			// Check Email
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				// Validate Failed
				$msg = 'Please use a valid email';
				$msgClass = 'alert-danger';
			} else {
				// Validate Passed
				$toEmail = 'supportrigger@elearnplay.com';
				$subject = 'Support Query from '.$name;
				$body = '<h2>Course support</h2>
					<h4>Name</h4><p>'.$name.'</p>
					<h4>Email</h4><p>'.$email.'</p>
					<h4>Message</h4><p>'.$message.'</p>
				';

				// Email Headers
				$headers = "MIME-Version: 1.0" ."\r\n";
				$headers .="Content-Type:text/html;charset=UTF-8" . "\r\n";

				// Additional Headers
				$headers .= "From: " .$name. "<".$email.">". "\r\n";
				
				$secretKey = "6LdlLy8aAAAAAD7NlOikxp1mtwilyZXXd0mNHKfB";
				$responseKey = $_POST['g-recaptcha-response'];
				$UserIP = $_SERVER['REMOTE_ADDR'];
				$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$UserIP";
				$response = file_get_contents($url);
				$response = json_decode($response);
				
				if ($response->success){
					if(mail($toEmail, $subject, $body, $headers)){
						// Email Sent
						$msg = 'Your email has been sent.<br>We will answer within 24 hrs.<br>Please close this window.';
						$msgClass = 'alert-success';
					} else {
						// Email not sent
						$msg = 'Your email was NOT sent';
						$msgClass = 'alert-danger';
					}
				} else {
					$msg = 'Confirm you are human';
					$msgClass = 'alert-danger';
				}	
			}
		} else {
			// Failed field empty
			$msg = 'Please fill in all fields';
			$msgClass = 'alert-danger';
		}
	}
?> 

<!DOCTYPE HTML>
<html>
<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--Using another version of bootstrap for Contact Us form-->
	<link rel="stylesheet" type="text/css" href="../bootstrap_support/bootstrap.css">
    <link rel="stylesheet" href="../bootstrap/css/styleEasy.css">
	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<title>Contact Us</title>
	
	
</head>

<body>
	<!--nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">    
          <a class="navbar-brand" href="index.php">eLP Support form</a>
        </div>
      </div>
    </nav-->
	
    <div class="contact-form">
		<h2>Contact TazraGames</h2>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    	<?php if($msg != ''): ?>
    		<div class="status <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
    	<?php endif; ?>
      
		    <input type="text" name="name" placeholder= "Your name" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
	      
	      	<input type="text" name="email"  placeholder= "Your email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
	      
	      	<textarea name="message" placeholder="Your message" ><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
			
			<div class="g-recaptcha" data-sitekey="6LdlLy8aAAAAAI7jyPbLtjZ0BTaKeLkBgfbt3fCf"></div>
			<!--input type="submit" name="submit" value="Send message" class="btn btn-primary">
			<input type="submit" name="submit" value="Submit" class="submit-btn"-->
			
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
      </form>
	  <div class = "status"></div>
	  
    </div>
	
	<script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.js"></script>
</body>
</html>
