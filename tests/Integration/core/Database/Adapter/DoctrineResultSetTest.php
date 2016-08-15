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
use Doctrine\DBAL\Driver\PDOStatement;
use OxidEsales\Eshop\Core\Database\Adapter\DoctrineResultSet;
use OxidEsales\Eshop\Core\Database\Doctrine;

/**
 * Tests for our database object.
 */
class Integration_Core_Database_Adapter_DoctrineResultSetTest extends UnitTestCase
{

    /**
     * @var string The name of the class, including the complete namespace.
     */
    const CLASS_NAME_WITH_PATH = 'OxidEsales\Eshop\Core\Database\Adapter\DoctrineResultSet';

    /**
     * @var string The first OXID of the OXARTICLES
     */
    const FIRST_OXARTICLE_OXID = '09602cddb5af0aba745293d08ae6bcf6';

    /**
     * Test, that the result set of an empty select works as expected.
     *
     */
    public function testCreationWithRealEmptyResult()
    {
        $database = new Doctrine();

        $resultSet = $database->select('SELECT OXID FROM oxvouchers;');

        $this->assertEquals(self::CLASS_NAME_WITH_PATH, get_class($resultSet));
        $this->assertEquals(0, $resultSet->recordCount());

        return $resultSet;
    }

    /**
     * Test, that the result set of a non empty select works as expected.
     *
     * @return DoctrineResultSet The non empty result set.
     */
    public function testCreationWithRealNonEmptyResult()
    {
        $database = new Doctrine();

        $resultSet = $database->select('SELECT OXID FROM oxarticles;');

        $this->assertEquals(self::CLASS_NAME_WITH_PATH, get_class($resultSet));
        $this->assertGreaterThan(200, $resultSet->recordCount());

        return $resultSet;
    }

    /**
     * Test, that the method 'fetchRow' works for an empty result set.
     */
    public function testFetchRowWithEmptyResultSet()
    {
        $resultSet = $this->testCreationWithRealEmptyResult();

        $row = $resultSet->fetchRow();

        $this->assertFalse($row);
    }

    /**
     * Test, that the method 'fetchRow' works for a non empty result set.
     */
    public function testFetchRowWithNonEmptyResultSet()
    {
        $resultSet = $this->testCreationWithRealNonEmptyResult();

        $row = $resultSet->fetchRow();

        $this->assertInternalType('array', $row);
        $this->assertArrayHasKey('OXID', $row);
        $this->assertEquals(self::FIRST_OXARTICLE_OXID, $row['OXID']);
    }

    /**
     * Test, that the method 'getAll' works for an empty result set.
     */
    public function testGetAllWithEmptyResultSet()
    {
        $resultSet = $this->testCreationWithRealEmptyResult();

        $rows = $resultSet->getAll();

        $this->assertInternalType('array', $rows);
        $this->assertEmpty($rows);
    }

    /**
     * Test, that the method 'getAll' works for a non empty result set.
     */
    public function testGetAllWithNonEmptyResultSet()
    {
        $resultSet = $this->testCreationWithRealNonEmptyResult();

        $rows = $resultSet->getAll();

        $this->assertInternalType('array', $rows);
        $this->assertNotEmpty($rows);
        $this->assertGreaterThan(200, count($rows));
        $this->assertEquals(self::FIRST_OXARTICLE_OXID, $rows[0]['OXID']);
    }

    /**
     * Test, that the attribute and method 'EOF' is true, for an empty result set.
     */
    public function testEofWithEmptyResultSet()
    {
        $resultSet = $this->testCreationWithRealEmptyResult();

        $this->assertTrue($resultSet->EOF);
        $this->assertTrue($resultSet->EOF());

    }

    /**
     * Test, that the 'EOF' is true, for a non empty result set.
     */
    public function testEofWithNonEmptyResultSet()
    {
        $resultSet = $this->testCreationWithRealNonEmptyResult();

        $this->assertFalse($resultSet->EOF);
        $this->assertFalse($resultSet->EOF());
    }

}
