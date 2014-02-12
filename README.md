pdflabels
=========
[![Build Status](https://travis-ci.org/ledgr/pdflabels.png?branch=master)](https://travis-ci.org/ledgr/pdflabels)

Write a grid of labels to a pdf


Installation using composer
---------------------------
Simply add `ledgr/pdflabels` to your list of required libraries.


Usage
-----
    namespace ledgr\pdflabels;

    include "vendor/autoload.php";

    $addresses = json_decode(file_get_contents('addresses.json'));

    $labels = LabelsFactory::createStd();

    foreach ($addresses as $address) {
        $labels->addCell(implode("\n", $address));
    }

    echo $labels->getPdf();
