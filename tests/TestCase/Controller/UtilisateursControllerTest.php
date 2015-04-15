<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UtilisateursController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\UtilisateursController Test Case
 */
class UtilisateursControllerTest extends IntegrationTestCase
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
