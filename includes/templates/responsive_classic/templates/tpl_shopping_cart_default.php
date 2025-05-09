<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=shopping_cart.
 * Displays shopping-cart contents
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Steve 2023 Sep 07 Modified in v2.0.0-alpha1 $
 */
?>
 
<div class="centerColumn" id="shoppingCartDefault">
<?php
  if ($flagHasCartContents) {
?>

<?php
  if ($_SESSION['cart']->count_contents() > 0) {
?>
<div class="forward"><?php echo TEXT_CART_HELP; ?></div>
<?php
  }
?>

<h1 id="cartDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if ($messageStack->size('shopping_cart') > 0) echo $messageStack->output('shopping_cart'); ?>

<?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product' . '#cartInstructionsDisplay', $request_type), 'post', 'id="shoppingCartForm"'); ?>
<div id="cartInstructionsDisplay" class="content"><?php
/**
 * require the html_define for the shopping_cart page
 */
    require($define_page);
?></div>

<?php if (!empty($totalsDisplay)) { ?>
  <div class="cartTotalsDisplay important"><?php echo $totalsDisplay; ?></div>
<?php } ?>

<?php  if ($flagAnyOutOfStock) { ?>

<?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>

<div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>

<?php    } else { ?>
<div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>

<?php    } //endif STOCK_ALLOW_CHECKOUT ?>
<?php  } //endif flagAnyOutOfStock ?>

<table id="cartContentsDisplay">
     <tr class="tableHeading">
        <th scope="col" id="scQuantityHeading"><?php echo TABLE_HEADING_QUANTITY; ?></th>
        <th aria-label="Update Quantity" scope="col" id="scUpdateQuantity">Update Quantity</th>
        <th scope="col" id="scProductsHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
        <th scope="col" id="scUnitHeading"><?php echo TABLE_HEADING_PRICE; ?></th>
        <th scope="col" id="scTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
        <th aria-label="Remove this product from the cart" scope="col" id="scRemoveHeading">Remove this product from the cart</th>
     </tr>
         <!-- Loop through all products /-->
<?php
  foreach ($productArray as $product) {
?>
     <tr class="<?php echo $product['rowClass']; ?>">
       <td class="cartQuantity">
<?php
  if ($product['flagShowFixedQuantity']) {
    echo $product['showFixedQuantityAmount'];
  } else {
    echo $product['quantityField'];
  }
?><br>
        <span class="alert bold"><?php echo $product['flagStockCheck'];?></span><br>
        <br><?php echo $product['showMinUnits']; ?>
       </td>
       <td class="cartQuantityUpdate"><?php echo $product['buttonUpdate']; ?></td>
       <td class="cartProductDisplay">

<a href="<?php echo $product['linkProductsName']; ?>"><span class="cartImage back"><?php echo $product['productsImage']; ?></span><span class="cartProdTitle"><?php echo $product['productsName'] . '<span class="alert bold">' . $product['flagStockCheck'] . '</span>'; ?></span></a>
<br class="clearBoth">
<?php
  echo $product['attributeHiddenField'];
  if (isset($product['attributes']) && is_array($product['attributes'])) {
    echo '<div class="cartAttribsList">';
    echo '<ul>';
    foreach ($product['attributes'] as $option => $value) {
?>

<li>
    <?php
    echo $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']);
    ?>
</li>

<?php
    }
  echo '</ul>';
  echo '</div>';
  }
?>
       </td>
       <td class="cartUnitDisplay"><?php echo $product['productsPriceEach']; ?></td>
       <td class="cartTotalDisplay"><?php echo $product['productsPrice']; ?></td>
       <td class="cartRemoveItemDisplay">
<?php
  if ($product['buttonDelete']) {
?>
         <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']); ?>" title="Remove this product from the cart"><i class="fas fa-trash-alt fa-xl" aria-hidden="true" title="<?php echo ICON_TRASH_ALT; ?>"></i></a>
<?php
  }
  if ($product['checkBoxDelete'] ) {
    echo zen_draw_checkbox_field('cart_delete[]', $product['id'], false, 'aria-label="' . ARIA_DELETE_ITEM_FROM_CART . '"');
  }
?>
      </td>
     </tr>
<?php
  } // end foreach ($productArray as $product)
?>
       <!-- Finished loop through all products /-->
</table>

<div id="cartSubTotal"><?php echo SUB_TITLE_SUB_TOTAL; ?> <?php echo $cartShowTotal; ?></div>
<br class="clearBoth">

<!--bof shopping cart buttons-->

<div class="shopping_cart_spacer">
  <div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHECKOUT, BUTTON_CHECKOUT_ALT) . '</a>'; ?></div>
  <div class="buttonRow continueshoppingb "><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_CONTINUE_SHOPPING, BUTTON_CONTINUE_SHOPPING_ALT) . '</a>'; ?></div>
</div>
<?php
// show update cart button
  if (SHOW_SHOPPING_CART_UPDATE == 2 or SHOW_SHOPPING_CART_UPDATE == 3) {
?>
<div class="buttonRow back"><?php echo zen_image_submit(ICON_IMAGE_UPDATE, ICON_UPDATE_ALT); ?></div>
<?php
  } else { // don't show update button below cart
?>
<?php
  } // show update button
?>
<!--eof shopping cart buttons-->
</form>

<br class="clearBoth">
<?php
    if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '1') {
?>

<div class="buttonRow shippingestimaterb"><?php echo '<a href="javascript:popupWindow(\'' . zen_href_link(FILENAME_POPUP_SHIPPING_ESTIMATOR) . '\')">' .
 zen_image_button(BUTTON_IMAGE_SHIPPING_ESTIMATOR, BUTTON_SHIPPING_ESTIMATOR_ALT) . '</a>'; ?></div>
<?php
    }
?>

<!-- ** BEGIN PAYPAL EXPRESS CHECKOUT ** -->
<?php  // the tpl_ec_button template only displays EC option if cart contents >0 and value >0
if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
  include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');
}
?>
<!-- ** END PAYPAL EXPRESS CHECKOUT ** -->

<?php
      if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '2') {
/**
 * load the shipping estimator code if needed
 */
?>
      <?php require(DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php')); ?>

<?php
      }

    // -----
    // Enable extra content to be included, via additional header_php_*.php files present
    // in /includes/modules/pages/shopping_cart.
    //
    if (!empty($extra_content_shopping_cart) && is_array($extra_content_shopping_cart)) {
        foreach ($extra_content_shopping_cart as $extra_content) {
            require $extra_content;
        }
    }
?>
<?php
  } else {
?>

<h2 id="cartEmptyText"><?php echo TEXT_CART_EMPTY; ?></h2>

<?php
    // -----
    // Enable extra content to be included, via additional header_php_*.php files present
    // in /includes/modules/pages/shopping_cart.
    //
    if (!empty($extra_content_shopping_cart) && is_array($extra_content_shopping_cart)) {
        foreach ($extra_content_shopping_cart as $extra_content) {
            require $extra_content;
        }
    }

$show_display_shopping_cart_empty = $db->Execute(SQL_SHOW_SHOPPING_CART_EMPTY);

while (!$show_display_shopping_cart_empty->EOF) {
?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_FEATURED_PRODUCTS') { ?>
<?php
/**
 * display the Featured Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_SPECIALS_PRODUCTS') { ?>
<?php
/**
 * display the Special Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_NEW_PRODUCTS') { ?>
<?php
/**
 * display the New Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_UPCOMING') {
    include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
  }
?>
<?php
  $show_display_shopping_cart_empty->MoveNext();
} // !EOF
?>
<?php
  }
?>
</div>
