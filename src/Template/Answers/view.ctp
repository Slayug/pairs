<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Answer'), ['action' => 'edit', $answer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Answer'), ['action' => 'delete', $answer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $answer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Answers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Answer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Answers Questions'), ['controller' => 'AnswersQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Answers Question'), ['controller' => 'AnswersQuestions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Questions'), ['controller' => 'Questions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Question'), ['controller' => 'Questions', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="answers view large-10 medium-9 columns">
    <h2><?= h($answer->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Valeur') ?></h6>
            <p><?= h($answer->valeur) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($answer->id) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related AnswersQuestions') ?></h4>
    <?php if (!empty($answer->answers_questions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Question Id') ?></th>
            <th><?= __('Answer Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($answer->answers_questions as $answersQuestions): ?>
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
    <h4 class="subheader"><?= __('Related Questions') ?></h4>
    <?php if (!empty($answer->questions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Contenu') ?></th>
            <th><?= __('Type') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($answer->questions as $questions): ?>
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
