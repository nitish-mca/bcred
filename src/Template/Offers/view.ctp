<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Offer'), ['action' => 'edit', $offer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Offer'), ['action' => 'delete', $offer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $offer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Offers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Offer'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="offers view large-9 medium-8 columns content">
    <h3><?= h($offer->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($offer->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subcategory') ?></th>
            <td><?= $offer->has('subcategory') ? $this->Html->link($offer->subcategory->title, ['controller' => 'Subcategories', 'action' => 'view', $offer->subcategory->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= isset($categories[$offer->subcategory->category_id]) ? $this->Html->link($categories[$offer->subcategory->category_id], ['controller' => 'categories', 'action' => 'view', $offer->subcategory->category_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subtitle') ?></th>
            <td><?= h($offer->subtitle) ?></td>
        </tr>
              
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($offer->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($offer->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Facetime Phone') ?></th>
            <td><?= h($offer->facetime_phone) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($offer->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Urls') ?></h4>
        <ul>
        <?php 
        if(!empty($offer->urls)):
        $url = unserialize($offer->urls);
        foreach ($url as $u): ?>
            <li><a href="<?=$u?>" target="_blank"><?=$u?></a></li>
        <?php endforeach;       endif; ?>
        </ul>
    </div>
    <div class="row">
        <h4><?= __('Related Images') ?></h4>
        <?php echo $this->Html->image('Offers/photo/'.$offer->photo, ['alt' => $offer->photo]); ?>
    </div>
    
</div>
