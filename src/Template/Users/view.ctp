<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Êtes-vous sûr de supprimer # {0} ?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Donations'), ['controller' => 'Donations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Donation'), ['controller' => 'Donations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Pseudo') ?></th>
            <td><?= h($user->alias) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rôle') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rue') ?></th>
            <td><?= $this->Number->format($user->street) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Donations') ?></h4>
        <?php if (!empty($user->donations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Image 1 Url') ?></th>
                <th scope="col"><?= __('Image 2 Url') ?></th>
                <th scope="col"><?= __('Image 3 Url') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->donations as $donations): ?>
            <tr>
                <td><?= h($donations->id) ?></td>
                <td><?= h($donations->title) ?></td>
                <td><?= h($donations->description) ?></td>
                <td><?= h($donations->state) ?></td>
                <td><?= h($donations->category_id) ?></td>
                <td><?= h($donations->image_1_url) ?></td>
                <td><?= h($donations->image_2_url) ?></td>
                <td><?= h($donations->image_3_url) ?></td>
                <td><?= h($donations->user_id) ?></td>
                <td><?= h($donations->created) ?></td>
                <td><?= h($donations->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Donations', 'action' => 'view', $donations->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Donations', 'action' => 'edit', $donations->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Donations', 'action' => 'delete', $donations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $donations->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
