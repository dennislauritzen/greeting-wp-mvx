<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails-old/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 7.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
        <link rel='stylesheet' id='style-css' href='https://www.greeting.dk/wp-content/themes/greeting2/style.css?ver=3.0.4' media='all' />
        <link rel='stylesheet' id='main-css' href='https://www.greeting.dk/wp-content/themes/greeting2/assets/css/main.css?ver=3.0.4' media='all' />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Merriweather:wght@300;400;700;900&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <style type="text/css">
            html,body {
                padding: 0;
                margin: 0;
                background: #ffffff;
            }

            #logo {
                width: 250px;
            }
            @media only screen and (max-width: 800px) {
                #logo {
                    width: 300px !important;
                    padding: 10px 0 10px 0 !important;
                }
            }

            td.cr-cell {
                padding-left: 10px;
                padding-bottom: 10px;
            }
            td.contact-icon-cell {
                padding-bottom: 10px;
                padding-right: 10px;
            }
            @media only screen and (max-width: 800px) {
                td.cr-cell,
                td.contact-icon-cell {
                    padding-bottom: 20px !important;
                }
            }

            img.customerreviews {
                width: 250px;
            }
            img.customerreviews a {
                border: 0;
            }
            @media only screen and (max-width: 800px) {
                img.customerreviews {
                    width: 300px;
                }
            }

            img.phone-icon,
            img.mail-icon {
                width: 45px;
                height: 45px;
            }

            @media only screen and (max-width: 800px) {
                img.phone-icon,
                img.mail-icon {
                    width: 75px !important;
                    height: 75px !important;
                    padding-right: 10px !important;
                }
            }

            td.order-heading {
                padding: 50px 0 15px 0;
            }
            @media only screen and (max-width: 800px) {
                td.summary-heading,
                td.order-heading {
                    padding-left: 10px;
                }
            }

            table.order-summary {
                font-size: 15px;
            }
            @media only screen and (max-width: 800px) {
                table.order-summary {
                    font-size: 14px;
                }
            }

            table.order-details,
            tr.order-details-totals-row {
                font-size: 14px;
            }
            @media only screen and (max-width: 800px) {
                table.order-details,
                tr.order-details-totals-row{
                    font-size: 13px;
                }
            }

            td.delivery-options-cell,
            td.your-options-cell {
                vertical-align: top;
                width: 50%;
                padding: 50px 0 0 0;
            }
            td.your-options-cell-mobile {
                display: none;
            }
            td.delivery-options-cell p,
            td.your-options-cell p,
            td.your-options-cell-mobile p {
                font-size: 13px;
            }
            td.your-options-cell {
                text-align: right;
            }
            @media only screen and (max-width: 800px) {
                td.your-options-cell {
                    display: none;
                }

                td.delivery-options-cell,
                td.your-options-cell-mobile {
                    padding-left: 15px;
                    display: table-cell;
                    width: 100%;
                }
            }


            label {
                font-family: 'Inter', sans-serif;
            }

            h1, h2, h3, h4 {
                font-family: 'Merriweather', sans-serif;
                line-height: 110%;
            }
            h1 {
                font-size: 28px;
                font-weight: 500;
            }
            h2 {
                font-size: 25px;
                font-weight: 500;
            }
            h3 {
                font-size: 22px !important;
                font-weight: 500 !important;
            }

            @media only screen and (max-width: 800px) {
                h1 {
                    font-size: 22px;
                    font-weight: 500;
                }
                h2 {
                    font-size: 19px;
                    font-weight: 500;
                }
                h3 {
                    font-size: 16px !important;
                    font-weight: 500 !important;
                }
            }
            input {
                font-family: 'Inter', sans-serif;
            }
            input[type="radio"] {
                width: 4%;
                min-width: 20px;
            }
            .form-row-label {
                width: 95%;
            }

            p {
                line-height: 150% !important;
            }

            table.social {

            }
            table.social p {
                font-size: 14px;
            }
            @media only screen and (max-width: 800px) {
                table.social p {
                    font-size: 13px;
                }
            }

            #greeting-footer h6 {
                font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif;
                font-size: 20px;
                color: #1b4949;
            }
            #greeting-footer .greeting-footer-logo {
                width: 175px;
            }
            @media only screen and (max-width: 800px) {
                #greeting-footer .greeting-footer-logo {
                    width: 275px;
                }
            }

            #greeting-footer .left-col {
                padding: 0 0 0 20px;
            }
            #greeting-footer .right-col {
                padding: 0 20px 0 0;
            }
            #greeting-footer h6.light {
                font-family: 'Rubik', 'Inter', 'Comic Sans', sans-serif;
                font-size: 18px;
                text-transform: uppercase;
                color: #ffffff;
            }
            #greeting-footer h4 a,
            #greeting-footer h6 a {
                color: #1b4949;
            }
            #greeting-footer h6.light a {
                color: #ffffff;
            }
            #greeting-footer ul {
                font-family: 'Inter', 'Comic Sans', sans-serif;
                font-weight: 300;
            }

            #greeting-footer ul.social {
                width: 150px;
                list-style: none;
                margin: -30px 0 0 -100px;
                padding: 0 5px 0 0;
            }
            #greeting-footer ul.social li {
                float: left;
                width: 45px;
                margin: 0;
                padding: 0;
            }
            #greeting-footer ul.footer-menu,
            #greeting-footer p {
                font-size: 13px;
            }
            #greeting-footer p a {
                color: #ffffff;
            }
            @media only screen and (max-width: 800px) {
                #greeting-footer ul.footer-menu,
                #greeting-footer p {
                    font-size: 15px;
                }
            }
            #greeting-footer ul.social li a {
                color: #ffffff;
            }
            #formal-footer {
                border-top: 3px solid #fecbca;
                font-family: 'Inter',sans-serif;
                font-size: 12px;
                color: #555555;
            }
            #formal-footer ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            #formal-footer ul li {
                float: left;
                margin: 0;
                padding: 0 10px 0 0;
            }
        </style>
	</head>

	<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="background-color: #ffffff;">
    <!--[if gte mso 9]><table width="600" cellpadding="0" cellspacing="0"><tr><td><![endif]-->
    <table width="100%" style="width: 100%;">
        <tr style="background-color: #4d696b;">
            <td align="center">
                <table width="800" style="width:800px;" id="header">
                    <tr>
                        <td width="100%" colspan="2" style="padding: 30px 0 5px 0; width: 100%; text-align: center;">
                            <a href="<?php echo home_url(); ?>" style="padding: 5px 0 0 0;">
                                <img src="https://www.greeting.dk/wp-content/uploads/2023/06/mail-logo.png" id="logo" />
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%"  class="cr-cell" style="text-align: left;">
                            <a href="https://dk.trustpilot.com/review/greeting.dk">
                                <img class="customerreviews" src="https://www.greeting.dk/wp-content/uploads/2023/06/customer-reviews-94-new-v4.png">
                            </a>
                        </td>
                        <td width="50%" class="contact-icon-cell" style="text-align: right;">
                            <a href="tel:+4571901834" title="Ring til os her, hvis du oplever problemer eller har spørgsmål.">
                                <img class="phone-icon" src="https://www.greeting.dk/wp-content/uploads/2023/06/icon-phone.png">
                            </a>
                            <a href="mailto:kontakt@greeting.dk" alt="E-mail" title="Skriv til os her, hvis du oplever problemer eller har spørgsmål.">
                                <img class="mail-icon" src="https://www.greeting.dk/wp-content/uploads/2023/06/icon-mail.png">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
