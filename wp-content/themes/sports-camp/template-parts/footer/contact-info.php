<?php
$contact_info = sports_camp_get_contact_info();
$class_prefix = 'contact-info';
?>
<div class="<?= $class_prefix ?>">
    <h5 class="<?= $class_prefix ?>-name"><?= $contact_info['name'] ?></h5>
    <p class="<?= $class_prefix ?>-address"><?= $contact_info['address_1'] ?> <?= $contact_info['address_2'] ?></p>
    <p class="<?= $class_prefix ?>-city"><?= $contact_info['city'] ?><?= ($contact_info['city'] && $contact_info['state'] ? ', ' : '') ?><?= $contact_info['state'] ?> <?= $contact_info['zip'] ?></p>
    <?php if ($contact_info['phone']): ?>
        <p class="<?= $class_prefix ?>-phone">
            <a href="tel:<?= preg_replace('/[^0-9]/', '', $contact_info['phone']) ?>"><?= $contact_info['phone'] ?></a>
        </p>
    <?php endif; ?>
    <?php if ($contact_info['email']) : ?>
        <p class="<?= $class_prefix ?>-email"><a href="mailto:<?= $contact_info['email'] ?>"><?= $contact_info['email'] ?></a>
        </p>
    <?php endif; ?>
</div>
