<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Question'), ['action' => 'edit', $question->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Questions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Question'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Answers Questionnaire Users'), ['controller' => 'AnswersQuestionnaireUsers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Answers Questionnaire User'), ['controller' => 'AnswersQuestionnaireUsers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Answers Questionnaire Users Partials'), ['controller' => 'AnswersQuestionnaireUsersPartials', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Answers Questionnaire Users Partial'), ['controller' => 'AnswersQuestionnaireUsersPartials', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Answers Questions'), ['controller' => 'AnswersQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Answers Question'), ['controller' => 'AnswersQuestions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Questionnaires Questions'), ['controller' => 'QuestionnairesQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Questionnaires Question'), ['controller' => 'QuestionnairesQuestions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Answers'), ['controller' => 'Answers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Answer'), ['controller' => 'Answers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Questionnaires'), ['controller' => 'Questionnaires', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Questionnaire'), ['controller' => 'Questionnaires', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="questions view large-10 medium-9 columns">
    <h2><?= h($question->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Contenu') ?></h6>
            <p><?= h($question->contenu) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($question->id) ?></p>
            <h6 class="subheader"><?= __('Type') ?></h6>
            <p><?= $this->Number->format($question->type) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related AnswersQuestionnaireUsers') ?></h4>
    <?php if (!empty($question->answers_questionnaire_users)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Question Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Answer Id') ?></th>
            <th><?= __('Questionnaire Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($question->answers_questionnaire_users as $answersQuestionnaireUsers): ?>
        <tr>
            <td><?= h($answersQuestionnaireUsers->question_id) ?></td>
            <td><?= h($answersQuestionnaireUsers->user_id) ?></td>
            <td><?= h($answersQuestionnaireUsers->answer_id) ?></td>
            <td><?= h($answersQuestionnaireUsers->questionnaire_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'AnswersQuestionnaireUsers', 'action' => 'view', $answersQuestionnaireUsers->question_id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'AnswersQuestionnaireUsers', 'action' => 'edit', $answersQuestionnaireUsers->question_id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AnswersQuestionnaireUsers', 'action' => 'delete', $answersQuestionnaireUsers->question_id], ['confirm' => __('Are you sure you want to delete # {0}?', $answersQuestionnaireUsers->question_id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related AnswersQuestionnaireUsersPartials') ?></h4>
    <?php if (!empty($question->answers_questionnaire_users_partials)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Question Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Answer Id') ?></th>
            <th><?= __('Questionnaire Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($question->answers_questionnaire_users_partials as $answersQuestionnaireUsersPartials): ?>
        <tr>
            <td><?= h($answersQuestionnaireUsersPartials->question_id) ?></td>
            <td><?= h($answersQuestionnaireUsersPartials->user_id) ?></td>
            <td><?= h($answersQuestionnaireUsersPartials->answer_id) ?></td>
            <td><?= h($answersQuestionnaireUsersPartials->questionnaire_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'AnswersQuestionnaireUsersPartials', 'action' => 'view', $answersQuestionnaireUsersPartials->question_id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'AnswersQuestionnaireUsersPartials', 'action' => 'edit', $answersQuestionnaireUsersPartials->question_id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AnswersQuestionnaireUsersPartials', 'action' => 'delete', $answersQuestionnaireUsersPartials->question_id], ['confirm' => __('Are you sure you want to delete # {0}?', $answersQuestionnaireUsersPartials->question_id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related AnswersQuestions') ?></h4>
    <?php if (!empty($question->answers_questions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Question Id') ?></th>
            <th><?= __('Answer Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($question->answers_questions as $answersQuestions): ?>
        <tr>
            <td><?= h($answersQuestions->question_id) ?></td>
            <td><?= h($answersQuestions->answer_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'AnswersQuestions', 'action' => 'view', $answersQuestions->question_id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'AnswersQuestions', 'action' => 'edit', $answersQuestions->question_id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AnswersQuestions', 'action' => 'delete', $answersQuestions->question_id], ['confirm' => __('Are you sure you want to delete # {0}?', $answersQuestions->question_id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related QuestionnairesQuestions') ?></h4>
    <?php if (!empty($question->questionnaires_questions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Question Id') ?></th>
            <th><?= __('Questionnaire Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($question->questionnaires_questions as $questionnairesQuestions): ?>
        <tr>
            <td><?= h($questionnairesQuestions->question_id) ?></td>
            <td><?= h($questionnairesQuestions->questionnaire_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'QuestionnairesQuestions', 'action' => 'view', $questionnairesQuestions->question_id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'QuestionnairesQuestions', 'action' => 'edit', $questionnairesQuestions->question_id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'QuestionnairesQuestions', 'action' => 'delete', $questionnairesQuestions->question_id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionnairesQuestions->question_id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Answers') ?></h4>
    <?php if (!empty($question->answers)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Valeur') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($question->answers as $answers): ?>
        <tr>
            <td><?= h($answers->id) ?></td>
            <td><?= h($answers->valeur) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Answers', 'action' => 'view', $answers->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Answers', 'action' => 'edit', $answers->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Answers', 'action' => 'delete', $answers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $answers->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Questionnaires') ?></h4>
    <?php if (!empty($question->questionnaires)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Titre') ?></th>
            <th><?= __('Description') ?></th>
            <th><?= __('Date Creation') ?></th>
            <th><?= __('Date Limite') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($question->questionnaires as $questionnaires): ?>
        <tr>
            <td><?= h($questionnaires->id) ?></td>
            <td><?= h($questionnaires->titre) ?></td>
            <td><?= h($questionnaires->description) ?></td>
            <td><?= h($questionnaires->date_creation) ?></td>
            <td><?= h($questionnaires->date_limite) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Questionnaires', 'action' => 'view', $questionnaires->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Questionnaires', 'action' => 'edit', $questionnaires->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Questionnaires', 'action' => 'delete', $questionnaires->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionnaires->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
