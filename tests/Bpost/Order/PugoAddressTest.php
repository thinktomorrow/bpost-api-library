<?php
namespace Bpost;

use Bpost\BpostApiClient\Bpost\Order\PugoAddress;
use Bpost\BpostApiClient\Exception\BpostLogicException\BpostInvalidLengthException;

class PugoAddressTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Create a generic DOM Document
     *
     * @return \DOMDocument
     */
    private static function createDomDocument()
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->preserveWhiteSpace = false;
        $document->formatOutput = true;

        return $document;
    }

    /**
     * Tests PugoAddress->toXML
     */
    public function testToXML()
    {
        $data = array(
            'streetName' => 'Afrikalaan',
            'number' => '2890',
            'box' => '3',
            'postalCode' => '9000',
            'locality' => 'Gent',
            'countryCode' => 'BE',
        );

        $expectedDocument = self::createDomDocument();
        $address = $expectedDocument->createElement('pugoAddress');
        foreach ($data as $key => $value) {
            $address->appendChild(
                $expectedDocument->createElement($key, $value)
            );
        }
        $expectedDocument->appendChild($address);

        $actualDocument = self::createDomDocument();
        $address = new PugoAddress(
            $data['streetName'],
            $data['number'],
            $data['box'],
            $data['postalCode'],
            $data['locality'],
            $data['countryCode']
        );
        $actualDocument->appendChild(
            $address->toXML($actualDocument, null)
        );

        $this->assertEquals($expectedDocument, $actualDocument);
    }

    /**
     * Test validation in the setters
     */
    public function testFaultyProperties()
    {
        $address = new PugoAddress();

        try {
            $address->setBox(str_repeat('a', 9));
            $this->fail('BpostInvalidLengthException not launched');
        } catch (BpostInvalidLengthException $e) {
            // Nothing, the exception is good
        } catch (\Exception $e) {
            $this->fail('BpostInvalidLengthException not caught');
        }

        try {
            $address->setCountryCode(str_repeat('a', 3));
            $this->fail('BpostInvalidLengthException not launched');
        } catch (BpostInvalidLengthException $e) {
            // Nothing, the exception is good
        } catch (\Exception $e) {
            $this->fail('BpostInvalidLengthException not caught');
        }

        try {
            $address->setLocality(str_repeat('a', 41));
            $this->fail('BpostInvalidLengthException not launched');
        } catch (BpostInvalidLengthException $e) {
            // Nothing, the exception is good
        } catch (\Exception $e) {
            $this->fail('BpostInvalidLengthException not caught');
        }

        try {
            $address->setNumber(str_repeat('a', 9));
            $this->fail('BpostInvalidLengthException not launched');
        } catch (BpostInvalidLengthException $e) {
            // Nothing, the exception is good
        } catch (\Exception $e) {
            $this->fail('BpostInvalidLengthException not caught');
        }

        try {
            $address->setPostalCode(str_repeat('a', 41));
            $this->fail('BpostInvalidLengthException not launched');
        } catch (BpostInvalidLengthException $e) {
            // Nothing, the exception is good
        } catch (\Exception $e) {
            $this->fail('BpostInvalidLengthException not caught');
        }

        try {
            $address->setStreetName(str_repeat('a', 41));
            $this->fail('BpostInvalidLengthException not launched');
        } catch (BpostInvalidLengthException $e) {
            // Nothing, the exception is good
        } catch (\Exception $e) {
            $this->fail('BpostInvalidLengthException not caught');
        }

        // Exceptions were caught,
        $this->assertTrue(true);
    }
}
