<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

/**
 * class lmbFullPageCacheRuleset.
 *
 * @package web_cache
 * @version $Id: lmbFullPageCacheRuleset.class.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class lmbFullPageCacheRuleset
{
  protected $rules = array();
  protected $type = true;

  function __construct($type = true)
  {
    $this->type = $type;
  }

  function setType($type)
  {
    return $this->type = $type;
  }

  function isAllow()
  {
    return $this->type == true;
  }

  function isDeny()
  {
    return $this->type == false;
  }

  function addRule($rule)
  {
    $this->rules[] = $rule;
  }

  function isSatisfiedBy($request)
  {
    foreach($this->rules as $rule)
    {
      if(!$rule->isSatisfiedBy($request))
        return false;
    }

    return true;
  }
}

?>
