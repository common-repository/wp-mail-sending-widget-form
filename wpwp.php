<?php 

/**
 * The WPWP class is the main class for using any hooks and enqueueing any style or scripts file.
 * Consider it as a functions.php of this plugin.
**/

class WPWP{
	public function __construct(){

	// Enqueueing Style and Scripts files - FRONTEND
	add_action('wp_enqueue_scripts', array( &$this, 'callback_of_wp_enqueue') );

	// Enqueueing Style and Scripts files - BACKEND
	add_action('admin_enqueue_scripts', array( &$this, 'callback_of_admin_enqueue'));

	// Adding Menu for the plugin
	add_action('admin_menu', array( &$this, 'callback_of_admin_menu') );

	// Creating Widget
	add_action('widgets_init', array( &$this, 'callback_of_widgets_init') );	

	}


					/******* ALL Plublic functions *******/

	public function callback_of_widgets_init(){
		register_widget( 'WPMWP' );
	}

	// FRONTEND Enqueue
	public function callback_of_wp_enqueue(){
		// Enqueueing Style files
		wp_enqueue_style('custom-css', PLUGINS_URL('/custom.css', __FILE__));
		
	}

	// BACKEND Enqueue
	public function callback_of_admin_enqueue(){
		// Style files
		wp_enqueue_style( 'bootstrap-css', plugins_url('/css/bootstrap.min.css', __FILE__));

		// Scripts files
		wp_enqueue_script( 'bootstrap-script', plugins_url( '/js/bootstrap.min.js', __FILE__ ), array('jquery'));
		wp_enqueue_script( 'custom-script', plugins_url( '/js/custom.js', __FILE__ ), array('bootstrap-script'));
	}


	// Adding Menu Options
	public function callback_of_admin_menu(){
		add_menu_page('WP mail-sending Widget', 'WP mail Widget', 'manage_options', 'slug-wp-mail-widget', array( &$this, 'callback_of_add_menu_page'), 'dashicons-email', 59);
	}


	// Menu Displaying function
	public function callback_of_add_menu_page(){
		?>
		<div class="wrap container">
			<h2>WP mail-sending Widget Setting</h2> <br>
			<form action="options.php" method="POST">
				<table class="table table-striped table-hover">
				    <thead>
				      <tr>
				        <th>#</th>
				        <th>Firstname</th>
				        <th>Email</th>
				        <th>Phone #</th>
				      </tr>
				    </thead>
				    <tbody>
					<?php  

						global $wpdb;
						$tablename = $wpdb->prefix . 'a_wp_mail';
						$sql = "SELECT * FROM $tablename";
						$infos = $wpdb->get_results( $sql, 'OBJECT_K' );
						$i = 1;

					foreach( $infos as $info ) :
					?>
					    <tr>
						    <td><?php echo $i; ?></td>
						    <td><?php echo $info->name; ?></td>
						    <td><?php echo $info->email; ?></td>
						    <td><?php echo $info->phone; ?></td>
					    </tr>
					<?php 
					$i++;
					endforeach; 
					?>

				    </tbody>
				</table>


			</form>
		</div>
		<?php 
	}


}
