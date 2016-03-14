<?php

use \Michelf\MarkdownExtra;

/**
 * Show a date in a readable format
 */
function smarty_modifier_datetime_format($string, $format = '%d/%m/%Y %H:%M:%S', $default_date = '') {
    if ($string != '') {
        $timestamp = strtotime($string);
    } elseif ($default_date != '') {
        $timestamp = strtotime($default_date);
    } else {
        return;
    }
    if (DIRECTORY_SEPARATOR == '\\') {
        $_win_from = array('%D',       '%h', '%n', '%r',          '%R',    '%t', '%T');
        $_win_to   = array('%m/%d/%y', '%b', "\n", '%I:%M:%S %p', '%H:%M', "\t", '%H:%M:%S');
        if (strpos($format, '%e') !== false) {
            $_win_from[] = '%e';
            $_win_to[]   = sprintf('%\' 2d', date('j', $timestamp));
        }
        if (strpos($format, '%l') !== false) {
            $_win_from[] = '%l';
            $_win_to[]   = sprintf('%\' 2d', date('h', $timestamp));
        }
        $format = str_replace($_win_from, $_win_to, $format);
    }
    return strftime($format, $timestamp);
}

/**
 * Translate a string
 */
function smarty_block_translation($params, $content, $smarty, &$repeat) {
	return $content;
	if ($content !== null) {
		return Translation::translate($content, $smarty->tpl_vars['env']->value['translation']);
	}
}

/**
 * Show a snippet
 */
function smarty_function_snippet($params, &$smarty) {
	/**
	 * Supported parameters:
	 *   - source (the source file in WEB_PATH . /snippet/
	 *   - * (will be converted to <snippet_name>_*
	 */
	$template = new \Skeleton\Template\Template();

	if (empty($params['source'])) {
		throw new Exception('source required for snippet');
	} else {
		$source = $params['source'];
		$var_identifier = substr($source, 0, -4);
	}

	foreach ($smarty->getTemplateVars() as $key => $value) {
		$template->assign($key, $value);
	}

	foreach ($params as $key => $value) {
		$template->assign($var_identifier . '_' . $key, $value);
	}


	foreach ($params as $key => $value) {
		$template->assign($key, $value);
	}
	$template->set_template_directory(\Skeleton\Core\Application::Get()->template_path);
	$content = $template->render('../snippet/' . $source);

	return $content;
}

/**
 * Convert markdown
 */
function smarty_modifier_markdown($content) {
	$parser = new MarkdownExtra();
    return $parser->transform($content);
}
