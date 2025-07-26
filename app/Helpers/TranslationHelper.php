<?php

if (!function_exists('trans_dynamic')) {
    function trans_dynamic($key, $locale = null) {
        return \App\Models\Translation::trans($key, $locale);
    }
}
