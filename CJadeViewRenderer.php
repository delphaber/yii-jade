<?php
/**
 * CJadeViewRenderer class file.
 *
 * @author Fabrizio Monti <fabrizio.monti@welaika.com>
 * @link http://welaika.com
 * @copyright Copyright &copy; 2012 Fabrizio Monti
 * @license BSD
 *
 * Based on HamlViewRenderer class file
 *
 * @author			Chris Yates <chris.l.yates@gmail.com>
 * @copyright		Copyright &copy; 2010 PBM Web Development
 * @license			http://phamlp.googlecode.com/files/license.txt
 * @package			PHamlP
 *
 * Based on CViewRenderer class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2012 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::setPathOfAlias('Jade', dirname(__FILE__).'/vendors/jade/src/Jade');

class CJadeViewRenderer extends CViewRenderer
{
  /**
   * @var Jade the Jade parser
   */
  private $jade;
  /**
   * @var boolean whether to store the parsing results in the application's
   * runtime directory. Defaults to true. If false, the parsing results will
   * be saved as files under the same directory as the source view files and the
   * file names will be the source file names appended with letter 'c'.
   */
  public $useRuntimePath=true;
  /**
   * @var integer the chmod permission for temporary directories and files
   * generated during parsing. Defaults to 0755 (owner rwx, group rx and others rx).
   */
  public $filePermission=0755;
  /**
   * @var string the extension of input view file. Defaults to '.jade'.
   */
  public $fileExtension='.jade';

  /**
   * @var string the extension of output view file. Defaults to '.php'
   */
  public $viewFileExtension = '.php';

  /**
   * @var string the string to be written before the compiled template. Can be set in main.php. E.g. 'prepend' => array('<?php extract((array)$data); ?>')
   */
  public $prepend;

  /**
   * Init a Jade parser instance
   */
  public function init() {
    parent::init();
    $this->jade = new Jade\Jade();
  }

  /**
   * Parses the source view file and saves the results as another file.
   * @param string $sourceFile the source view file path
   * @param string $viewFile the resulting view file path
   */
  protected function generateViewFile($sourceFile,$viewFile)
  {
    if (substr($sourceFile, strlen($this->fileExtension) * -1) === $this->fileExtension) {
      if ($this->jade == null)
        $this->init();

      $data = $this->jade->render($sourceFile);
    } else {
      $data = file_get_contents($sourceFile);
    }
    file_put_contents($viewFile, $this->prepend[0] . $data);
  }

  /**
   * Renders a view file.
   * This method is required by {@link IViewRenderer}.
   * @param CBaseController $context the controller or widget who is rendering the view file.
   * @param string $sourceFile the view file path
   * @param mixed $data the data to be passed to the view
   * @param boolean $return whether the rendering result should be returned
   * @return mixed the rendering result, or null if the rendering result is not needed.
   */
  public function renderFile($context,$sourceFile,$data,$return)
  {
    $jadeSourceFile = substr($sourceFile, 0, strrpos($sourceFile, '.')).$this->fileExtension;

    if(!is_file($jadeSourceFile) || ($file=realpath($jadeSourceFile))===false)
      return parent::renderFile($context, $sourceFile, $data, $return);

    $viewFile = $this->getViewFile($sourceFile);
    $viewFile = str_replace($this->fileExtension.($this->useRuntimePath?'':'c'), $this->viewFileExtension, $viewFile);

    if(@filemtime($sourceFile) > @filemtime($viewFile))
    {
      $this->generateViewFile($sourceFile,$viewFile);
      @chmod($viewFile,$this->filePermission);
    }
    return $context->renderInternal($viewFile,$data,$return);
  }

}
