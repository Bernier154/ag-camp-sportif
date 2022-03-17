<?php

function sports_camp_database_query_media_with_date() {
    $query = [
        'post_type' => 'attachment',
        'post_status' => 'any',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'date',
                'compare' => 'EXISTS'
            ]
        ],
        'meta_key' => 'date',
        'meta_type' => 'DATE',
        'orderby' => 'meta_value',
        'order' => 'DESC'
    ];

    $separation = get_field('separation', sports_camp_get_media_page_id());
    $seasonsLabel = ['hiver', 'printemps', 'été', 'automne'];
    $months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

    $formatDayNumber = function ($t) {
        $day = intval(date('d', $t));
        return $day === 1 ? '1er' : "$day";
    };

    $formatMonth = function ($t) use ($months) {
        return $months[intval(date('n', $t)) - 1];
    };

    $formatYear = function ($t) {
        return date('Y', $t);
    };

    $formatDay = function ($t) use ($formatDayNumber, $formatMonth, $formatYear) {
        return $formatDayNumber($t) . ' ' . $formatMonth($t) . ' ' . $formatYear($t);
    };

    $separator = function (WP_Post $post_a, WP_Post $post_b) use ($separation) {
        $a = strtotime(get_field('date', $post_a->ID));
        $b = strtotime(get_field('date', $post_b->ID));

        switch ($separation) {
            case 'day':
                return date('Ymd', $a) !== date('Ymd', $b);
            case 'week':
                return date('oW', $a) !== date('ow', $b);
            case 'month':
                return date('Ym', $a) !== date('Ym', $b);
            case 'season':
                $oa = $a + (60 * 60 * 24 * 11);
                $ob = $b + (60 * 60 * 24 * 11);
                return intval(floor(date('n', $oa) / 3)) !== intval(floor(date('n', $ob) / 3)) || date('Y', $oa) !== date('Y', $ob);
            case 'year':
                return date('Y', $a) !== date('Y', $b);
            default:
                return false;
        }
    };

    $labelFormatter = function (WP_Post $post) use ($separation, $seasonsLabel, $formatDay, $formatMonth, $formatYear) {
        $time = strtotime(get_field('date', $post->ID));

        switch ($separation) {
            case 'day':
                return $formatDay($time);
            case 'week':
                return 'Semaine du ' . $formatDay($time - ((date('w', $time) - 1) * 60 * 60 * 24));
            case 'month':
                return $formatMonth($time) . ' ' . $formatYear($time);
            case 'season':
                $otime = $time + (60 * 60 * 24 * 11);
                $seasonKey = intval(floor(date('n', $otime) / 3));
                return $seasonsLabel[$seasonKey] . ' ' . $formatYear($time);
            case 'year':
                return $formatYear($time);
            default:
                return '';
        }
    };

    return new SeparatedQuery($query, $separator, $labelFormatter);
}
