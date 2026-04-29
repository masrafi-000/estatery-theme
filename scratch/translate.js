const fs = require('fs');
const https = require('https');

async function translateText(text, sourceLang = 'en', targetLang = 'pl') {
    if (!text || typeof text !== 'string') return text;
    // Don't translate strings that are just numbers or very short identifiers if they don't contain letters
    if (/^[\d\W]+$/.test(text)) return text;
    // Don't translate URLs
    if (text.startsWith('http') || text.startsWith('/')) return text;

    // Temporary replace placeholders like {{count}} to avoid translation messing them up
    // Actually, Google Translate often preserves {{word}} but let's be careful.
    
    const url = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=${sourceLang}&tl=${targetLang}&dt=t&q=${encodeURIComponent(text)}`;
    
    return new Promise((resolve) => {
        https.get(url, (res) => {
            let data = '';
            res.on('data', chunk => data += chunk);
            res.on('end', () => {
                try {
                    const json = JSON.parse(data);
                    if (json && json[0]) {
                        const translated = json[0].map(item => item[0]).join('');
                        resolve(translated);
                    } else {
                        resolve(text);
                    }
                } catch (e) {
                    console.error("Error parsing response for:", text);
                    resolve(text); // fallback
                }
            });
        }).on('error', err => {
            console.error("HTTP error for:", text);
            resolve(text); // fallback
        });
    });
}

const sleep = ms => new Promise(r => setTimeout(r, ms));

async function translateObject(obj) {
    if (typeof obj === 'string') {
        const translated = await translateText(obj);
        await sleep(150); // 150ms delay to avoid rate limit
        process.stdout.write('.'); // progress indicator
        return translated;
    } else if (Array.isArray(obj)) {
        for (let i = 0; i < obj.length; i++) {
            obj[i] = await translateObject(obj[i]);
        }
    } else if (typeof obj === 'object' && obj !== null) {
        for (const key in obj) {
            // Do not translate keys like "url", "icon", "id", "slug"
            if (['url', 'icon', 'id', 'slug', 'key', 'email', 'platform', 'image'].includes(key)) {
                continue; // keep original
            }
            obj[key] = await translateObject(obj[key]);
        }
    }
    return obj;
}

async function run() {
    console.log("Starting translation to Polish...");
    const filePath = 'c:/xampp/htdocs/anna_real_estate/wp-content/themes/estatery/languages/pl.json';
    
    let data;
    try {
        data = JSON.parse(fs.readFileSync(filePath, 'utf8'));
    } catch(e) {
        console.error("Failed to read JSON:", e);
        return;
    }
    
    const translatedData = await translateObject(data);
    console.log("\nWriting file...");
    fs.writeFileSync(filePath, JSON.stringify(translatedData, null, 2), 'utf8');
    console.log("Translation complete!");
}

run();
