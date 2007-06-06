<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
lmb_require('limb/web_app/src/command/lmbActionCommand.class.php');

/**
 * class lmbClosePopupDialogCommand.
 *
 * @package web_app
 * @version $Id: lmbClosePopupDialogCommand.class.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class lmbClosePopupDialogCommand extends lmbActionCommand
{
  function __construct()
  {
    parent :: __construct('close_popup.html');
  }

  function perform()
  {
    $this->resetView();
    parent :: perform();
  }
}


?>
