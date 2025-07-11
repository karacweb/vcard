<?php

declare(strict_types=1);

namespace Karacweb\VCard;

use Carbon\Carbon;
use Sabre\VObject\Component\VCard as SabreVCard;

final class VCard
{
    private $card;

    private $familyNames;

    private $givenNames;

    private $additionalNames;

    private $honorificPrefixes;

    private $honorificSuffixes;

    public function __construct()
    {
        $this->card = new SabreVCard();
    }

    public function getVCard(): SabreVCard
    {
        return $this->card;
    }

    public function setCommonName($commonName)
    {
        $this->card->FN = $commonName;

        return $this;
    }

    public function setFamilyNames(string|array $familyNames)
    {
        $this->familyNames = $familyNames;

        return $this;
    }

    public function setGivenNames(string|array $givenNames)
    {
        $this->givenNames = $givenNames;

        return $this;
    }

    public function setAdditionalNames(string|array $additionalNames)
    {
        $this->additionalNames = $additionalNames;

        return $this;
    }

    public function setHonorificPrefixes(string|array $honorificPrefixes)
    {
        $this->honorificPrefixes = $honorificPrefixes;

        return $this;
    }

    public function setHonorificSuffixes(string|array $honorificSuffixes)
    {
        $this->honorificSuffixes = $honorificSuffixes;

        return $this;
    }

    public function addTel(string $number, bool $pref = false, array $types = [])
    {
        $properties = [];
        if ($pref) {
            $properties['PREF'] = 1;
        }
        $properties['TYPE'] = $types;
        $this->card->add('TEL', $number, $properties);

        return $this;
    }

    public function addEmail(string $email, bool $pref = false)
    {
        $properties = [];
        if ($pref) {
            $properties['PREF'] = 1;
        }
        $this->card->add('EMAIL', $email, $properties);

        return $this;
    }

    /**
     * @param  string|array  $org  The organisation for the contact. Used as an array, we can be as specific as we needed.
     * @return VCard
     */
    public function addOrg(string|array $org)
    {
        $this->card->add('ORG', collect($org)->join(';'));

        return $this;
    }

    public function addTitle(string $title)
    {
        $this->card->add('TITLE', $title);

        return $this;
    }

    public function addRole(string $role)
    {
        $this->card->add('ROLE', $role);

        return $this;
    }

    public function setBirthday(Carbon $birthday)
    {
        $this->card->BDAY = $birthday->format('Y-m-d');

        return $this;
    }

    /**
     * @param  string  $type  Can be 'WORK', 'HOME', 'OTHER'
     * @return $this
     */
    public function addAdr(
        string $postOfficeBox = '',
        string $extendedAddress = '',
        string $street = '',
        string $locality = '',
        string $region = '',
        string $postalCode = '',
        string $countryName = '',
        bool $pref = false,
        string $type = '',
    ) {
        $properties = [];
        if ($type) {
            $properties[$type] = 1;
        }

        if ($pref) {
            $properties['PREF'] = 1;
        }

        $this->card->add('ADR', [
            $postOfficeBox,
            $extendedAddress,
            $street,
            $locality,
            $region,
            $postalCode,
            $countryName,
        ],
            $properties
        );

        return $this;
    }

    public function addUrl(string $url)
    {
        $this->card->add('URL', $url);

        return $this;
    }

    public function serialize(): string
    {
        $this->serializeNames();

        $validation = $this->card->validate();

        if (count($validation)) {
            throw new VCardException($validation[0]['message']);
        }

        return $this->card->serialize();
    }

    private function serializeNames()
    {
        $this->card->N = [
            collect($this->familyNames)->join(','),
            collect($this->givenNames)->join(','),
            collect($this->additionalNames)->join(','),
            collect($this->honorificPrefixes)->join(','),
            collect($this->honorificSuffixes)->join(','),
        ];
    }
}
