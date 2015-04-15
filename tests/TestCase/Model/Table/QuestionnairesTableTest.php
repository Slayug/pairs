<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QuestionnairesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QuestionnairesTable Test Case
 */
class QuestionnairesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Questionnaires' => 'app.questionnaires',
        'AnswersQuestionnaireUsers' => 'app.answers_questionnaire_users',
        'AnswersQuestionnaireUsersPartials' => 'app.answers_questionnaire_users_partials',
        'Groups' => 'app.groups',
        'Users' => 'app.users',
        'GroupsUsers' => 'app.groups_users',
        'QuestionnairesGroups' => 'app.questionnaires_groups',
        'Questions' => 'app.questions',
        'Answers' => 'app.answers',
        'AnswersQuestions' => 'app.answers_questions',
        'QuestionnairesQuestions' => 'app.questionnaires_questions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Questionnaires') ? [] : ['className' => 'App\Model\Table\QuestionnairesTable'];
        $this->Questionnaires = TableRegistry::get('Questionnaires', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Questionnaires);

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
