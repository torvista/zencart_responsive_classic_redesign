<?php
/**
 * Page Template
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: brittainmark 2023 May 23 Modified in v2.0.0-alpha1 $
 */
?>
<div class="centerColumn" id="loginDefault">
    <h1 id="loginDefaultHeading"><?php echo HEADING_TITLE; ?></h1>
    <?php if ($messageStack->size('login') > 0) {
        echo $messageStack->output('login');
    } ?>

    <?php if (USE_SPLIT_LOGIN_MODE == 'True' || $ec_button_enabled) { ?>
        <!--BOF PPEC split login- DO NOT REMOVE-->
        <fieldset class="floatingBox back">
            <legend><?php echo HEADING_NEW_CUSTOMER_SPLIT; ?></legend>

            <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT ** ?>
            <?php if ($ec_button_enabled) { ?>
                <div class="information"><?php echo TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT; ?></div>
                <div class="center"><?php require(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php'); ?></div>
                <hr/>
                <?php echo TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER; ?>
            <?php } ?>
            <?php // ** END PAYPAL EXPRESS CHECKOUT ** ?>

            <div class="information"><?php echo TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT; ?></div>
            <?php echo zen_draw_form('create', zen_href_link(FILENAME_CREATE_ACCOUNT, (isset($_GET['gv_no']) ? '&gv_no=' . preg_replace('/[^0-9.,%]/', '', $_GET['gv_no']) : ''), 'SSL')); ?>

            <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CREATE_ACCOUNT, BUTTON_CREATE_ACCOUNT_ALT, 'name="registrationButton"'); ?></div>
            <?php echo '</form>'; ?>
        </fieldset>

        <fieldset class="floatingBox forward">
            <legend><?php echo HEADING_RETURNING_CUSTOMER_SPLIT; ?></legend>
            <div class="information2"><?php echo TEXT_RETURNING_CUSTOMER_SPLIT; ?></div>
            <?php echo zen_draw_form('loginForm', zen_href_link(FILENAME_LOGIN, 'action=process' . (isset($_GET['gv_no']) ? '&gv_no=' . preg_replace('/[^0-9.,%]/', '', $_GET['gv_no']) : ''), 'SSL'), 'post', 'id="loginForm"'); ?>

            <label class="inputLabel" for="login-email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
            <?php echo zen_draw_input_field('email_address', '', 'size="18" id="login-email-address" autofocus autocomplete="username" placeholder="' . ENTRY_EMAIL_ADDRESS_TEXT . '"' . ((int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0 ? ' required' : ''), 'email'); ?>
            <br class="clearBoth">

            <label class="inputLabel" for="login-password"><?php echo ENTRY_PASSWORD; ?></label>
            <?php echo zen_draw_password_field('password', '', 'size="18" id="login-password" autocomplete="current-password" placeholder="' . ENTRY_REQUIRED_SYMBOL . '"' . ((int)ENTRY_PASSWORD_MIN_LENGTH > 0 ? ' required' : '')); ?>
            <br class="clearBoth">

            <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT); ?></div>
            <div class="buttonRow back important"><?php echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></div>
            <?php echo '</form>'; ?>
        </fieldset>

        <br class="clearBoth">
        <!--EOF PPEC split login- DO NOT REMOVE-->
    <?php } else { ?>
        <!--BOF normal login-->
        <?php
        if ($_SESSION['cart']->count_contents() > 0) {
            ?>
            <div class="advisory"><?php echo TEXT_VISITORS_CART; ?></div>
            <?php
        }
        ?>
        <?php echo zen_draw_form('loginForm', zen_href_link(FILENAME_LOGIN, 'action=process' . (isset($_GET['gv_no']) ? '&gv_no=' . preg_replace('/[^0-9.,%]/', '', $_GET['gv_no']) : ''), 'SSL'), 'post', 'id="loginForm"'); ?>
        <fieldset>
            <legend><?php echo HEADING_RETURNING_CUSTOMER; ?></legend>

            <label class="inputLabel" for="login-email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
            <?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="login-email-address" autofocus autocomplete="username" placeholder="' . ENTRY_EMAIL_ADDRESS_TEXT . '"' . ((int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0 ? ' required' : ''), 'email'); ?>
            <br class="clearBoth">

            <label class="inputLabel" for="login-password"><?php echo ENTRY_PASSWORD; ?></label>
            <?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', 40) . ' id="login-password" autocomplete="current-password" placeholder="' . ENTRY_REQUIRED_SYMBOL . '"' . ((int)ENTRY_PASSWORD_MIN_LENGTH > 0 ? ' required' : '')); ?>
            <br class="clearBoth">
            <?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
        </fieldset>

        <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT); ?></div>
        <div class="buttonRow back important"><?php echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></div>
        <?php echo '</form>'; ?>
        <br class="clearBoth">

        <?php echo zen_draw_form('createAccountForm', zen_href_link(FILENAME_CREATE_ACCOUNT, (isset($_GET['gv_no']) ? '&gv_no=' . preg_replace('/[^0-9.,%]/', '', $_GET['gv_no']) : ''), 'SSL'), 'post', 'onsubmit="return check_form(createAccountForm);" id="createAccountForm"') . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('email_pref_html', 'email_format'); ?>
        <fieldset>
            <legend><?php echo HEADING_NEW_CUSTOMER; ?></legend>
            <div class="information"><?php echo TEXT_NEW_CUSTOMER_INTRODUCTION; ?></div>
            <?php require($template->get_template_dir('tpl_modules_create_account.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_create_account.php'); ?>
        </fieldset>

        <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); ?></div>
        <?php echo '</form>'; ?>
        <!--EOF normal login-->
    <?php } ?>
</div>
