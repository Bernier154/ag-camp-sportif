<?php

$sportsCampAssetsFolder = '/build';
$sportsCampMixManifest = (function () {
    global $sportsCampAssetsFolder;
    $path = realpath(get_stylesheet_directory() . $sportsCampAssetsFolder . '/mix-manifest.json');
    $data = ($path ? file_get_contents($path) : null) ?? '{}';
    return json_decode($data, true);
})();


/**
 * Get mix file alias.
 *
 * @param null $key The original file path
 * @return string The real file path
 */
function sports_camp_mix($key = null) {
    global $sportsCampMixManifest, $sportsCampAssetsFolder;
    return $sportsCampAssetsFolder . (array_key_exists($key, $sportsCampMixManifest) ? $sportsCampMixManifest[$key] : $key);
}
