# PDF-labels [![Latest Stable Version](https://poser.pugx.org/ledgr/pdflabels/v/stable.png)](https://packagist.org/packages/ledgr/pdflabels) [![Build Status](https://travis-ci.org/ledgr/pdflabels.png?branch=master)](https://travis-ci.org/ledgr/pdflabels) [![Code Coverage](https://scrutinizer-ci.com/g/ledgr/pdflabels/badges/coverage.png?s=ea2b5dc71bbb041b5f7a050acf533932e87142a7)](https://scrutinizer-ci.com/g/ledgr/pdflabels/) [![Dependency Status](https://gemnasium.com/ledgr/pdflabels.png)](https://gemnasium.com/ledgr/pdflabels)


Render pdfs using a grid of labels

**License**: [GPL](/LICENSE)

![Example output](/example/addresses.png)


Installation using [composer](http://getcomposer.org/)
------------------------------------------------------
Simply add `ledgr/pdflabels` to your list of required libraries.


Usage
-----
    namespace ledgr\pdflabels;

    $labels = LabelsFactory::createStd();

    foreach ($content as $cell) {
        $labels->addCell($cell);
    }

    echo $labels->getPdf();


Run tests  using [phpunit](http://phpunit.de/)
----------------------------------------------
To run the tests you must first install dependencies using composer.

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    $ phpunit
