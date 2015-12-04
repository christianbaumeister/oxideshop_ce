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
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version   OXID eShop CE
 */

use OxidEsales\Eshop\Core\Edition\EditionSelector;

// TODO: class should be refactored to testable state.
class EditionSelectorTest extends OxidEsales\TestingLibrary\UnitTestCase
{
    public function testReturnsEdition()
    {
        $editionSelector = new EditionSelector();

        $this->assertSame($this->getConfig()->getEdition(), $editionSelector->getEdition());
    }

    public function testCheckActiveEdition()
    {
        if ($this->getTestConfig()->getShopEdition() !== 'CE') {
            $this->markTestSkipped('This test is for Community editions only.');
        }

        $editionSelector = new EditionSelector();

        $this->assertSame('CE', $editionSelector->getEdition());
        $this->assertTrue($editionSelector->isCommunity());
        $this->assertFalse($editionSelector->isEnterprise());
        $this->assertFalse($editionSelector->isProfessional());
    }

    public function providerReturnsForcedEdition()
    {
        return array(
            array(EditionSelector::ENTERPRISE, 'EE'),
            array(EditionSelector::PROFESSIONAL, 'PE'),
            array(EditionSelector::COMMUNITY, 'CE'),
        );
    }

    /**
     * @dataProvider providerReturnsForcedEdition
     */
    public function testReturnsForcedEdition($editionToForce, $expectedEdition)
    {
        $editionSelector = new EditionSelector($editionToForce);

        $this->assertSame($expectedEdition, $editionSelector->getEdition());
    }

    public function testIsEnterpriseReturnTrueIfForced()
    {
        $editionSelector = new EditionSelector(EditionSelector::ENTERPRISE);
        $this->assertTrue($editionSelector->isEnterprise());
        $this->assertFalse($editionSelector->isProfessional());
        $this->assertFalse($editionSelector->isCommunity());
    }

    public function testIsProfessionalReturnTrueIfForced()
    {
        $editionSelector = new EditionSelector(EditionSelector::PROFESSIONAL);
        $this->assertTrue($editionSelector->isProfessional());
        $this->assertFalse($editionSelector->isEnterprise());
        $this->assertFalse($editionSelector->isCommunity());
    }

    public function testIsCommunityReturnTrueIfForced()
    {
        $editionSelector = new EditionSelector(EditionSelector::COMMUNITY);
        $this->assertTrue($editionSelector->isCommunity());
        $this->assertFalse($editionSelector->isEnterprise());
        $this->assertFalse($editionSelector->isProfessional());
    }
}
