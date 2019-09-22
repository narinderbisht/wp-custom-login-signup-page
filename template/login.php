<?php 
/*
Template Name: Login Page
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
				
				<?php if( isset($_REQUEST['login']) && $_REQUEST['login'] == 'failed'): ?>
					<div class="alert alert-danger">
						<?php echo __( 'Your login failed. Please try again.') ?>
					</div>
				<?php endif; ?>
				<?php if( isset($_REQUEST['checkemail']) && $_REQUEST['checkemail'] == 'confirm'): ?>
					<div class="alert alert-success">
						<?php echo __( 'Your forgot password email sent. Please check your inbox.') ?>
					</div>
				<?php elseif( isset($_REQUEST['checkemail']) && $_REQUEST['checkemail'] == 'registered'): ?>
					<div class="alert alert-success">
						<?php echo __( 'You are registered to website. Please login!') ?>
					</div>
				<?php elseif( isset($_REQUEST['registration']) && $_REQUEST['registration'] == 'disabled'): ?>
					<div class="alert alert-danger">
						<?php echo __( 'User registration is currently not allowed.') ?>
					</div>
				<?php elseif(isset( $_REQUEST['login'] ) && $_REQUEST['login'] == 'invalidkey'): ?>
				<div class="alert alert-danger">
					<?php echo __( 'Your password reset link appears to be invalid. Please request a new link below.' ) ?>
				</div>
				<?php elseif(isset( $_REQUEST['login'] ) && $_REQUEST['login'] == 'expiredkey'): ?>
				<div class="alert alert-danger">
					<?php echo __( 'Your password reset link has expired. Please request a new link below.' ) ?>
				</div>
				<?php elseif ( isset( $_REQUEST['login'] ) && $_REQUEST['login'] == 'password_changed' ) : ?>
				<div class="alert alert-success">
					<?php echo __( 'Your password has been changed. You can sign in now.'); ?>
				</div>
				
				<?php endif; ?>
                <form action="<?php echo home_url('wp-login.php') ?>" name="loginform" id="loginform" method="post">
                  <div class="form-group">
                    <label class="label" for="user_login"><?php echo __( 'Username/Email Address') ?></label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="log" id="user_login" placeholder="<?php echo __( 'Username/Email Address') ?>"/>
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label"><?php echo __( 'Password' ) ?></label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="pwd" id="user_pass" placeholder="*********">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block"><?php echo __( 'Login' ) ?></button>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                    <div class="form-check form-check-flat mt-0">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="rememberme" id="rememberme" value="forever" checked> <?php echo __( 'Keep me signed in' ) ?> <i class="input-helper"></i></label>
                    </div>
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-small forgot-password text-black"><?php _e( 'Lost your password?' ); ?></a>
                  </div>
                 
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold">Not a member ?</span>
                    <a href="<?php echo esc_url( wp_registration_url() ) ?>" class="text-black text-small"><?php echo __( 'Create new account' ) ?></a>
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