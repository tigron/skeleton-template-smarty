<?php
/**
 * Config class
 *
 * @author David Vandemaele <david@tigron.be>
 *
 */

namespace Skeleton\Template\Smarty;

class Config {

	/**
	 * Enable debugging
	 *
	 * @access public
	 * @var bool $debug
	 */
	public static $debug = false;

	/**
	 * Error reporting
	 *
	 * @access public
	 * @var string $error_reporting
	 */
	public static $error_reporting = E_ALL & ~E_NOTICE & ~E_STRICT;
}
