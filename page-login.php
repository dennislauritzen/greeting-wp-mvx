<?php
/**
 * Template Name: Page (Login)
 * Description: Login template for the formular.
 *
 */

# Get the headers
get_header();
get_header('green', array('city' => '', 'postalcode' => ''));
?>





<section id="landingpage">
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4"  style="color: #777777; font-family: 'Open Sans','Rubik',sans-serif; font-size: 14px;">
        <?php get_breadcrumb(); ?>
      </div>
    </div>

    <div class="row">
      <div class="col-12 mt-4 pt-2 pb-4">
        <h1>Log ind på din konto på Greeting.dk</h1>
      </div>
    </div>
    <style type="text/css">
      .login-msg-invalid {
        border-left: 4px solid red;
        background: #ffefea;
        padding: 4px 0 6px 10px;
      }
      .login-msg-neutral {
        border-left: 4px solid #888888;
        background: #f0f0f0;
        padding: 4px 0 6px 10px;
      }
    </style>
    <?php
    $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;

    if ( $login === "failed" ) {
      echo '<div class="row">';
      echo '<div class="col-12">';
      echo '<p class="login-msg-invalid"><strong>Fejl:</strong> Brugernavnet eller adgangskoden, du har indtastet, er ikke korrekt.</p>';
      echo '</div>';
      echo '</div>';
    } elseif ( $login === "empty" ) {
      echo '<div class="row">';
      echo '<div class="col-12">';
      echo '<p class="login-msg-invalid"><strong>Fejl:</strong> Du har glemt at indtaste enten brugernavn eller adgangskode.</p>';
      echo '</div>';
      echo '</div>';
    } elseif ( $login === "false" ) {
      echo '<div class="row">';
      echo '<div class="col-12">';
      echo '<p class="login-msg-neutral">Du er hermed logget ud. Vi ses forhåbentligt snart igen :)</p>';
      echo '</div>';
      echo '</div>';
    }
    ?>
    <div class="row">
      <div class="col-12">
        <?php
        # ----------------
        # LOGIN FORM
        # ----------------
        # Customization for the formular.

        $args = array(
            'redirect' => home_url( 'min-konto'),
            'id_username' => 'user',
            'id_password' => 'pass',
           )
        ;
        wp_login_form($args);
        ?>
      </div>
    </div>
  </div>
</section>


<?php
# Get the footer
get_footer();
