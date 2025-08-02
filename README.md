<h1>Generate vcards fluently</h1>

[![Latest Stable Version](http://poser.pugx.org/karacweb/vcard/v)](https://packagist.org/packages/karacweb/vcard)
[![Total Downloads](http://poser.pugx.org/karacweb/vcard/downloads)](https://packagist.org/packages/karacweb/vcard)
[![Latest Unstable Version](http://poser.pugx.org/karacweb/vcard/v/unstable)](https://packagist.org/packages/karacweb/vcard)
[![License](http://poser.pugx.org/karacweb/vcard/license)](https://packagist.org/packages/karacweb/vcard)
[![PHP Version Require](http://poser.pugx.org/karacweb/vcard/require/php)](https://packagist.org/packages/karacweb/vcard)

This PHP packages allows you to create VCards files `.vcf`. This package uses
the [Sabre VObject library](https://sabre.io/vobject/vcard/).

## Installation

You can install the package via composer:

```
composer require karacweb/vcard
```

## Usage

```php
use Karacweb\VCard\VCard;

$vcard = new VCard();

// The common name is mandatory
$vcard->setCommonName('John Smith');

$vcard->setFamilyNames('Smith');
$vcard->setFamilyNames(['Ferreira', 'Dos Santos', 'Silva']); // Accepts also an array

$vcard->setGivenNames('Nelson');
$vcard->setGivenNames(['Nelson', 'Francis']); // Accepts also an array

$vcard->setAdditionalNames('Francesco');
$vcard->setAdditionalNames(['Francesco', 'Luis']); // Accepts also an array

$vcard->setHonorificPrefixes('Mrs');
$vcard->setHonorificPrefixes(['Mr', 'President']); // Accepts also an array

$vcard->setHonorificSuffixes('Ph.D.');
$vcard->setHonorificSuffixes(['Ph.D.', 'M.D.']); // Accepts also an array

$vcard->setBirthday('1992-12-24'); // Y-m-d

$vcard->addOrg('ACME Inc.');

$vcard->addTitle('Software Engineer');

$vcard->addRole('Project Leader');

$vcard->addTel('+1-418-262-6501', true, ['CELL']);
$vcard->addTel('+1-418-656-9254', true, ['HOME']);

$vcard->addEmail('john.smith@acme.org');

$vcard->addUrl('https://karac.ch');

$vcard->addAdr('PO BOX 123', 'Extended address', '123, Acme Str', 'Acme City', 'Acme Region', 'ZIP 12345', 'Switzerland');
// With named arguments
$vcard->addAdr(street: '123, Acme Str', locality: 'Acme City', region: 'Acme Region', postalCode: 'ZIP 12345');

// Build the VCard
$vcard->serialize();

// Download the VCard in pure PHP
header('Content-Type: text/x-vcard; charset=utf-8');
header('Content-Disposition: attachment; filename=my-vcard.vcf');
echo $vcard->serialize();
return;

// Alternative with Laravel
return response()->make($vcard->serialize())
    ->header('Content-Type', 'text/x-vcard; charset=utf-8')
    ->header('Content-Disposition', 'attachment; filename=my-vcard.vcf');

```

In case you need to access the underlying Sabre VCard Object, use the following method:

```php
use Karacweb\VCard\VCard;

$vcard = new VCard();

[...]

$sabreVCard = $vcard->getVCard();
```