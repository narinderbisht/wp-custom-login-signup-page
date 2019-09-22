<?php 
/*
Template Name: Forgot Password Page
*/
if ( is_user_logged_in() ){
	global $post;
	wp_redirect( home_url('/') );
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
				<?php if(isset( $_REQUEST['errors'] ) && $_REQUEST['errors'] == 'empty_username'): ?>
				<div class="alert alert-danger">
					<?php echo __( '<strong>ERROR</strong>: Enter a username or email address.' ) ?>
				</div>
				<?php elseif(isset( $_REQUEST['errors'] ) && $_REQUEST['errors'] == 'invalid_email'): ?>
				<div class="alert alert-danger">
					<?php echo __( '<strong>ERROR</strong>: There is no account with that username or email address.' ) ?>
				</div>
				<?php elseif(isset( $_REQUEST['errors'] ) && $_REQUEST['errors'] == 'invalidcombo'): ?>
				<div class="alert alert-danger">
					<?php echo __( '<strong>ERROR</strong>: There is no account with that username or email address.' ) ?>
				</div>
				
				<?php endif; ?>
				
                <form action="<?php echo home_url('wp-login.php?action=lostpassword') ?>" name="lostpasswordform" id="lostpasswordform" method="post">
					
                  <div class="form-group">
                    <label class="label"><?php echo __( 'Username or Email Address') ?></label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="user_login" id="user_login" placeholder="<?php echo __( 'Username or Email Address') ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block"><?php echo __( 'Get New Password') ?></button>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                    <a href="<?php echo esc_url( wp_login_url() ); ?>" class="text-small forgot-password text-black"><?php _e( 'Log in' ); ?></a>
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