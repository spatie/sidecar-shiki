import * as shiki from 'shiki';
import * as path from 'path';
import * as fs from 'fs';
import {renderToHtml} from "./renderer.js";
import { fileURLToPath } from 'url';

const customLanguages = {
    antlers: {
        scopeName: 'text.html.statamic',
        embeddedLangs: ['html'],
    },
    blade: {
        scopeName: 'text.html.php.blade',
        embeddedLangs: ['html', 'php'],
    },
};

const highlighter = await shiki.getHighlighter({});

for (const [lang, spec] of Object.entries(customLanguages)) {
    for (const embedded of spec.embeddedLangs) {
        await highlighter.loadLanguage(embedded);
    }

    await highlighter.loadLanguage({ ...spec, ...loadLanguage(lang), name: lang });
}

function loadLanguage(language) {
    const path = getLanguagePath(language);
    const content = fs.readFileSync(path);

    return JSON.parse(content);
}

function getLanguagePath(language) {
    const __filename = fileURLToPath(import.meta.url);
    const url = path.join(path.dirname(__filename), 'languages', `${language}.tmLanguage.json`);

    return path.normalize(url);
}

export const handle = async function (event) {
    let theme = event.theme || 'nord';

    if (! highlighter.getLoadedThemes().includes(theme)) {
        await highlighter.loadTheme(theme);
    }

    const language = event.language || 'php';

    if (!customLanguages[language]) await highlighter.loadLanguage(language);

    const { theme: theme$ } = highlighter.setTheme(theme);

    const result = highlighter.codeToTokens(event.code, {
        theme: theme$,
        lang: language,
    });

    const options = event.options || {};

    return renderToHtml(result.tokens, {
        fg: theme$.fg,
        bg: theme$.bg,
        highlightLines: options.highlightLines,
        addLines: options.addLines,
        deleteLines: options.deleteLines,
        focusLines: options.focusLines,
    });
}
