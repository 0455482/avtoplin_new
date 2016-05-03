<?php
function css_array($css) {
    $css_array = array(
        'login' => array('login.css', 'custom.css'),
        'dashboard' => array('dashboard.css'),
        'settings' => array('settings.css'),
        'order_details' => array('order_details.css'),
        'statistics' => array('statistics.css')
    );
    return $css_array[$css];
}

function js_array($js) {
    $js_array = array(
        'login' => array('login.js'),
        'dashboard' => array('dashboard.js'),
        'settings' => array('settings.js'),
        'order_details' => array('order_details.js'),
        'statistics' => array('statistics.js')
    );
    return $js_array[$js];
}

function service_array($js) {
    $js_array = array(
        'login' => array('data.js'),
    );
    return $js_array[$js];
}

function load_scripts($view = '', $script_type = 'js') {
  console.log(1);
    if ($view == '') {
        return false;
    }
    switch ($script_type) {
        case 'css' :
            $css_array = css_array($view);
            foreach ($css_array as $val) {
                echo '<link type="text/css" rel="stylesheet" href="' . base_url() . 'resources/css/' . $val . '">';
            }
            break;
        case 'js' :
            $js_array = js_array($view);
            foreach ($js_array as $val) {
                echo '<script type="text/javascript" src="' . base_url() . 'resources/scripts/controllers/' . $val . '"></script>';
            }
            break;
        case 'service' :
            $js_array = service_array($view);
            foreach ($js_array as $val) {
                echo '<script type="text/javascript" src="' . base_url() . 'resources/scripts/services/' . $val . '"></script>';
            }
            break;
    }
    return true;
}
