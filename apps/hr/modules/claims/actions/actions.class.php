<?php

/**
 * claims actions.
 *
 * @package    qualityRecords
 * @subpackage claims
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class claimsActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }
  
  public function executeGovtPaidChildCare()
  {
  	
  }
}
