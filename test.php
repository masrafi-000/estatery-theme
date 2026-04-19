<?php
$json = json_decode(file_get_contents("data/properties.json"), true);
$props = $json["root"]["property"] ?? [];
$c = 0;
foreach($props as $p) {
    if (empty(trim($p["desc"][0]["en"][0] ?? ""))) {
        echo "Missing EN description for ID " . ($p["id"][0] ?? "") . "\n";
        $c++;
    }
}
echo "Total missing: $c\n";
?>
