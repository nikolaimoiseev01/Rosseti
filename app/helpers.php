<?php

if (!function_exists('colorHelper')) {
    function colorHelper($key, $data)
    {
        return ($data[$key] ?? null) ? ('!' . $data[$key]) : '';
    }
}
