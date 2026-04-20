<?php
$files = ['languages/en.json', 'languages/es.json', 'languages/fr.json', 'languages/ru.json'];
foreach ($files as $f) {
    if (!file_exists($f)) {
        echo "$f: MISSING\n";
        continue;
    }
    $d = json_decode(file_get_contents($f), true);
    $types = $d['pages']['properties']['categories']['types'] ?? [];
    echo "$f:\n";
    foreach ($types as $t) {
        echo "  - " . ($t['name'] ?? 'N/A') . " (slug: " . ($t['slug'] ?? 'MISSING') . ")\n";
    }
}
