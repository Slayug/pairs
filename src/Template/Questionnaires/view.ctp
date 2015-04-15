<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Questionnaire'), ['action' => 'edit', $questionnaire->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Questionnaire'), ['action' => 'delete', $questionnaire->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionnaire->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Questionnaires'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Questionnaire'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Answers Questionnaire Users'), ['controller' => 'AnswersQuestionnaireUsers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Answers Questionnaire User'), ['controller' => 'AnswersQuestionnaireUsers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Answers Questionnaire Users Partials'), ['controller' => 'AnswersQuestionnaireUsersPartials', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Answers Questionnaire Users Partial'), ['controller' => 'AnswersQuestionnaireUsersPartials', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Questionnaires Groups'), ['controller' => 'QuestionnairesGroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Questionnaires Group'), ['controller' => 'QuestionnairesGroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Questionnaires Questions'), ['controller' => 'QuestionnairesQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Questionnaires Question'), ['controller' => 'QuestionnairesQuestions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Questions'), ['controller' => 'Questions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Question'), ['controller' => 'Questions', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="questionnaires view large-10 medium-9 columns">
    <h2><?= h($questionnaire->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Titre') ?></h6>
            <p><?= h($questionnaire->titre) ?></p>
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($questionnaire->description) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($questionnaire->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date Creation') ?></h6>
            <p><?= h($questionnaire->date_creation) ?></p>
            <h6 class="subheader"><?= __('Date Limite') ?></h6>
            <p><?= h($questionnaire->date_limite) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related AnswersQuestionnaireUsers') ?></h4>
    <?php if (!empty($questionnaire->answers_questionnaire_users)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Question Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Answer Id') ?></th>
            <th><?= __('Questionnaire Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($questionnaire->answers_questionnaire_users as $answersQuestionnaireUsers): ?>
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
    <?php if (!empty($questionnaire->answers_questionnaire_users_partials)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Question Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Answer Id') ?></th>
            <th><?= __('Questionnaire Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($questionnaire->answers_questionnaire_users_partials as $answersQuestionnaireUsersPartials): ?>
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
    <h4 class="subheader"><?= __('Related QuestionnairesGroups') ?></h4>
    <?php if (!empty($questionnaire->questionnaires_groups)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Group Id') ?></th>
            <th><?= __('Questionnaire Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($questionnaire->questionnaires_groups as $questionnairesGroups): ?>
        <tr>
            <td><?= h($questionnairesGroups->group_id) ?></td>
            <td><?= h($questionnairesGroups->questionnaire_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'QuestionnairesGroups', 'action' => 'view', $questionnairesGroups->group_id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'QuestionnairesGroups', 'action' => 'edit', $questionnairesGroups->group_id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'QuestionnairesGroups', 'action' => 'delete', $questionnairesGroups->group_id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionnairesGroups->group_id)]) ?>

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
    <?php if (!empty($questionnaire->questionnaires_questions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Question Id') ?></th>
            <th><?= __('Questionnaire Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($questionnaire->questionnaires_questions as $questionnairesQuestions): ?>
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
    <h4 class="subheader"><?= __('Related Groups') ?></h4>
    <?php if (!empty($questionnaire->groups)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Name') ?></th>
            <th><?= __('Description') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($questionnaire->groups as $groups): ?>
        <tr>
            <td><?= h($groups->id) ?></td>
            <td><?= h($groups->name) ?></td>
            <td><?= h($groups->description) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Groups', 'action' => 'view', $groups->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Groups', 'action' => 'edit', $groups->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Groups', 'action' => 'delete', $groups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groups->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Questions') ?></h4>
    <?php if (!empty($questionnaire->questions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Contenu') ?></th>
            <th><?= __('Type') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($questionnaire->questions as $questions): ?>
        <tr>
            <td><?= h($questions->id) ?></td>
            <td><?= h($questions->contenu) ?></td>
            <td><?= h($questions->type) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Questions', 'action' => 'view', $questions->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Questions', 'action' => 'edit', $questions->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Questions', 'action' => 'delete', $questions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questions->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
