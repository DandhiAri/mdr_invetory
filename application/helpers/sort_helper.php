<?php
if (!function_exists('sort_link')) {
    function sort_link($title, $column, $sort_by, $sort_order) {
        $CI =& get_instance();
        $uri_segments = $CI->uri->segment_array();
        $uri_segments[4] = 'sort_by=' . $column;
        $uri_segments[5] = 'sort_order=' . ($sort_by == $column && $sort_order == 'asc' ? 'desc' : 'asc');
        $url = implode('/', $uri_segments);
        
        $class = $sort_by == $column ? 'sorted ' . $sort_order : '';
        $icon = $sort_by == $column ? ($sort_order == 'asc' ? '▲' : '▼') : '';
        
        return '<a href="' . site_url($url) . '" class="' . $class . '">' . $title . ' ' . $icon . '</a>';
    }
}
