<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
lmb_require('limb/dbal/src/lmbTableGateway.class.php');

/**
 * class lmbEmptyDbTable.
 *
 * @package dbal
 * @version $Id: lmbEmptyDbTable.class.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class lmbEmptyDbTable extends lmbTableGateway
{
  protected function _defineDbTableName()
  {
    return '';
  }

  protected function _defineColumns()
  {
    return array();
  }
}


?>