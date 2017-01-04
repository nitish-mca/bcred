<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OffersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OffersTable Test Case
 */
class OffersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OffersTable
     */
    public $Offers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.offers',
        'app.subcategories',
        'app.categories',
        'app.categories_subcategories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Offers') ? [] : ['className' => 'App\Model\Table\OffersTable'];
        $this->Offers = TableRegistry::get('Offers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Offers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
