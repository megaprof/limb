<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
lmb_require('limb/fs/src/lmbFs.class.php');
lmb_require('limb/imagekit/src/lmbImageFactory.class.php');
lmb_require('limb/net/src/lmbMimeType.class.php');
lmb_require('limb/cms/src/model/lmbCmsFileObject.class.php');

/**
 * class lmbCmsImageFileObject.
 *
 * @package cms
 * @version $Id: lmbCmsImageFileObject.class.php 5945 2007-06-06 08:31:43Z pachanga $
 */
class lmbCmsImageFileObject extends lmbCmsFileObject
{
  protected $image_library;

  function resize($max_size)
  {
    $input_file = $this->getFilePath();
    $output_file = lmbFs :: generateTmpFile();

    try
    {
      $image_library = lmbImageFactory :: create();

      $input_file_type = $image_library->getImageType($this->getMimeType());
      $output_file_type = $image_library->fallBackToAnySupportedType($input_file_type);

      $image_library->setInputFile($input_file);
      $image_library->setInputType($input_file_type);

      $image_library->setOutputFile($output_file);
      $image_library->setOutputType($output_file_type);

      $image_library->resize(array('max_dimension' => $max_size));//ugly!!!
      $image_library->commit();
    }
    catch(lmbException $e)
    {
      if(file_exists($output_file))
        unlink($output_file);

      throw $e;
    }

    $this->loadFile($output_file);
    $this->setMimeType(lmbMimeType :: getMimeType($output_file_type));

    unlink($output_file);
  }
}
?>