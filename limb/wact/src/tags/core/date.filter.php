<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

/**
 * @filter date
 * @max_attributes 1
 * @package wact
 * @version $Id: date.filter.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class WactDateFilter extends WactCompilerFilter
{
  function getValue()
  {
    if ($this->isConstant())
    {
     $value = $this->base->getValue();
     $exp = $this->parameters[0]->getValue();
     return date($exp, $value);
    } else {
     $this->raiseUnresolvedBindingError();
    }
  }

  function generateExpression($code_writer)
  {
    $code_writer->writePHP('date(');
    $this->parameters[0]->generateExpression($code_writer);
    $code_writer->writePHP(',');
    $this->base->generateExpression($code_writer);
    $code_writer->writePHP(')');
  }
}
?>
