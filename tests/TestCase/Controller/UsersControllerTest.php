<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
