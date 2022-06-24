<?php

namespace Spatie\SidecarShiki;

use Exception;
use Spatie\SidecarShiki\Functions\HighlightFunction;

class SidecarShiki
{
    public static function highlight(
        string $code,
        ?string $language = null,
        ?string $theme = null,
        ?array $highlightLines = [],
        ?array $addLines = [],
        ?array $deleteLines = [],
        ?array $focusLines = []
    ): string {
        $language = strtolower($language ?? 'php');
        $theme = $theme ?? 'nord';

        $highlightedCode = HighlightFunction::execute([
            'command' => 'highlight',
            'language' => $language,
            'code' => $code,
            'theme' => $theme,
            'options' => [
                'addLines' => $addLines,
                'deleteLines' => $deleteLines,
                'highlightLines' => $highlightLines,
                'focusLines' => $focusLines,
            ],
        ])->body();

        if (! is_string($highlightedCode)) {
            throw new Exception($highlightedCode['errorMessage'] ?? json_encode($highlightedCode));
        }

        return $highlightedCode;
    }
}
