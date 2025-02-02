<?php
/**
 * Common Template main_template_vars handler
 *
 * Normally a page will automatically load its own template based on the page name.
 * so that a page called some_page will load tpl_some_page_default.php from the template directory.
 *
 * However sometimes a page may need to choose the template it displays based on a set of criteria.
 * Placing a file in the includes/modules/pages/some_page/ directory called main_template_vars.php
 * allows you to override this page and choose the template that loads.
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2024 Jan 31 Modified in v2.0.0-beta1 $
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

  $zco_notifier->notify('NOTIFY_MAIN_TEMPLATE_VARS_START', $template_dir);

/**
 * set some variables used by templates
 */
  // Removed layoutType handling and hardcoded the value
  $layoutType = 'legacy'; // You can keep or remove this line based on your needs
  
  if (!isset($max_display_page_links)) $max_display_page_links = MAX_DISPLAY_PAGE_LINKS;
  if (!isset($paginateAsUL)) $paginateAsUL = false; // Removed the mobile/tablet checks
  if (!isset($flag_disable_left)) {
    $flag_disable_left = false;
  }
  if (!isset($flag_disable_right)) {
    $flag_disable_right = false;
  }

/**
 * load page-specific main_template_vars if present, or jump directly to template file
 */
  $body_code = $pageLoader->getBodyCode();

  $zco_notifier->notify('NOTIFY_MAIN_TEMPLATE_VARS_END', $template_dir, $body_code);
