const fs = require('fs');
const files = ['en.json', 'es.json', 'fr.json', 'ru.json'];
const basePath = 'c:/xampp/htdocs/anna_real_estate/wp-content/themes/estatery/languages/';

files.forEach(file => {
    const content = fs.readFileSync(basePath + file, 'utf8');
    const lines = content.split('\n');
    const stack = [new Set()];
    const path = [];
    
    console.log(`Checking ${file}...`);
    
    lines.forEach((line, index) => {
        const keyMatch = line.match(/"([^"]+)":/);
        if (keyMatch) {
            const key = keyMatch[1];
            if (stack[stack.length - 1].has(key)) {
                console.log(`DUPLICATE FOUND: "${key}" at line ${index + 1}`);
            }
            stack[stack.length - 1].add(key);
        }
        
        // Simple brace counting (not perfect but works for this structure)
        if (line.includes('{')) {
            stack.push(new Set());
        }
        if (line.includes('}')) {
            stack.pop();
            if (stack.length === 0) stack.push(new Set()); // Guard
        }
    });
});
