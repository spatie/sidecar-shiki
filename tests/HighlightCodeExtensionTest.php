<?php

namespace Spatie\SidecarShiki\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Spatie\SidecarShiki\Commonmark\HighlightCodeExtension;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('can_highlight_a_piece_of_fenced_code', function ()
{
    $markdown = <<<MD
    Here is a piece of fenced PHP code
    ```php
    <?php echo "Hello World"; ?>
    ```
    MD;

    $highlightedCode = convertToHtml($markdown);

    assertMatchesSnapshot($highlightedCode);
});

it('can_highlight_a_piece_of_indented_code', function ()
{
    $markdown = <<<MD
    Here is a piece of indented PHP code

        <?php echo "Hello World"; ?>

    MD;

    $highlightedCode = convertToHtml($markdown);

    assertMatchesSnapshot($highlightedCode);
});

it('can_mark_lines_as_highlighted_added_deleted_and_focus', function ()
{
    $markdown = <<<MD
    Here is a piece of fenced PHP code
    ```php{4,5}{6,7}
    <?php
    + echo "This is an added line";
    - echo "This is a deleted line";
    echo "We will highlight line 4";
    echo "We will highlight line 5";
    echo "We will focus line 6";
    echo "We will focus line 7";
    ```
    MD;

    $highlightedCode = convertToHtml($markdown);

    assertMatchesSnapshot($highlightedCode);
});

function convertToHtml(string $markdown): string
{
    $environment = (new Environment())
        ->addExtension(new CommonMarkCoreExtension())
        ->addExtension(new HighlightCodeExtension('nord'));

    return (new MarkdownConverter(environment: $environment))->convertToHtml($markdown);
}
