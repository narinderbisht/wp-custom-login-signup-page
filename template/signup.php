<?php 
/*
Template Name: Signup Page
*/
if ( is_user_logged_in() ){
	global $post;
	wp_redirect( home_url('/') );
	exit;
}
if ( ! get_option( 'users_can_register' ) ) {
	wp_redirect( site_url( 'wp-login.php?registration=disabled' ) ) ;
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Required meta tags -->
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
<?php while( have_posts() ): the_post(); ?>
	<div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <div class="auto-form-wrapper">
				<h1><?php the_title(); ?></h1>
				<div class="text-left"> <?php the_content(); ?></div>
				
				<?php if(isset( $_REQUEST['error'] ) && $_REQUEST['error'] == 'empty_fields'): ?>
				<div class="alert alert-danger">
					<?php echo __( '<strong>ERROR</strong>: All fields are required.' ) ?>
				</div>
				<?php elseif(isset( $_REQUEST['error'] ) && $_REQUEST['error'] == 'invalid_email'): ?>
				<div class="alert alert-danger">
					<?php echo __( '<strong>ERROR</strong>: Invalid email address.' ) ?>
				</div>
				<?php elseif(isset( $_REQUEST['error'] ) && $_REQUEST['error'] == 'invalidcombo'): ?>
				<div class="alert alert-danger">
					<?php echo __( '<strong>ERROR</strong>: There is no account with that username or email address.' ) ?>
				</div>
				
				<?php endif; ?>
				
				<?php if( isset($_REQUEST['checkemail']) && $_REQUEST['checkemail'] == 'registered'): ?>
					<div class="alert alert-success">
						<?php echo __( 'You are registered to website. Please login!' ) ?>
					</div>
				<?php endif; ?>
                <form action="<?php echo esc_url( wp_registration_url() ) ?>" name="registerform" id="registerform" method="post">
                  <div class="form-group">
                    <label class="label" for="user_firstname"><?php echo __( 'First Name' ) ?></label>
                    <input type="text" class="form-control" name="user_firstname" id="user_firstname" placeholder="<?php echo __( 'First Name' ) ?>"/>
                  </div>
				  <div class="form-group">
                    <label class="label" for="user_lastname"><?php echo __( 'Last Name' ) ?></label>
                    <input type="text" class="form-control" name="user_lastname" id="user_lastname" placeholder="<?php echo __( 'Last Name' ) ?>"/>
                  </div>
				  <div class="form-group">
                    <label class="label" for="user_email"><?php echo __( 'Email' ) ?></label>
                    <input type="email" class="form-control" name="user_email" id="user_email" placeholder="<?php echo __( 'Email' ) ?>"/>
                  </div>
                  <div class="form-group">
					<label class="label" for="user_email"><?php echo __( 'Password' ) ?></label>
					<input type="password" class="form-control" name="user_password" id="user_password" placeholder="<?php echo __( 'Password' ) ?>">
                      
                  </div>
                  <div class="form-group">
					<label class="label" for="user_email"><?php echo __( 'Confirm Password' ) ?></label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="<?php echo __( 'Confirm Password' ) ?>">
                    
                  </div>
                 
                 
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block"><?php echo __( 'Register' ) ?></button>
                  </div>
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold"><?php echo __( 'Already have and account ?' ) ?></span>
                    <a href="<?php echo esc_url( wp_login_url() ); ?>" class="text-black text-small"><?php echo __( 'Login' ) ?></a>
                  </div>
                </form>
              </div>
              <!--<ul class="auth-footer">
                <li>
                  <a href="#">Conditions</a>
                </li>
                <li>
                  <a href="#">Help</a>
                </li>
                <li>
                  <a href="#">Terms</a>
                </li>
              </ul>-->
              <p class="footer-text text-center">Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo home_url() ?>"><?php echo get_bloginfo('name'); ?></a>. All rights reserved.</p>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
<?php endwhile; wp_footer(); ?>
</body>
</html>