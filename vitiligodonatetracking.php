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
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function vitiligodonatetracking_civicrm_install() {
  _vitiligodonatetracking_civix_civicrm_install();
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
 *
 */
function vitiligodonatetracking_civicrm_buildForm($formName, &$form) {
  // Civi::log()->info(__FUNCTION__ . " called with form '$formName'");
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
