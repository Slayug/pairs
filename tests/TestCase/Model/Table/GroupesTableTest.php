<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupesTable Test Case
 */
class GroupesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Groupes' => 'app.groupes',
        'Utilisateurs' => 'app.utilisateurs',
        'GroupesUtilisateurs' => 'app.groupes_utilisateurs',
        'Questionnaires' => 'app.questionnaires',
        'QuestionnairesGroupes' => 'app.questionnaires_groupes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Groupes') ? [] : ['className' => 'App\Model\Table\GroupesTable'];
        $this->Groupes = TableRegistry::get('Groupes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groupes);

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
}
