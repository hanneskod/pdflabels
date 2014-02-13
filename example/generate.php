<?php

// Usage: php generate.php > addresses.pdf

namespace ledgr\pdflabels;

// Path to composer autoloader
include "../vendor/autoload.php";

// Load label content from some source
$addresses = json_decode(file_get_contents('addresses.json'));

// Create the labels object
$labels = LabelsFactory::createStd();

// Att label conent
foreach ($addresses as $address) {
    $labels->addCell(implode("\n", $address));
}

// Generate pdf
echo $labels->getPdf();
