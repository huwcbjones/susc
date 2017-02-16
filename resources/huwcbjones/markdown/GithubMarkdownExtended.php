<?php
/**
 * Author: Huw
 * Since: 11/02/2017
 */

namespace huwcbjones\markdown;

use cebe\markdown\GithubMarkdown;

require_once __DIR__ . DS . 'block' . DS . 'TableTrait.php';

class GithubMarkdownExtended extends GithubMarkdown
{
    use block\TableTrait;
    public $html5 = true;
    public $enableNewlines = true;


    protected function renderImage($block)
    {
        if (isset($block['refkey'])) {
            if (($ref = $this->lookupReference($block['refkey'])) !== false) {
                $block = array_merge($block, $ref);
            } else {
                return $block['orig'];
            }
        }
        return '<img class="img-responsive" src="' . htmlspecialchars($block['url'], ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"'
            . ' alt="' . htmlspecialchars($block['text'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"'
            . (empty($block['title']) ? '' : ' title="' . htmlspecialchars($block['title'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"')
            . ($this->html5 ? '>' : ' />');
    }
}