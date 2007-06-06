<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

/**
 * Compile time component for elispses in a pager.
 * Elipses are sed to mark omitted page numbers outside of the
 * current range of the pager e.g. ...6 7 8... (the ... are the elipses)
 * @tag pager:ELIPSES
 * @restrict_self_nesting
 * @parent_tag_class WactPagerListTag
 * @package wact
 * @version $Id: elipses.tag.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class WactPagerElipsesTag extends WactSilentCompilerTag
{
}

?>