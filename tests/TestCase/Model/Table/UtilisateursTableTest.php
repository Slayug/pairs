<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UtilisateursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UtilisateursTable Test Case
 */
class UtilisateursTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Utilisateurs' => 'app.utilisateurs',
        'Roles' => 'app.roles',
        'Groupes' => 'app.groupes',
        'GroupesUtilisateurs' => 'app.groupes_utilisateurs',
        'Questionnaires' => 'app.questionnaires',
        'ReponsesQuestionnaireUtilisateurs' => 'app.reponses_questionnaire_utilisateurs',
        'ReponsesQuestionnaireUtilisateursPartielles' => 'app.reponses_questionnaire_utilisateurs_partielles',
        'QuestionnairesGroupes' => 'app.questionnaires_groupes',
        'Questions' => 'app.questions',
        'QuestionnairesQuestions' => 'app.questionnaires_questions',
        'Reponses' => 'app.reponses',
        'ReponsesQuestions' => 'app.reponses_questions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Utilisateurs') ? [] : ['className' => 'App\Model\Table\UtilisateursTable'];
        $this->Utilisateurs = TableRegistry::get('Utilisateurs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Utilisateurs);

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
