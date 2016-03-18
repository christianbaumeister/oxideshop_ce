<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link          http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version       OXID eShop CE
 */

use OxidEsales\TestingLibrary\UnitTestCase;
use OxidEsales\Eshop\Core\Database\Doctrine;

/**
 * Unit tests for our database abstraction layer object.
 */
class DoctrineTest extends UnitTestCase
{

    /**
     * @var Doctrine The doctrine database we want to test in this class.
     */
    protected $database = null;

    public function setUp()
    {
        parent::setUp();

        $this->database = new Doctrine();
    }

    /**
     * Test, that the method 'quote' works with null.
     */
    public function testQuoteWorksWithNull()
    {
        $quoted = $this->database->quote(null);

        $this->assertEquals("''", $quoted);
    }

    /**
     * Test, that the method 'quote' works with an empty string.
     */
    public function testQuoteWorksWithEmptyString()
    {
        $quoted = $this->database->quote('');

        $this->assertEquals("''", $quoted);
    }

    /**
     * Test, that the method 'quote' works with a non empty value.
     */
    public function testQuoteWorksWithNonEmptyValue()
    {
        $quoted = $this->database->quote('NonEmptyValue');

        $this->assertEquals("'NonEmptyValue'", $quoted);
    }

    /**
     * Test, that the method 'quote' works with an already quoted value.
     */
    public function testQuoteWorksWithAlreadyQuotedValue()
    {
        $quoted = $this->database->quote("NonEmptyValue");
        $quoted = $this->database->quote($quoted);

        $this->assertEquals("'\'NonEmptyValue\''", $quoted);
    }

    /**
     * Test, that the method 'qstr' delegates direct to the method 'quote'.
     */
    public function testQstrDelegation()
    {
        $value = 'quoteThis';

        $databaseMock = $this->getMock('OxidEsales\Eshop\Core\Database\Doctrine', array('quote'));
        $databaseMock->expects($this->once())->method('quote')->with($value);

        $databaseMock->qstr($value);
    }

}
