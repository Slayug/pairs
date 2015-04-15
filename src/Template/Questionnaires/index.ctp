<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Questionnaire'), ['action' => 'add']) ?></li>
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
<div class="questionnaires index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('titre') ?></th>
            <th><?= $this->Paginator->sort('description') ?></th>
            <th><?= $this->Paginator->sort('date_creation') ?></th>
            <th><?= $this->Paginator->sort('date_limite') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($questionnaires as $questionnaire): ?>
        <tr>
            <td><?= $this->Number->format($questionnaire->id) ?></td>
            <td><?= h($questionnaire->titre) ?></td>
            <td><?= h($questionnaire->description) ?></td>
            <td><?= h($questionnaire->date_creation) ?></td>
            <td><?= h($questionnaire->date_limite) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $questionnaire->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $questionnaire->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $questionnaire->id], ['confirm' => __('Are you sure you want to delete # {0}?', $questionnaire->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
