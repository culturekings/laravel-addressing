<?php

use Galahad\LaravelAddressing\Entity\Country;

/**
 * Class CountryTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryTest extends PHPUnit_Framework_TestCase
{
    public function testFindByCodeAndName()
    {
        $country = new Country;

        $us = $country->getByName('United States');
        $br = $country->getByName('Brazil');
        $brazil = $country->getByCode('BR');

        $this->assertEquals($us->getCode(), 'US');
        $this->assertEquals($br->getCode(), 'BR');
        $this->assertEquals($brazil->getName(), 'Brazil');
    }

    public function testGetAdministrativeAreasFirstRow()
    {
        $country = new Country;

        $brazil = $country->getByCode('BR');
        $acState = $brazil->getAdministrativeAreas()->getByKey(0);

        $us = $country->getByCode('US');
        $alabamaState = $us->getAdministrativeAreas()->getByKey(0);
        $coloradoState = $us->getAdministrativeAreas()->getByKey(9);

        $this->assertEquals($acState->getName(), 'Acre');
        $this->assertEquals($alabamaState->getName(), 'Alabama');
        $this->assertEquals($coloradoState->getName(), 'Colorado');
    }

    public function testShortcuts()
    {
        $country = new Country;
        $brazil = $country->code('BR');
        $us = $country->code('US');

        $this->assertEquals($brazil->getName(), 'Brazil');
        $this->assertEquals($us->getName(), 'United States');
    }

    public function testGetMagicMethod()
    {
        $country = new Country;

        $this->assertEquals($country->code('US')->name, 'United States');
        $this->assertEquals($country->code('BR')->name, 'Brazil');
    }

    public function testLocale()
    {
        $country = new Country('pt');

        $this->assertEquals($country->code('US')->name, 'Estados Unidos');
        $this->assertEquals($country->code('BR')->name, 'Brasil');
    }

    public function testGetCountryByCodeOrName()
    {
        $maker = new Country();

        $country = $maker->getByCodeOrName('BR');
        $this->assertEquals($country->getName(), 'Brazil');
        $this->assertTrue($country instanceof Country);

        $country = $maker->getByCodeOrName('Brazil');
        $this->assertEquals($country->getCode(), 'BR');
        $this->assertTrue($country instanceof Country);
    }
}