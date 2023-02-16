<?php

use Spatie\SidecarShiki\SidecarShiki;

use function Spatie\Snapshots\assertMatchesSnapshot;

it('can highlight php', function () {
    $code = '<?php echo "Hello World"; ?>';

    $highlightedCode = SidecarShiki::highlight($code);

    assertMatchesSnapshot($highlightedCode);
});

it('can highlight blade', function () {
    $code = '@if(true) {{ "Hello world" }} @endif';

    $highlightedCode = SidecarShiki::highlight($code, 'blade');

    assertMatchesSnapshot($highlightedCode);
});

it('can highlight complex blade with html inside', function () {
    $code = <<<blade
    @if(\$foo)
        <p>{{ "Hello world" }}</p>
    @endif
    blade;

    $highlightedCode = SidecarShiki::highlight($code, 'blade', 'github-light');

    assertMatchesSnapshot($highlightedCode);
});

it('can highlight antlers', function () {
    $code = '{{ if }} Hi there {{ /if }}';

    $highlightedCode = SidecarShiki::highlight($code, 'antlers');

    assertMatchesSnapshot($highlightedCode);
});

it('can render for a specific language', function () {
    $code = 'console.log("Hello world")';

    $highlightedCode = SidecarShiki::highlight($code, 'js');

    assertMatchesSnapshot($highlightedCode);
});

it('can mark lines as highlighted', function () {
    $code = '<?php echo "Hello World"; ?>';

    $highlightedCode = SidecarShiki::highlight($code, null, null, [1]);

    assertMatchesSnapshot($highlightedCode);
});

it('can mark multiple lines as highlighted', function () {
    $code = "
        <?php\n
        echo 'Hello World';\n
        return null;
    ";

    $highlightedCode = SidecarShiki::highlight($code, null, null, ['1', '2-4']);

    assertMatchesSnapshot($highlightedCode);
});

it('can mark lines as added', function () {
    $code = '<?php echo "Hello World"; ?>';

    $highlightedCode = SidecarShiki::highlight($code, null, null, null, [1]);

    assertMatchesSnapshot($highlightedCode);
});

it('can mark lines as deleted', function () {
    $code = '<?php echo "Hello World"; ?>';

    $highlightedCode = SidecarShiki::highlight($code, 'php', null, null, null, [1]);

    assertMatchesSnapshot($highlightedCode);
});

it('can mark lines as focus', function () {
    $code = '<?php echo "Hello World"; ?>';

    $highlightedCode = SidecarShiki::highlight($code, 'php', null, null, null, null, [1]);

    assertMatchesSnapshot($highlightedCode);
});

it('can accept different themes', function () {
    $code = '<?php echo "Hello World"; ?>';

    $highlightedCode = SidecarShiki::highlight($code, null, 'github-light');

    assertMatchesSnapshot($highlightedCode);
});

it('throws on invalid theme', function () {
    $code = '<?php echo "Hello World"; ?>';

    SidecarShiki::highlight($code, 'php', 'invalid-theme');
})->throws(Exception::class);

it('throws on invalid language', function () {
    $code = '<?php echo "Hello World"; ?>';

    SidecarShiki::highlight($code, 'invalid-language');
})->throws(Exception::class);
