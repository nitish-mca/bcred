<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Offer'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="offers index large-9 medium-8 columns content">
    <h3><?= __('Offers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subcategory_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subtitle') ?></th>                
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('facetime_phone') ?></th>
              <?php /*  <th scope="col"><?= $this->Paginator->sort('is_expired') ?></th> */ ?>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= $this->Number->format($offer->id) ?></td>
                <td><?= h($offer->title) ?></td>
                <td><?= $offer->has('subcategory') ? $this->Html->link($offer->subcategory->title, ['controller' => 'Subcategories', 'action' => 'view', $offer->subcategory->id]) : '' ?></td>
                <td><?= isset($categories[$offer->subcategory->category_id]) ? $this->Html->link($categories[$offer->subcategory->category_id], ['controller' => 'categories', 'action' => 'view', $offer->subcategory->category_id]) : '' ?></td>
                <td><?= h($offer->subtitle) ?></td>
                <td><?= h($offer->email) ?></td>
                <td><?= h($offer->phone) ?></td>
                <td><?= h($offer->facetime_phone) ?></td>
                <?php /*<td><?= h($offer->is_expired) ?></td>*/ ?>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $offer->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $offer->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $offer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $offer->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
