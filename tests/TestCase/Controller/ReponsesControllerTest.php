<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ReponsesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ReponsesController Test Case
 */
class ReponsesControllerTest extends IntegrationTestCase
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
