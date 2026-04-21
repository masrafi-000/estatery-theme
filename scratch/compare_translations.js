
const fs = require('fs');
const path = require('path');

function getKeys(obj, prefix = '') {
    let keys = [];
    for (let key in obj) {
        if (typeof obj[key] === 'object' && obj[key] !== null && !Array.isArray(obj[key])) {
            keys = keys.concat(getKeys(obj[key], prefix + key + '.'));
        } else {
            keys.push(prefix + key);
        }
    }
    return keys;
}

const languages = ['es', 'fr', 'ru'];
const enPath = path.join(__dirname, '..', 'languages', 'en.json');
const en = JSON.parse(fs.readFileSync(enPath, 'utf8'));
const enKeys = getKeys(en);

languages.forEach(lang => {
    const langPath = path.join(__dirname, '..', 'languages', `${lang}.json`);
    const langObj = JSON.parse(fs.readFileSync(langPath, 'utf8'));
    const langKeys = getKeys(langObj);

    const missing = enKeys.filter(k => !langKeys.includes(k));
    const extra = langKeys.filter(k => !enKeys.includes(k));

    console.log(`--- ${lang.toUpperCase()} ---`);
    console.log(`Missing keys in ${lang}:`, missing.length);
    missing.forEach(k => console.log(`  - ${k}`));
    console.log(`Extra keys in ${lang}:`, extra.length);
    extra.forEach(k => console.log(`  + ${k}`));
    console.log('\n');
});
