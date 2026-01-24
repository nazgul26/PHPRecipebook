<?php
namespace App\View\Helper;

use Cake\View\Helper;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;

/**
 * MarkdownHelper - Converts markdown text to HTML with XSS protection
 */
class MarkdownHelper extends Helper
{
    /**
     * @var MarkdownConverter
     */
    protected $converter;

    /**
     * Initialize the markdown converter with security settings
     *
     * @param array $config Configuration options
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $environment = new Environment([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]);
        $environment->addExtension(new CommonMarkCoreExtension());

        $this->converter = new MarkdownConverter($environment);
    }

    /**
     * Render markdown text to HTML
     *
     * @param string|null $text The markdown text to render
     * @return string The rendered HTML
     */
    public function render(?string $text): string
    {
        if ($text === null || $text === '') {
            return '';
        }

        return $this->converter->convert($text)->getContent();
    }

    /**
     * Conditionally render text as markdown or plain text
     *
     * @param string|null $text The text to render
     * @param bool $useMarkdown Whether to render as markdown
     * @return string The rendered output
     */
    public function renderConditional(?string $text, bool $useMarkdown): string
    {
        if ($text === null || $text === '') {
            return '';
        }

        if ($useMarkdown) {
            return $this->render($text);
        }

        return '<pre>' . h($text) . '</pre>';
    }
}
