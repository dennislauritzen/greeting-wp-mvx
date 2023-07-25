<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 6.0.0
 */

defined( 'ABSPATH' ) || exit;

// Get the users first name if it is set, else username.
$user = get_user_by('login', $user_login );
$user_name = (empty($user->first_name) ? $user_login : $user->first_name);

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer username */ ?>
<?php /* translators: %1$s: Site title, %2$s: Username, %3$s: My account link */ ?>

<!-- THE CONTENT -->
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="width: 100%; text-align: center; border-collapse: collapse;">
    <tr style="text-align: center;">
        <td align="center" style="text-align: center; padding: 0 15px;">
            <table width="770" border="0"cellpadding="0" cellspacing="0" style="text-align: left; margin: 0 auto; width: 770px; max-width: 770px; border-collapse: collapse;">
                <tr>
                    <td colspan="2" class="summary-heading" style="padding-bottom: 20px;">
                        <table width="100%" border="0"cellpadding="0" cellspacing="0" style="width: 100%; max-width: 800px; border-collapse: collapse;">
                            <tr>
                                <td width="75%" style="width: 75%;">
                                    <h1 style="margin-top: 25px;"><?php echo $email_heading; ?></h1>
																		<small>
                                      <img width="15" height="15" src="https://s.w.org/images/core/emoji/14.0.0/72x72/2764.png" style="display: inline-block; width: 15px !important; max-width: 20px; height: 15px; max-height: 20px; font-size: 12px;">
                                      &nbsp; <?php echo $additional_content; ?>
                                   	</small>
                                </td>
																<td width="25%" style="width: 25%">
																		&nbsp;
																</td>
                            </tr>
                        </table>
                    </td>
                </tr>
								<tr>
										<td colspan="2" class="summary-heading" style="padding-bottom: 20px;">
												<table width="100%" border="0"cellpadding="0" cellspacing="0" style="width: 100%; max-width: 800px; border-collapse: collapse;">
														<tr>
																<td width="100%" style="width: 100%;">
																		<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $user_name ) ); ?></p>
																		<p>
																			<?php printf( esc_html__( 'Thanks for creating an account on %1$s. Your username is %2$s. You can access your account area to view orders, change your password, and more at: %3$s', 'woocommerce' ), esc_html( $blogname ), '<strong>' . esc_html( $user_login ) . '</strong>', make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
																		</p>
																		<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated && $set_password_url ) : ?>
																			<?php // If the password has not been set by the user during the sign up process, send them a link to set a new password ?>
																			<p><a href="<?php echo esc_attr( $set_password_url ); ?>"><?php printf( esc_html__( 'Click here to set your new password.', 'woocommerce' ) ); ?></a></p>
																		<?php endif; ?>
																</td>
														</tr>
												</table>
										</td>
								</tr>
            </table>
        </td>
    </tr>
</table>
<table width="100%" class="social" style="width: 100%;;">
    <tr>
        <td align="center" style="text-align: center; padding: 0 15px;">
            <table width="770" style="width: 770px; max-width: 770px;">
                <tr>
                    <td valign="top" width="50%" class="left-col" style="text-align: left; width: 50%; padding: 40px 0;">
                        <h4>Følg os</h4>
                        <p style="margin: 0 20px 0 0;">
                            Kunne du tænke dig at følge med i, hvad vi går og laver - og blive inspireret til din næste gavehilsen?
                            Så følg med på vores profiler på Facebook eller Instagram.
                        </p>
                        <p>
                            <a href="https://www.facebook.com/greeting.dk" class="text-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#446a6b" class="bi bi-facebook" viewBox="0 0 18 18">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                </svg>
                                facebook.com/greeting.dk
                            </a>
                        </p>
                        <p>
                            <a href="https://www.instagram.com/greeting.dk/" class="text-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#446a6b" class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path color="#446a6b" d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                </svg>
                                @greeting.dk
                            </a>
                        </p>
                    </td>
                    <td valign="top" width="50%" class="right-col" style="text-align: left; width: 50%; padding: 40px 0;">
                        <h4>Brug for hjælp?</h4>
                        <p>
                            Er du i tvivl om noget vedrørende din ordre, eller har du rettelser? Så
                            tag endelig fat i os :)
                        </p>
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1b4949" class="pr-2 bi bi-envelope" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                            </svg>
                            <a href="mailto:kontakt@greeting.dk" class="ms-2 text-dark">kontakt@greeting.dk</a>
                        </p>
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1b4949" class="pr-2 bi bi-telephone" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                            </svg>
                            <a href="tel:+4571901834" class="ms-2 text-dark">(+45) 71 90 18 34</a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- THE CONTENT END -->

<?php
#do_action( 'woocommerce_email_footer', $email );
do_action('wcmp_email_footer');
