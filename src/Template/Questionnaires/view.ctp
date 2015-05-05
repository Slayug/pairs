<div class="questionnaires view large-12 medium-12 columns">
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
