<?php
namespace App\Test\TestCase\Controller;

use App\Controller\QuestionnairesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\QuestionnairesController Test Case
 */
class QuestionnairesControllerTest extends IntegrationTestCase
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
