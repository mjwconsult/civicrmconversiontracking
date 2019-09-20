<?php

require_once 'vitiligodonatetracking.civix.php';
use CRM_Vitiligodonatetracking_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function vitiligodonatetracking_civicrm_config(&$config) {
  _vitiligodonatetracking_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function vitiligodonatetracking_civicrm_xmlMenu(&$files) {
  _vitiligodonatetracking_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function vitiligodonatetracking_civicrm_install() {
  _vitiligodonatetracking_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function vitiligodonatetracking_civicrm_postInstall() {
  _vitiligodonatetracking_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function vitiligodonatetracking_civicrm_uninstall() {
  _vitiligodonatetracking_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function vitiligodonatetracking_civicrm_enable() {
  _vitiligodonatetracking_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function vitiligodonatetracking_civicrm_disable() {
  _vitiligodonatetracking_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function vitiligodonatetracking_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _vitiligodonatetracking_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function vitiligodonatetracking_civicrm_managed(&$entities) {
  _vitiligodonatetracking_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function vitiligodonatetracking_civicrm_caseTypes(&$caseTypes) {
  _vitiligodonatetracking_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function vitiligodonatetracking_civicrm_angularModules(&$angularModules) {
  _vitiligodonatetracking_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function vitiligodonatetracking_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _vitiligodonatetracking_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function vitiligodonatetracking_civicrm_entityTypes(&$entityTypes) {
  _vitiligodonatetracking_civix_civicrm_entityTypes($entityTypes);
}



/**
 *
 */
function vitiligodonatetracking_civicrm_buildForm($formName, &$form) {
  Civi::log()->info(__FUNCTION__ . " called with form '$formName'");
  if ($formName == 'CRM_Contribute_Form_Contribution_ThankYou') {

    $r = CRM_Core_Resources::singleton();

		// Check for Do Not Track and do nothing if it's set.
    if (isset($_SERVER['HTTP_DNT']) && $_SERVER['HTTP_DNT'] == 1) {
      $r->addScript('console.log("Do Not Track enabled, respecting this and not recording payment with Google Analytics.");');
      return;
    }

    // VITILIGO_MEMBERSHIP_FORM_ID = '1'; VITILIGO_DONATION_FORM_ID   = '2';
    CRM_Core_Resources::singleton()->addVars('VitiligoDonateTracking', [
      'totalAmount'  => $form->_amount,
      'trxnId'       => $form->_trxnId,
      'formId'       => $form->_id,
      'contribType'  => ($form->_id == 1) ? 'Membership' : 'Donate',
    ]);

    $r->addScriptFile('vitiligodonatetracking', 'js/vitiligodonatetracking.js');
    $r->addScript('CRM.$(vitiligoTracking);');
  }
}

