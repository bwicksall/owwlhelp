<?php

$default_email = trim((string) ($config['default_email'] ?? ''));
if ($default_email === '') {
    throw new RuntimeException('Config error: default_email is required.');
}

$primary_email = $config['primary_email'] ?? $default_email;
$evergreen_email = $config['evergreen_email'] ?? $default_email;
$overdrive_email = $config['overdrive_email'] ?? $default_email;
$reference_email = $config['reference_email'] ?? $default_email;
$gpldirector_email = $config['gpldirector_email'] ?? $default_email;
$cataloging_email = $config['cataloging_email'] ?? $default_email;
$originalcataloging_email = $config['originalcataloging_email'] ?? $default_email;
$reports_email = $config['reports_email'] ?? $default_email;
$delivery_email = $config['delivery_email'] ?? $default_email;
$admin_email = $config['admin_email'] ?? $default_email;
$libraries = $config['libraries'] ?? [
    'TEST1' => 'Test Library 1',
    'TEST2' => 'Test Library 2',
];
$listservs = $config['listservs'] ?? ['YSL-L', 'Holdings'];
$evergreen_account_types = $config['evergreen_account_types'] ?? ['Basic (No Circ)', 'Circ I', 'Circ II'];
$allowed_email_domains = $config['allowed_email_domains'] ?? ['owwl.org'];
$otp_ttl_seconds = (int) ($config['otp_ttl_seconds'] ?? 600);

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

function normalize_email(string $email): string {
    return strtolower(trim($email));
}

function email_domain_allowed(string $email, array $allowed_domains): bool {
    $parts = explode('@', normalize_email($email));
    if (count($parts) !== 2 || $parts[1] === '') {
        return false;
    }
    return in_array($parts[1], array_map('strtolower', $allowed_domains), true);
}

function otp_generate_code(): string {
    return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
}

function otp_store_challenge(string $email, string $code, int $ttl_seconds): void {
    if (!isset($_SESSION['otp_challenges']) || !is_array($_SESSION['otp_challenges'])) {
        $_SESSION['otp_challenges'] = [];
    }

    $_SESSION['otp_challenges'][normalize_email($email)] = [
        'code_hash' => password_hash($code, PASSWORD_DEFAULT),
        'expires_at' => time() + max(60, $ttl_seconds),
    ];
}

function otp_verify_challenge(string $email, string $code): bool {
    $normalized = normalize_email($email);
    $challenge = $_SESSION['otp_challenges'][$normalized] ?? null;
    if (!$challenge || !isset($challenge['code_hash'], $challenge['expires_at'])) {
        return false;
    }
    if ((int) $challenge['expires_at'] < time()) {
        unset($_SESSION['otp_challenges'][$normalized]);
        return false;
    }
    return password_verify($code, (string) $challenge['code_hash']);
}

function requester_mark_verified(string $email): void {
    if (!isset($_SESSION['verified_emails']) || !is_array($_SESSION['verified_emails'])) {
        $_SESSION['verified_emails'] = [];
    }
    $_SESSION['verified_emails'][normalize_email($email)] = true;
}

function requester_clear_verified(string $email): void {
    if (!isset($_SESSION['verified_emails']) || !is_array($_SESSION['verified_emails'])) {
        return;
    }
    $normalized = normalize_email($email);
    if (isset($_SESSION['verified_emails'][$normalized])) {
        unset($_SESSION['verified_emails'][$normalized]);
    }
}

function requester_is_verified(string $email): bool {
    if (!isset($_SESSION['verified_emails']) || !is_array($_SESSION['verified_emails'])) {
        return false;
    }
    return !empty($_SESSION['verified_emails'][normalize_email($email)]);
}

function otp_clear_challenge(string $email): void {
    $normalized = normalize_email($email);
    if (isset($_SESSION['otp_challenges'][$normalized])) {
        unset($_SESSION['otp_challenges'][$normalized]);
    }
}

function requester_set_active_email(string $email): void {
    $_SESSION['active_requester_email'] = normalize_email($email);
}

function requester_get_active_email(): string {
    if (!isset($_SESSION['active_requester_email'])) {
        return '';
    }
    return (string) $_SESSION['active_requester_email'];
}

function optional_value(string $value, string $fallback = 'None'): string {
    return $value !== '' ? $value : $fallback;
}

function render_email_template(string $template_name, array $values = []): string {
    $template_path = __DIR__ . '/../templates/email/' . $template_name . '.txt';
    if (!is_file($template_path) || !is_readable($template_path)) {
        throw new RuntimeException("Email template not found: {$template_name}");
    }

    $template = file_get_contents($template_path);
    if ($template === false) {
        throw new RuntimeException("Unable to read email template: {$template_name}");
    }

    $replacements = [];
    foreach ($values as $key => $value) {
        if (!is_scalar($value) && $value !== null) {
            continue;
        }
        $replacements['{{' . (string) $key . '}}'] = (string) ($value ?? '');
    }

    return strtr($template, $replacements);
}
