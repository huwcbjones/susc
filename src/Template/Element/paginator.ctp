<div class="paginator">
    <div class="row">
        <div class="col-sm-8">
            <nav>
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers(['before' => null, 'after' => null]) ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
            </nav>
        </div>
        <div class="col-sm-4">
            <?= $this->Paginator->limitControl([20 => 20, 50=>50, 100=>100], null, ['label' => 'Items per Page']) ?>
        </div>
    </div>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>