import shiki from 'shiki';
import { renderToHtml } from './renderer.js';

const customLanguages = [
    {
        id: 'antlers',
        scopeName: 'text.html.statamic',
        path: '../../../languages/antlers.tmLanguage.json',
        embeddedLangs: ['html'],
    },
    {
        id: 'blade',
        scopeName: 'text.html.php.blade',
        path: '../../../languages/blade.tmLanguage.json',
        embeddedLangs: ['html', 'php'],
    },
];

let allLanguages = shiki.BUNDLED_LANGUAGES;
allLanguages.push(...customLanguages);

const languagesToLoad = allLanguages;
(function loadEmbeddedLangsRecursively() {
    languagesToLoad.forEach(function (language) {
        const embeddedLangs = language.embeddedLangs || [];
        embeddedLangs.forEach(function (languageKey) {
            if (languagesToLoad.find(lang => lang.id === languageKey || (lang.aliases && lang.aliases.includes(languageKey)))) {
                return;
            }

            languagesToLoad.push(allLanguages.find(lang => lang.id === languageKey || (lang.aliases && lang.aliases.includes(languageKey))));
            loadEmbeddedLangsRecursively();
        });
    });
})();

const highlighter = await shiki.getHighlighter({
    langs: languagesToLoad,
});

export const handle = async function (event) {
    if (event.command === 'themes') {
        return JSON.stringify(shiki.BUNDLED_THEMES);
    }

    if (event.command === 'languages') {
        return JSON.stringify(allLanguages);
    }

    let theme = event.theme || 'nord';

    if (! highlighter.getLoadedThemes().includes(theme)) {
        await highlighter.loadTheme(theme);
    }

    const language = event.language || 'php';
    const tokens = highlighter.codeToThemedTokens(event.code, language);
    const loadedTheme = highlighter.getTheme(theme);
    const options = event.options || {};

    return renderToHtml(tokens, {
        fg: loadedTheme.fg,
        bg: loadedTheme.bg,
        highlightLines: options.highlightLines,
        addLines: options.addLines,
        deleteLines: options.deleteLines,
        focusLines: options.focusLines,
    });
}
