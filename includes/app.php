<?php

$destination_email = $config['destination_email'] ?? 'bwicksall@owwl.org';
$primary_email = $config['primary_email'] ?? $destination_email;
$evergreen_email = $config['evergreen_email'] ?? 'webmaster@owwl.org';
$libraries = $config['libraries'] ?? ['Test Library 1', 'Test Library 2'];
$listservs = $config['listservs'] ?? ['YSL-L', 'Holdings'];
$evergreen_account_types = $config['evergreen_account_types'] ?? ['Basic (No Circ)', 'Circ I', 'Circ II'];

function h(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function post_value(string $key, string $default = ''): string {
    if (!isset($_POST[$key])) {
        return $default;
    }
    return trim((string) $_POST[$key]);
}

function post_array(string $key): array {
    if (!isset($_POST[$key]) || !is_array($_POST[$key])) {
        return [];
    }
    return array_values($_POST[$key]);
}

function valid_yes_no(string $value): bool {
    return $value === 'Yes' || $value === 'No';
}

function selected_from_allowed(array $selected, array $allowed): array {
    return array_values(array_intersect($allowed, $selected));
}
