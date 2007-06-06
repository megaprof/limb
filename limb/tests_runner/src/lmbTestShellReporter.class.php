<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

/**
 * class lmbTestShellReporter.
 *
 * @package tests_runner
 * @version $Id: lmbTestShellReporter.class.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class lmbTestShellReporter extends TextReporter
{
  function paintCaseEnd($test_name)
  {
    parent :: paintCaseEnd($test_name);

    echo $this->getTestCaseProgress() . " of " . $this->getTestCaseCount() . " done({$test_name})\n";
  }
}
?>