<?php
/**
 * Smarty Template class
 *
 * @author Christophe Gosiau <christophe@tigron.be>
 * @author Gerry Demaret <gerry@tigron.be>
 */

namespace Skeleton\Template\Smarty;
include 'smarty_extensions.php';

class Smarty {

	/**
	 * Smarty object
	 *
	 * @access private
	 * @var Smarty $smarty
	 */
	private $smarty = null;

	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct() {
		$this->smarty = new \Smarty();
		$this->smarty->compile_dir = TMP_PATH .'/templates_c/';
		$this->smarty->setCacheDir(TMP_PATH . '/templates_t/');
		$this->smarty->registerPlugin('block', 't', 'smarty_block_translation');
		$this->smarty->registerPlugin('modifier', 'date_format', 'smarty_modifier_datetime_format');
		$this->smarty->registerPlugin('modifier', 'datetime_format', 'smarty_modifier_datetime_format');
		$this->smarty->registerPlugin('function', 'snippet', 'smarty_function_snippet');
		$this->smarty->registerPlugin('modifier', 'markdown', 'smarty_modifier_markdown');
		$this->smarty->debugging = Config::$debug;
		$this->smarty->error_reporting = Config::$error_reporting;
	}

	/**
	 * Set Template dir
	 *
	 * @access public
	 * @param string $directory
	 */
	public function add_template_directory($directory) {
		$this->smarty->addTemplateDir($directory);
	}

	/**
	 * Set translation
	 *
	 * @access public
	 * @param Translation $translation
	 */
	public function set_translation(\Skeleton\I18n\Translation $translation) {
		$environment = array(
			'translation' => $translation
		);
		$this->smarty->assign('env', $environment);
	}

	/**
	 * Assign a variable
	 *
	 * @access public
	 * @param string $key
	 * @param mixed $value
	 */
	public function assign($key, $value) {
		$this->smarty->assign($key, $value);
	}

	public function add_environment($key, $value) {
		$this->smarty->assign('env_' . $key, $value);
	}

	/**
	 * Render
	 *
	 * @access public
	 * @param string $template
	 * @return string $html
	 */
	public function render($template) {
		return $this->smarty->fetch($template);
	}

	/**
	 * Validate
	 *
	 * @access public
	 * @param string $template
	 * @param string &$error
	 * @return bool
	 */
	public function validate($template, &$error): bool {
		throw new \Exception('Not yet implemented');
	}
}
