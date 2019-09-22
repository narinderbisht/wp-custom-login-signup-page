<?php 

/* Main redirection of the default login page */
function mytheme_redirect_login_page() {
	$login_page  = home_url('/login/');
	//$page_viewed = explode('?', basename($_SERVER['REQUEST_URI']) );
	
	//if( $page_viewed[0] == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	$page_viewed = basename($_SERVER['REQUEST_URI']);

	if($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
		$redirect_to = isset( $_SERVER['QUERY_STRING'] ) ? $login_page.'/?'.$_SERVER['QUERY_STRING'] : $login_page;
		wp_redirect($redirect_to);
		exit;
	}
}
add_action('init','mytheme_redirect_login_page');

/* Where to go if a login failed */
function mytheme_custom_login_failed() {
	$login_page  = home_url('/login/');
	wp_redirect($login_page . '?login=failed');
	exit;
}
add_action('wp_login_failed', 'mytheme_custom_login_failed');

/* Where to go if any of the fields were empty */
function mytheme_verify_user_pass($user, $username, $password) {
	$login_page  = home_url('/login/');
	
	
	if($username == "" || $password == "") {
		if(isset($_SERVER['QUERY_STRING'])) {
			wp_redirect($login_page.'?'.$_SERVER['QUERY_STRING']);
		} else {
			wp_redirect($login_page . "?login=empty");
		}
		exit;
	}
}
add_filter('authenticate', 'mytheme_verify_user_pass', 1, 3);

/* What to do on logout */
function mytheme_logout_redirect() {
	$login_page  = home_url('/login/');
	wp_redirect($login_page . "?login=false");
	exit;
}
add_action('wp_logout','mytheme_logout_redirect');


add_filter( 'wp_nav_menu_items', 'mytheme_custom_menu_item', 10, 2 );
function mytheme_custom_menu_item ( $items, $args ) {
    if ($args->theme_location == 'user_menu') {
        $items .= '<li><a class="dropdown-item" href="'. wp_logout_url() .'">Sign Out<i class="dropdown-item-icon ti-power-off"></i></a></li>';
    }
    return $items;
}


function mytheme_login_redirect( $redirect_to, $request, $user  ) {
		
	if ( ! is_wp_error( $user ) ) {
		// do redirects on successful login
		return home_url('my-uploads');
		/* if( $redirect_to != ''){
			return $redirect_to;
		}
		elseif ( $user->has_cap( 'administrator' ) || $user->has_cap( 'shop_manager' ) ) {
			return admin_url();
		} else {
			return home_url('my-uploads');
		} */
	} else {
		// display errors, basically
		return $redirect_to;
	}
	//return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : site_url();
}

add_filter( 'login_redirect', 'mytheme_login_redirect', 10, 3 );


/**
 * Redirects the user to the custom "Forgot your password?" page instead of
 * wp-login.php?action=lostpassword.
 */
function mytheme_redirect_to_custom_lostpassword() {
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $errors = retrieve_password();
		//print_r($errors); die();
        if ( is_wp_error( $errors ) ) {
            // Errors found
            $redirect_url = home_url( 'forgot-password' );
            $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
        } else {
            // Email sent
            $redirect_url = home_url( 'login' );
            $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
        }
 
        wp_redirect( $redirect_url );
        exit;
    }else{
		wp_redirect( home_url( 'forgot-password' ) );
		exit;
	}
   
    
}

add_action( 'login_form_lostpassword', 'mytheme_redirect_to_custom_lostpassword' );

/**
 * Redirects to the custom password reset page, or the login page
 * if there are errors.
*/
function mytheme_redirect_to_custom_password_reset() {
    
	// Verify key / login combo
	$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
	if ( ! $user || is_wp_error( $user ) ) {
		if ( $user && $user->get_error_code() === 'expired_key' ) {
			wp_redirect( home_url( 'login?login=expiredkey' ) );
		} else {
			wp_redirect( home_url( 'login?login=invalidkey' ) );
		}
		exit;
	}
	
	if ( isset( $_POST['pass1'] ) ) {
		$rp_key = $_REQUEST['rp_key'];
        $rp_login = $_REQUEST['rp_login'];
 
        $user = check_password_reset_key( $rp_key, $rp_login );
		if ( $_POST['pass1'] != $_POST['pass2'] ) {
			// Passwords don't match
			$redirect_url = home_url( 'reset-password' );

			$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
			$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
			$redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

			wp_redirect( $redirect_url );
			exit;
		}

		if ( empty( $_POST['pass1'] ) ) {
			// Password is empty
			$redirect_url = home_url( 'reset-password' );

			$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
			$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
			$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

			wp_redirect( $redirect_url );
			exit;
		}

		// Parameter checks OK, reset password
		reset_password( $user, $_POST['pass1'] );
		wp_redirect( home_url( 'login?login=password_changed' ) );
		
	} else {
		
		$redirect_url = home_url( 'reset-password' );
		$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
		$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

		wp_redirect( $redirect_url );
		exit;
	}

	
    
}
add_action( 'login_form_rp', 'mytheme_redirect_to_custom_password_reset' );
add_action( 'login_form_resetpass', 'mytheme_redirect_to_custom_password_reset' );


/**
 * Redirects the user to the custom "Forgot your password?" page instead of
 * wp-login.php?action=register.
 */

function mytheme_redirect_to_custom_registration() {
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $errors = new WP_Error();
		$redirect_url = home_url( 'sign-up' );
		//print_r($errors); die();
        // Email address is used as both username and email. It is also the only
		// parameter we need to validate
		if ( ! is_email( $_POST['user_email'] ) ) {
			
			$redirect_url = add_query_arg( 'error', 'invalid_email', $redirect_url );
			wp_redirect( $redirect_url );
			exit;
			
		}
	 
		//if ( username_exists( $email ) || email_exists( $_POST['user_email'] ) ) {
		elseif ( email_exists( $_POST['user_email'] ) ) {
			$redirect_url = add_query_arg( 'error', 'email_exists', $redirect_url );
			wp_redirect( $redirect_url );
			exit;
			
		}
		elseif ( $_POST['user_firstname'] == '' || $_POST['user_lastname'] == '' || $_POST['user_email'] == '' || $_POST['user_password'] == '' || $_POST['confirm_password'] == '' ) {
			// Password is empty
			
			$redirect_url = add_query_arg( 'error', 'empty_fields', $redirect_url );

			wp_redirect( $redirect_url );
			exit;
		}
		elseif ( $_POST['user_password'] != $_POST['confirm_password'] ) {
			// Passwords don't match
			
			$redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

			wp_redirect( $redirect_url );
			exit;
		}
		else {
			
			// Generate the password so that the subscriber will have to check email...
			$password = $_POST['user_password']; //wp_generate_password( 12, false );
		 
			$user_data = array(
				'user_login'    => $_POST['user_email'],
				'user_email'    => $_POST['user_email'],
				'user_pass'     => $password,
				'first_name'    => $_POST['user_firstname'],
				'last_name'     => $_POST['user_lastname'],
				'nickname'      => $_POST['user_firstname'],
				'display_name'  => $_POST['user_firstname'].' '.$_POST['user_lastname']
			);
		 
			$user_id = wp_insert_user( $user_data );
			wp_new_user_notification( $user_id, $password );
		 
			// Success, redirect to login page.
            $redirect_url = home_url( 'login' );
            $redirect_url = add_query_arg( 'checkemail', 'registered', $redirect_url );
            wp_redirect( $redirect_url );
			exit;
		}
		
		
    }else{
		wp_redirect( home_url( 'sign-up' ) );
		exit;
	}
   
    
}

add_action( 'login_form_register', 'mytheme_redirect_to_custom_registration' );