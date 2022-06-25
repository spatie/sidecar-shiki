<?php

namespace Spatie\SidecarShiki\Commonmark;

use League\CommonMark\Extension\CommonMark\Renderer\Block\IndentedCodeRenderer as BaseIndentedCodeRenderer;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class IndentedCodeRenderer implements NodeRendererInterface
{
    protected SidecarShikiHighlighter $highlighter;

    protected BaseIndentedCodeRenderer $baseRenderer;

    public function __construct(SidecarShikiHighlighter $codeBlockHighlighter)
    {
        $this->highlighter = $codeBlockHighlighter;

        $this->baseRenderer = new BaseIndentedCodeRenderer();
    }

    public function render(
        Node $node,
        ChildNodeRendererInterface $childRenderer
    ): string {
        $element = $this->baseRenderer->render($node, $childRenderer);

        $element->setContents(
            $this->highlighter->highlight($element->getContents())
        );

        return $element->getContents();
    }
}
