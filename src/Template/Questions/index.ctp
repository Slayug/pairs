<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Question'), ['action' => 'add']) ?></li>
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
<div class="questions index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('contenu') ?></th>
            <th><?= $this->Paginator->sort('type') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($questions as $question): ?>
        <tr>
            <td><?= $this->Number->format($question->id) ?></td>
            <td><?= h($question->contenu) ?></td>
            <td><?= $this->Number->format($question->type) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $question->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $question->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id)]) ?>
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
