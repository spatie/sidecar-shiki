<?php

namespace Spatie\SidecarShiki\Commonmark;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\ExtensionInterface;

class HighlightCodeExtension implements ExtensionInterface
{
    public function __construct(
        protected string $theme
    ) {
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $codeBlockHighlighter = new SidecarShikiHighlighter($this->theme);

        $environment
            ->addRenderer(FencedCode::class, new FencedCodeRenderer($codeBlockHighlighter), 10)
            ->addRenderer(IndentedCode::class, new IndentedCodeRenderer($codeBlockHighlighter), 10);
    }
}
