<?php

if (!function_exists('viral_mag_widget_list')) {

    function viral_mag_widget_list() {
        global $wp_registered_sidebars;
        $menu_choice = array();
        $widget_list['none'] = esc_html__('-- Choose Widget --', 'viral-mag');
        if ($wp_registered_sidebars) {
            foreach ($wp_registered_sidebars as $wp_registered_sidebar) {
                $widget_list[$wp_registered_sidebar['id']] = $wp_registered_sidebar['name'];
            }
        }
        return $widget_list;
    }

}

if (!function_exists('viral_mag_cat')) {

    function viral_mag_cat() {
        $cat = array();
        $categories = get_categories(array('hide_empty' => 0));
        if ($categories) {
            foreach ($categories as $category) {
                $cat[$category->term_id] = $category->cat_name;
            }
        }
        return $cat;
    }

}

if (!function_exists('viral_mag_page_choice')) {

    function viral_mag_page_choice() {
        $page_choice = array();
        $pages = get_pages(array('hide_empty' => 0));
        if ($pages) {
            foreach ($pages as $pages_single) {
                $page_choice[$pages_single->ID] = $pages_single->post_title;
            }
        }
        return $page_choice;
    }

}

if (!function_exists('viral_mag_menu_choice')) {

    function viral_mag_menu_choice() {
        $menu_choice = array('none' => esc_html('-- Select Menu --', 'viral-mag'));
        $menus = get_terms('nav_menu', array('hide_empty' => false));
        if ($menus) {
            foreach ($menus as $menus_single) {
                $menu_choice[$menus_single->slug] = $menus_single->name;
            }
        }
        return $menu_choice;
    }

}

if (!function_exists('viral_mag_icon_choices')) {

    function viral_mag_icon_choices() {
        echo '<div id="ht--icon-box" class="ht--icon-box">';
        echo '<div class="ht--icon-search">';
        echo '<select>';

        //See customizer-icon-manager.php file
        $icons = apply_filters('viral_mag_register_icon', array());

        if ($icons && is_array($icons)) {
            foreach ($icons as $icon) {
                if ($icon['name'] && $icon['label']) {
                    echo '<option value="' . esc_attr($icon['name']) . '">' . esc_html($icon['label']) . '</option>';
                }
            }
        }

        echo '</select>';
        echo '<input type="text" class="ht--icon-search-input" placeholder="' . esc_html__('Type to filter', 'viral-mag') . '" />';
        echo '</div>';

        if ($icons && is_array($icons)) {
            $active_class = ' active';
            foreach ($icons as $icon) {
                $icon_name = isset($icon['name']) && $icon['name'] ? $icon['name'] : '';
                $icon_prefix = isset($icon['prefix']) && $icon['prefix'] ? $icon['prefix'] : '';
                $icon_displayPrefix = isset($icon['displayPrefix']) && $icon['displayPrefix'] ? $icon['displayPrefix'] . ' ' : '';

                echo '<ul class="ht--icon-list ' . esc_attr($icon_name) . esc_attr($active_class) . '">';
                $icon_array = isset($icon['icons']) ? $icon['icons'] : '';
                if (is_array($icon_array)) {
                    foreach ($icon_array as $icon_id) {
                        echo '<li><i class="' . esc_attr($icon_displayPrefix) . esc_attr($icon_prefix) . esc_attr($icon_id) . '"></i></li>';
                    }
                }
                echo '</ul>';
                $active_class = '';
            }
        }

        echo '</div>';
    }

}

add_action('customize_controls_print_footer_scripts', 'viral_mag_icon_choices');

function viral_mag_is_upgrade_notice_active() {
    $show_upgrade_notice = get_theme_mod('viral_mag_hide_upgrade_notice', false);
    return !$show_upgrade_notice;
}
