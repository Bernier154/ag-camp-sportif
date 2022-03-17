<?php

$sportsCampPostTypes = (function () {
    $contentPath = get_stylesheet_directory() . '/content';
    $types = [];
    $folders = array_values(array_filter(scandir(realpath($contentPath)), function ($folder) {
        return strpos($folder, '.') !== 0;
    }));

    foreach ($folders as $type) {
        $typePath = $contentPath . '/' . $type;

        if (file_exists(realpath($typePath . '/definition.php'))) {
            $data = [];
            foreach(['definition', 'fields', 'supports', 'taxonomies'] as $file) {
                $fieldsFilePath = realpath($typePath . '/' . $file . '.php');
                $data[$file] = file_exists($fieldsFilePath) ? require($fieldsFilePath) : [];
            }
            $types[$type] = $data;
        }
    }

    return $types;
})();
