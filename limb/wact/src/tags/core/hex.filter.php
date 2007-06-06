<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

/**
 * @filter hex
 * @package wact
 * @version $Id: hex.filter.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class WactHexFilter extends WactCompilerFilter
{
  function getValue()
  {
    if ($this->isConstant())
      return str_replace('&#x;', '', preg_replace("/(.)*/Uimse", "'&#x'.bin2hex('\\1').';'", $this->base->getValue()));
    else
      $this->raiseUnresolvedBindingError();
  }

  function generateExpression($code_writer)
  {
    $code_writer->writePHP('str_replace(\'&#x;\', \'\', preg_replace("/(.)*/Uimse", "\'&#x\'.bin2hex(\'\\\\1\').\';\'", ');
    $this->base->generateExpression($code_writer);
    $code_writer->writePHP('))');
  }
}

?>
