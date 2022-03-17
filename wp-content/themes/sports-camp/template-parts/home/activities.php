
<?php

$activities = sports_camp_database_query_activity_featured();

include(locate_template('template-parts/activity/list.php')); ?>


<div class="see-more-wrapper">
    <a href="<?= get_post_type_archive_link('activity') ?>"><?= __('Voir toutes les activités', 'sports_camp') ?></a>
</div>
