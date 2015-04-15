<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Questions'), ['action' => 'index']) ?></li>
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
<div class="questions form large-10 medium-9 columns">
    <?= $this->Form->create($question); ?>
    <fieldset>
        <legend><?= __('Add Question') ?></legend>
        <?php
            echo $this->Form->input('contenu');
            echo $this->Form->input('type');
            echo $this->Form->input('answers._ids', ['options' => $answers]);
            echo $this->Form->input('questionnaires._ids', ['options' => $questionnaires]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
