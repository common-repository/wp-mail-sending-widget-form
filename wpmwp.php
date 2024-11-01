<?php 

/**
 * Creating class for making a widget.
 * The widget will take inputs from the admin. The admin must set his/her email address
 * within the widget option area to receieve informations given by the subscribers/users.
**/

class WPMWP extends WP_Widget{
	
	// Creating __construct method for our widget class WPMWP
	public function __construct(){
		parent::__construct('id_of_widget', 'WP mail Widget', array(
			'description' => 'The best widget to create form on your sidebar.'
			));
	}

	// Creating widget method to display on frontend
	public function widget( $args, $db ){
		global $wpdb;

		$title = ! empty( $db['title'] ) ? $db['title'] : "Edit this title from your widget option.";
		$admin_mail = ! empty($db['admin_mail']) ? $db['admin_mail'] : '';	
		
		?>
		<?php echo $args['before_widget']; ?>
			<div id="contact-form">
				<?php echo $args['before_title']; ?>
					<?php echo $title; ?>
				<?php echo $args['after_title']; ?>
				

				<form action="" method="POST">
					<label for="id_name">Your Name:</label> <br>
					<input type="text" name="id_name" id="id_name" value="" placeholder="Enter name.." required>
					<br>
					<label for="id_number">Your Number:</label> <br>
					<input type="number" name="id_number" id="id_number" value="" placeholder="Enter number.." required>
					<br>
					<label for="id_email">Your Email:</label> <br>
					<input type="email" name="id_email" id="id_email" value="" placeholder="Enter email.." required>
					<br>
					<input type="submit" value="SEND" name="submit_form">
				</form>

				<p style="color: #FFF;">
					<?php  
					if(isset($_POST['submit_form'])){

						if(isset($_POST['id_name'])){
							$id_name = $_POST['id_name'];
						}
						if(isset($_POST['id_number'])){
							$id_number = $_POST['id_number'];
						}
						if(isset($_POST['id_email'])){
							$id_email = $_POST['id_email'];
						}

						// SENDING MAIL
						$msg = "Your newly subscriber name is " . $id_name . ", phone number: " . $id_number . " & email address: " . $id_email;
						$mail = mail($admin_mail, 'A new subscriber!', $msg);
						
						$err = '';
						if($mail){
							$err = "Message has been sent!";
						}else{
							$err = "Message has not been sent!";
						}
						echo $err;



						// INSERTING TO OUR DATABASE
						// $tablename = $wpdb->prefix . 'a_wp_mail';
						// cols = id, name, email, phone
						$tablename = $wpdb->prefix . 'a_wp_mail';
						$wpdb->insert($tablename, array(
							'name'	=> $id_name,
							'email'	=> $id_email,
							'phone'	=> $id_number
							));


					}
					?>
				</p>
			</div>

		<?php echo $args['after_widget']; ?>

			
		<?php
	}

	// Creating form method to display widget on backend
	public function form( $db ){
		$title = ! empty($db['title']) ? $db['title'] : '';
		$admin_mail = ! empty($db['admin_mail']) ? $db['admin_mail'] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input type="text" value="<?php echo esc_attr( $title ); ?>" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" placeholder="Title of your form">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('admin_mail'); ?>">Set Your Email Address:</label>
			<input type="email" id="<?php echo $this->get_field_id('admin_mail'); ?>" name="<?php echo $this->get_field_name('admin_mail'); ?>" value="<?php echo $admin_mail; ?>" class="widefat" placeholder="Enter Your email">
			<span class="description">All the mail infos will be sent to this email address.</span>
		</p>

		<?php

	}

	// Creating update function
	public function update( $new, $old ){
		$db 				= array();
		$db['title']		= !empty($new['title']) ? strip_tags($new['title']) : '';
		$db['admin_mail']	= !empty($new['admin_mail']) ? strip_tags($new['admin_mail']) : '';

		return $db;
	}
}

