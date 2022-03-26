<?php 

function agcsi_is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;
    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

function agcsi_is_get_valid_days_for_camp($post){
    $start = get_field('date_de_debut',$post);
    $end = get_field('date_de_fin',$post);
    $period = asgsi_get_dates_from_range($start,$end);
    return $period;
}

function asgsi_get_dates_from_range($start, $end, $format = 'Y-m-d') {
    $array = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) { 
        $array[] = $date->format($format); 
    }

    return $array;
}

function agcsi_check_radio($key, $cursor, $val = null) {
    if ($val == $cursor) {
        echo 'checked';
    } else {
        if (isset($_POST[$key])) {
            if ($_POST[$key] == $cursor) {
                echo 'checked';
            }
        } else {
            global $radio_default_enfants;
            if (!is_array($radio_default_enfants)) {
                $radio_default_enfants = [];
            }
            if (!in_array($key, $radio_default_enfants)) {
                echo 'checked';
                $radio_default_enfants[] = $key;
            }
        }
    }
}

function agcsi_check_checkbox($key, $checkboxvalue, $val = null) {
    if ($val) {
        echo 'checked';
    } else {
        if (isset($_POST[$key])) {
            if (is_array($_POST[$key])) {
                if (in_array($checkboxvalue, $_POST[$key])) {
                    echo 'checked';
                }
            } else {
                echo 'checked';
            }
        }
    }
}

function agcsi_fill_text($key, $val = null) {
    if ($val) {
        echo esc_html($val);
    } else {
        if (isset($_POST[$key])) {
            echo esc_html($_POST[$key]);
        }
    }
}

function agcsi_validate_yes_no($val) {
    if (in_array(strtolower($val), ['oui', 'non', 'n/a'])) {
        return $val;
    }
    return 'non';
}

function agcsi_validate_checkbox_array($maladies, $autres, $autre_txt) {
    $sanitized = [];
    foreach ($maladies as $maladie) {
        $sanitized[] = sanitize_text_field($maladie);
    }
    if ($autres) {
        $sanitized[] = sanitize_text_field($autre_txt);
    }
    return $sanitized;
}