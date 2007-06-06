<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
require_once(dirname(__FILE__). '/lmbTestTreeNode.class.php');
require_once(dirname(__FILE__). '/lmbTestTreeDirNode.class.php');

/**
 * class lmbTestTreeGlobNode.
 *
 * @package tests_runner
 * @version $Id: lmbTestTreeGlobNode.class.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class lmbTestTreeGlobNode extends lmbTestTreeNode
{
  protected $glob;

  function __construct($glob)
  {
    $this->glob = $glob;

    foreach(glob($glob) as $item)
      $this->addChild(new lmbTestTreeDirNode($item));
  }

  function getTestLabel()
  {
    return 'All ' . $this->glob . ' tests ';
  }

  function createTestGroup()
  {
    $group = new GroupTest();
    foreach($this->children as $child)
      $group->addTestCase($child->createTestGroup());
    return $group;
  }

  function createTestGroupWithoutChildren()
  {
    return new GroupTest();
  }
}

?>
