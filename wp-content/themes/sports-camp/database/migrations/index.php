<?php


function sports_camp_migration_run() {
    foreach(sports_camp_migration_all() as $migration) {
        $migration();
    }
}

function sports_camp_migration_all() {
    $currentFile = preg_replace('/[\/\\\]/', '', str_replace(__DIR__, '', __FILE__));

    $migrations = [];
    foreach (array_diff(scandir(__DIR__), ['.', '..', $currentFile]) as $file) {
        $migrations[] = sports_camp_migration_get($file);
    }

    return array_filter($migrations);
}


function sports_camp_migration_get($id) {
    if (!sports_camp_migration_has_run($id)) {
        return function () use ($id) {
            require(__DIR__ . '/' . $id);
            sports_camp_migration_append_theme_mod($id);
        };
    }

    return null;
}

function sports_camp_migration_has_run($id) {
    return in_array($id, sports_camp_migration_get_theme_mod());
}

function sports_camp_migration_get_theme_mod() {
    return json_decode(get_theme_mod(sports_camp_migration_get_theme_mod_key(), json_encode([])), true);
}

function sports_camp_migration_set_theme_mod($value) {
    set_theme_mod(sports_camp_migration_get_theme_mod_key(), json_encode($value));
}

function sports_camp_migration_append_theme_mod($id) {
    $migrations = sports_camp_migration_get_theme_mod();
    $migrations[] = $id;
    sports_camp_migration_set_theme_mod($migrations);
}

function sports_camp_migration_get_theme_mod_key() {
    return 'sports_camp_migrations';
}
