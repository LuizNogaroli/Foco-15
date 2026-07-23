const fs = require('fs');

function processFile(filePath) {
    let content = fs.readFileSync(filePath, 'utf8');

    // 1. Text inputs
    content = content.replace(/<input([^>]*?)type="text"([^>]*?)name="([^"]+)"([^>]*?)>/g, (match, p1, p2, name, p3) => {
        if (match.includes('value="{{')) return match; // already bound
        if (match.includes('value=')) {
            // remove existing value if empty or replace it
            match = match.replace(/value="[^"]*"/, `value="{{ $dados['${name}'] ?? '' }}"`);
            return match;
        }
        return `<input${p1}type="text"${p2}name="${name}"${p3} value="{{ $dados['${name}'] ?? '' }}">`;
    });

    // Hidden inputs
    content = content.replace(/<input([^>]*?)type="hidden"([^>]*?)name="([^"]+)"([^>]*?)>/g, (match, p1, p2, name, p3) => {
        if (name === 'next_aba' || name === '_token') return match;
        if (match.includes('value="{{')) return match;
        if (match.includes('value=')) {
            match = match.replace(/value="[^"]*"/, `value="{{ $dados['${name}'] ?? '' }}"`);
            return match;
        }
        return `<input${p1}type="hidden"${p2}name="${name}"${p3} value="{{ $dados['${name}'] ?? '' }}">`;
    });

    // 2. Textareas
    content = content.replace(/<textarea([^>]*?)name="([^"]+)"([^>]*?)>(.*?)<\/textarea>/gs, (match, p1, name, p2, inner) => {
        if (inner.includes('{{ $dados')) return match;
        return `<textarea${p1}name="${name}"${p2}>{{ $dados['${name}'] ?? '' }}</textarea>`;
    });

    // 3. Selects
    content = content.replace(/<select([^>]*?)name="([^"]+)"([^>]*?)>/g, (match, p1, name, p2) => {
        if (match.includes('data-selected="{{')) return match;
        if (match.includes('data-selected=')) {
            match = match.replace(/data-selected="[^"]*"/, `data-selected="{{ $dados['${name}'] ?? '' }}"`);
            return match;
        }
        return `<select${p1}name="${name}"${p2} data-selected="{{ $dados['${name}'] ?? '' }}">`;
    });

    // Fix select options based on data-selected in JS, or we can add blade conditionals to options if we want, 
    // but the JS (sync.js/formulario.js) should automatically select options if data-selected is present.
    // However, for safety, let's also inject blade into options of selects? That's too complex via regex.
    // Assuming custom-select.js or formulario.js handles `data-selected`. I'll just leave `data-selected`.

    // 4. Radios
    content = content.replace(/<input([^>]*?)type="radio"([^>]*?)name="([^"]+)"([^>]*?)value="([^"]+)"([^>]*?)>/g, (match, p1, p2, name, p3, val, p4) => {
        if (match.includes('{{ isset')) return match;
        // remove existing checked
        let cleanMatch = match.replace(/\schecked(\s|>)/, '$1');
        cleanMatch = cleanMatch.replace('>', ` {{ isset($dados['${name}']) && $dados['${name}'] == '${val}' ? 'checked' : '' }}>`);
        return cleanMatch;
    });

    // 5. Checkboxes (assuming arrays if they end in [])
    content = content.replace(/<input([^>]*?)type="checkbox"([^>]*?)name="([^"]+)"([^>]*?)value="([^"]+)"([^>]*?)>/g, (match, p1, p2, name, p3, val, p4) => {
        if (match.includes('{{ isset')) return match;
        let cleanName = name.replace('[]', '');
        let cleanMatch = match.replace(/\schecked(\s|>)/, '$1');
        if (name.endsWith('[]')) {
            cleanMatch = cleanMatch.replace('>', ` {{ isset($dados['${cleanName}']) && in_array('${val}', (array)$dados['${cleanName}']) ? 'checked' : '' }}>`);
        } else {
            cleanMatch = cleanMatch.replace('>', ` {{ isset($dados['${name}']) && $dados['${name}'] == '${val}' ? 'checked' : '' }}>`);
        }
        return cleanMatch;
    });

    fs.writeFileSync(filePath, content);
    console.log('Processed', filePath);
}

processFile('resources/views/processos/abas/aba3.blade.php');
processFile('resources/views/processos/abas/aba7.blade.php');
