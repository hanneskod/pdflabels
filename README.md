PDF Labels
==========

Render pdfs using a grid of labels

Usage
-----
```php
$labels = \pdflabels\LabelsFactory::createStd();

// Grab content
$content = array(
    array(
        "FOO BAR",
        "BARSTREET 87",
        "111 11 TOWN"
    ),
    array(
        "BAR FOO",
        "FOOSTREET 7",
        "222 22 TOWN"
    ),
    array(
        "FOOBAR",
        "FOOBARSTREET 31",
        "111 11 TOWN"
    )
);

// Add some cells
foreach ($content as $cell) {
    $labels->addCell(implode("\n", $cell));
}

// Generate pdf
echo $labels->getPdf();
```

Testing
-------
To run the tests you must first install the dependencies using composer.

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    $ phpunit

@author Hannes Forsgård (hannes.forsgard@fripost.org)
