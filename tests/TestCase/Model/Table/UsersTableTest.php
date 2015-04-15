<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Users' => 'app.users',
        'Roles' => 'app.roles',
        'Groups' => 'app.groups',
        'GroupsUsers' => 'app.groups_users',
        'Questionnaires' => 'app.questionnaires',
        'AnswersQuestionnaireUsers' => 'app.answers_questionnaire_users',
        'AnswersQuestionnaireUsersPartials' => 'app.answers_questionnaire_users_partials',
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
        $config = TableRegistry::exists('Users') ? [] : ['className' => 'App\Model\Table\UsersTable'];
        $this->Users = TableRegistry::get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

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
