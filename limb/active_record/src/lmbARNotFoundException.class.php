<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

/**
 * class lmbARNotFoundException.
 *
 * @package active_record
 * @version $Id: lmbARNotFoundException.class.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class lmbARNotFoundException extends lmbARException
{
  protected $id;
  protected $class;

  function __construct($class, $id)
  {
    $this->id = $id;
    $this->class = $class;

    parent :: __construct("Can't load ActiveRecord '" . $class . "' with id '$id'");
  }

  function getId()
  {
    return $this->id;
  }

  function getClass()
  {
    return $this->class;
  }
}

?>