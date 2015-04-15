<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReponsesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReponsesTable Test Case
 */
class ReponsesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Reponses' => 'app.reponses',
        'Questions' => 'app.questions',
        'ReponsesQuestionnaireUtilisateurs' => 'app.reponses_questionnaire_utilisateurs',
        'ReponsesQuestionnaireUtilisateursPartielles' => 'app.reponses_questionnaire_utilisateurs_partielles',
        'Questionnaires' => 'app.questionnaires',
        'Groupes' => 'app.groupes',
        'Utilisateurs' => 'app.utilisateurs',
        'GroupesUtilisateurs' => 'app.groupes_utilisateurs',
        'QuestionnairesGroupes' => 'app.questionnaires_groupes',
        'QuestionnairesQuestions' => 'app.questionnaires_questions',
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
        $config = TableRegistry::exists('Reponses') ? [] : ['className' => 'App\Model\Table\ReponsesTable'];
        $this->Reponses = TableRegistry::get('Reponses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Reponses);

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
