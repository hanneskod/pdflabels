# PDF-labels [![Build Status](https://travis-ci.org/ledgr/pdflabels.png?branch=master)](https://travis-ci.org/ledgr/pdflabels) [![Code Coverage](https://scrutinizer-ci.com/g/ledgr/pdflabels/badges/coverage.png?s=ea2b5dc71bbb041b5f7a050acf533932e87142a7)](https://scrutinizer-ci.com/g/ledgr/pdflabels/)

Render pdfs using a grid of labels

__License__: [GPL](/LICENSE)

![Example output](/example/addresses.png)

## Installation using [composer](http://getcomposer.org/)

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
