<?php session_start(); ?>
<!DOCTYPE html>
<!---- for browser version check----------------------------->
<script>
var browser = '';
var browserVersion = 0;
if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
    browser = 'MSIE';
}
var match = navigator.userAgent.match(/MSIE (\d+\.\d+);/);
if (match) {
    var browserVersion = parseFloat(match[1]);
    if (browserVersion < 9) {
        window.location.href = "error_page.php";
    }
}
if (browserVersion > 0 && browserVersion < 9) {
    window.location.href = "error_page.php";
}
</script>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AACANet | Sign In</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="css/PSnnect.min.css">
  <link rel="stylesheet" href="css/PSPanel.css">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/fevicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/fevicon.ico">
  <link rel="apple-touch-icon-precomposed" href="img/fevicon.ico">
  <link rel="shortcut icon" href="img/fevicon.ico">

<script src="js/PSjquery.min.js"></script>
<script src="js/PSnnect.min.js"></script>
<script src="js/PsnnectValidator.min.js"></script>
<script src="js/SignInVal.js"></script>
<link rel="stylesheet" href="css/sweetalert.css">
<script src="js/sweetalert.min.js"></script>
<style>
html { background-image: linear-gradient(to bottom right, #BB133E, #002e5b); }
body { background: #ffffff00; }
.clearable__clear { position: absolute; top: 6px; }
:focus-visible { outline: -webkit-focus-ring-color auto 0px !important; }
input:-internal-autofill-selected { background-color: #fff !important; }
.wrapper-login button[type=button],
.wrapper-login button[type=submit],
.wrapper-login button[type=reset] {
    -webkit-box-shadow: 2px 2px 3px #002e5b;
    box-shadow: 2px 2px 3px #002e5b;
}
.wrapper-login a { font-size: 14px; }
.logo-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 32px;
    margin-bottom: 24px;
}
.aacanet-logo, .pipeway-logo {
    max-width: 220px;
    width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
}
.ml10 { margin-left: 10px; }
.mt10 { margin-top: 10px; }
.f_wid { width: 100%; }
.user { background: #ffffff; border: 3px solid #002e5b; border-radius: 15px; padding: 2px 0px; }
.user:hover { box-shadow: 6px 6px 8px lightgrey; }
.bor { border-bottom: 0px solid #28648A !important; width: 100%; border-top-right-radius: 9px; border-bottom-right-radius: 9px; }
.wrapper-login input[type=text],
.wrapper-login input[type=password] { background-color: #e8f0fe !important; }
.p0 { padding: 0px; }
.pr0 { padding-right: 0px; }
.input-group .input-group-addon:hover { font-size: 18px; }
.fourth:hover { box-shadow: 2px 2px 4px #002e5b !important; font-size: 14px !important; }

/* ── Device management panels ── */
.device-panel {
    background: #fff;
    border: 2px solid #002e5b;
    border-radius: 12px;
    padding: 18px 20px;
    margin-top: 10px;
}
.device-panel h5 {
    color: #002e5b;
    font-weight: 700;
    margin-bottom: 12px;
    font-size: 14px;
}
.device-panel p {
    font-size: 12px;
    color: #555;
    margin-bottom: 14px;
}
.device-choice-btn {
    display: block;
    width: 100%;
    padding: 9px 14px;
    margin-bottom: 8px;
    border-radius: 8px;
    border: 2px solid #002e5b;
    background: #fff;
    color: #002e5b;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-align: left;
    transition: background 0.2s, color 0.2s;
}
.device-choice-btn:hover { background: #002e5b; color: #fff; }
.device-choice-btn.btn-primary-solid { background: #002e5b; color: #fff; }
.device-choice-btn.btn-primary-solid:hover { background: #001f42; }
.device-list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #dce3ec;
    border-radius: 8px;
    padding: 8px 12px;
    margin-bottom: 7px;
    background: #f7f9fc;
}
.device-list-item label {
    font-size: 12px;
    color: #333;
    margin: 0;
    cursor: pointer;
    flex: 1;
    padding-left: 8px;
}
.device-list-item input[type=radio] { cursor: pointer; }
.device-nickname-input {
    width: 100%;
    border: 1px solid #b0bec5;
    border-radius: 6px;
    padding: 7px 10px;
    font-size: 12px;
    margin-top: 4px;
    margin-bottom: 10px;
    background: #e8f0fe;
}
.otp-input-box {
    letter-spacing: 4px;
    font-size: 20px;
    text-align: center;
    border: 2px solid #002e5b;
    border-radius: 8px;
    padding: 8px;
    background: #e8f0fe;
    width: 100%;
}
.btn-link-style {
    background: none;
    border: none;
    color: #002e5b;
    text-decoration: underline;
    cursor: pointer;
    font-size: 12px;
    padding: 0;
}
</style>
</head>

<body class="hold-transition skin-yellow sidebar-mini" style="background-color: rgba(0,0,0,0);">
<div id="show">
    <img src="img/tilt.png" style="width:80px;">
    <h6>We don't support Mobile view — for best experience go to Desktop view</h6>
</div>

<?php

error_reporting(1);
include_once "config.php";
// NOTE: session_start() is already called at the very top of this file.
// Do NOT call it again here — a second call corrupts the session and causes
// "headers already sent" warnings, which was the root cause of the nickname
// and session-loss bugs.

/* ═══════════════════════════════════════════════════════════════════════════════
   HELPER FUNCTIONS
   ═══════════════════════════════════════════════════════════════════════════════ */

function safe_post_value($key, $default = '')
{
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

function safe_array_value($array, $key, $default = '')
{
    return (is_array($array) && array_key_exists($key, $array)) ? $array[$key] : $default;
}

/**
 * Splits a comma-separated string into a clean, deduplicated array.
 * Prevents leading/trailing commas and blank entries.
 * (PDF fix: "IP address starting with comma")
 */
function normalize_csv_values($value)
{
    $value = trim((string)$value);
    if ($value === '') {
        return [];
    }
    $clean = [];
    foreach (explode(',', $value) as $part) {
        $part = trim($part);
        if ($part !== '' && !in_array($part, $clean, true)) {
            $clean[] = $part;
        }
    }
    return $clean;
}

/**
 * Normalises any date/time value to Y-m-d H:i:s.
 * (PDF fix: "OTP time and mail time not looking like a timestamp",
 *           "PastExpDate looks invalid")
 */
function parse_date_to_standard($value)
{
    $value = trim((string)$value);
    if ($value === '') {
        return null;
    }
    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $value);
    if ($dt instanceof DateTime) {
        return $dt->format('Y-m-d H:i:s');
    }
    $dt = DateTime::createFromFormat('Y-m-d', $value);
    if ($dt instanceof DateTime) {
        return $dt->format('Y-m-d') . ' 00:00:00';
    }
    return null;
}

/**
 * Returns true/false/null for company active state.
 * Single rule: Status 1 = active, anything else = inactive.
 * Source: manage_company_registry (authoritative per PDF).
 * Fallback: tbl_login.company_status if registry has no record.
 * (PDF fix: "Incorrect coding for active company-id",
 *           "Company status is inaccurate")
 */
function is_company_active($conn, $companyId)
{
    $companyId = trim((string)$companyId);
    if ($companyId === '') {
        return null;
    }
    $sql  = "SELECT Status FROM manage_company_registry WHERE CompanyId = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return null;
    }
    mysqli_stmt_bind_param($stmt, 's', $companyId);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return null;
    }
    $result = mysqli_stmt_get_result($stmt);
    $row    = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);
    if (!$row) {
        return null;
    }
    return ((int)$row['Status'] === 1);
}

/**
 * Checks whether a user is active/approved by querying manage_user registry.
 *
 * The PDF plan says:
 *   "manage user and manage company registry should be used to determine
 *    if the user is active, inactive, terminated, etc."
 *
 * Priority:
 *   1. Query manage_user → Status 1 = active.
 *   2. If no record found, return null so the caller falls back to
 *      tbl_login.AuthorisedFlag.
 */
function is_user_active_in_registry($conn, $userId)
{
    $userId = (int)$userId;
    if ($userId <= 0) {
        return null;
    }
    $sql  = "SELECT Status FROM manage_user WHERE UserId = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return null;
    }
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return null;
    }
    $result = mysqli_stmt_get_result($stmt);
    $row    = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);
    if (!$row) {
        return null;
    }
    return ((int)$row['Status'] === 1);
}

/**
 * Builds a SHA-256 device fingerprint from the raw string POSTed by JS.
 * JS collects: browser UA, screen size, connection type — per PDF plan Option 1.
 */
function build_device_fingerprint_from_js($rawFpString)
{
    $raw = trim((string)$rawFpString);
    if ($raw === '') {
        return '';
    }
    return hash('sha256', strtolower($raw));
}

/**
 * Fallback fingerprint when JS value is not available (JS disabled).
 * Uses server-side signals: user-agent + hostname + IP.
 */
function build_device_fingerprint_fallback($agent, $host_name, $ipAddress)
{
    return hash(
        'sha256',
        strtolower(trim((string)$agent)) . '|' .
        strtolower(trim((string)$host_name)) . '|' .
        trim((string)$ipAddress)
    );
}

/**
 * Returns a human-readable label for a trusted device.
 * Uses the user's custom nickname if one was saved, otherwise "Device N".
 */
function get_device_label($fingerprint, $slotIndex, $nicknameMap)
{
    if (is_array($nicknameMap) && isset($nicknameMap[$fingerprint]) && $nicknameMap[$fingerprint] !== '') {
        return htmlspecialchars($nicknameMap[$fingerprint], ENT_QUOTES, 'UTF-8');
    }
    return 'Device ' . $slotIndex;
}

/**
 * Loads the nickname map (fingerprint → label) from the DB column device_nicknames.
 * The column stores a JSON object. Returns [] on any failure.
 */
function load_nickname_map($row)
{
    $raw = safe_array_value($row, 'device_nicknames', '');
    if ($raw === '') {
        return [];
    }
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

/**
 * Persists the nickname map back to the DB.
 */
function save_nickname_map($conn, $userId, $nicknameMap)
{
    $json = json_encode($nicknameMap, JSON_UNESCAPED_UNICODE);
    $sql  = "UPDATE tbl_login SET device_nicknames = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return;
    }
    mysqli_stmt_bind_param($stmt, 'si', $json, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/* ── OTP helpers ──────────────────────────────────────────────────────────────
   - Always 6 numeric digits → never starts with '=' → Excel-safe.
   - Count starts at 0, increments on wrong attempt, hard stop at 5,
     resets to 0 when a new OTP is generated.
   (PDF fix: "OTP starting with = causes issues in Excel",
             "OTP count being NULL or higher than 5")
*/

function generate_login_otp()
{
    return (string)random_int(100000, 999999);
}

function sanitize_otp_for_storage($otp)
{
    return ltrim(trim((string)$otp), '=+-@');
}

function send_login_otp_notification($email, $fullName, $otp)
{
    $subject  = 'Your login OTP';
    $message  = "Hello " . trim((string)$fullName) . ",\n\n"
              . "Your login OTP is: " . $otp . "\n"
              . "It will expire in 5 minutes.\n\n"
              . "If you did not request this, please contact your administrator.\n";
    $headers  = "From: no-reply@localhost\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    if (function_exists('mail')) {
        @mail($email, $subject, $message, $headers);
    }
}

function store_login_otp($conn, $userId, $otp)
{
    $otp = sanitize_otp_for_storage($otp);
    if ($otp === '') {
        return false;
    }
    $now  = date('Y-m-d H:i:s');
    $sql  = "UPDATE tbl_login
                SET otp_code       = ?,
                    otp_count      = 0,
                    otp_created_at = ?,
                    otp_mail_time  = ?
              WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'sssi', $otp, $now, $now, $userId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function clear_login_otp($conn, $userId)
{
    $sql  = "UPDATE tbl_login SET otp_code = NULL, otp_count = 0, otp_created_at = NULL WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

/* ── IP history ───────────────────────────────────────────────────────────────
   Max 5 unique IPs. Commas only between values, no leading/trailing comma.
   (PDF fix: "More than 5 IPs are getting saved",
             "IP address starting with a comma")
*/
function update_ip_history($conn, $userId, $existingCsv, $currentIp, $maxItems = 5)
{
    $currentIp = trim((string)$currentIp);
    if ($currentIp === '') {
        return;
    }
    $list = normalize_csv_values($existingCsv);
    if (!in_array($currentIp, $list, true)) {
        $list[] = $currentIp;
    }
    $list = array_values(array_unique(array_filter($list, fn($v) => trim((string)$v) !== '')));
    if (count($list) > $maxItems) {
        $list = array_slice($list, -$maxItems);
    }
    $newCsv = implode(',', $list);
    if ($newCsv === implode(',', normalize_csv_values($existingCsv))) {
        return;
    }
    $sql  = "UPDATE tbl_login SET IPaddress = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return;
    }
    mysqli_stmt_bind_param($stmt, 'si', $newCsv, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/* ── Device history ───────────────────────────────────────────────────────────
   Max 5 trusted devices. Same clean-list logic as IP history.
   (PDF fix: device limit max 5)
*/
function update_device_history($conn, $userId, $existingCsv, $currentDevice, $maxItems = 5)
{
    $currentDevice = trim((string)$currentDevice);
    if ($currentDevice === '') {
        return;
    }
    $list = normalize_csv_values($existingCsv);
    if (!in_array($currentDevice, $list, true)) {
        $list[] = $currentDevice;
    }
    $list = array_values(array_unique(array_filter($list, fn($v) => trim((string)$v) !== '')));
    if (count($list) > $maxItems) {
        $list = array_slice($list, -$maxItems);
    }
    $newCsv = implode(',', $list);
    if ($newCsv === implode(',', normalize_csv_values($existingCsv))) {
        return;
    }
    $sql  = "UPDATE tbl_login SET device_ids = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return;
    }
    mysqli_stmt_bind_param($stmt, 'si', $newCsv, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/**
 * Removes a single device fingerprint from the trusted list and drops
 * its nickname from the nickname map.
 * (PDF plan: allow user to choose which device to remove)
 */
function remove_device_from_history($conn, $userId, $existingCsv, $fingerprintToRemove, $nicknameMap)
{
    $list = normalize_csv_values($existingCsv);
    $list = array_values(array_filter($list, fn($fp) => $fp !== $fingerprintToRemove));

    if (isset($nicknameMap[$fingerprintToRemove])) {
        unset($nicknameMap[$fingerprintToRemove]);
        save_nickname_map($conn, $userId, $nicknameMap);
    }

    $newCsv = implode(',', $list);
    $sql    = "UPDATE tbl_login SET device_ids = ? WHERE id = ?";
    $stmt   = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return;
    }
    mysqli_stmt_bind_param($stmt, 'si', $newCsv, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/* ── Fetch helpers ────────────────────────────────────────────────────────── */

function fetch_login_row_by_id($conn, $userId)
{
    $sql  = "SELECT * FROM tbl_login WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row    = $result ? mysqli_fetch_assoc($result) : [];
    mysqli_stmt_close($stmt);
    return $row ?: [];
}

/**
 * Normalises Passexpdate to Y-m-d H:i:s in the DB on every login.
 * (PDF fix: "PastExpDate looks invalid")
 */
function normalize_passexpdate_in_db($conn, $userId, $value)
{
    $normalized = parse_date_to_standard($value);
    if ($normalized === null) {
        return;
    }
    $sql  = "UPDATE tbl_login SET Passexpdate = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return;
    }
    mysqli_stmt_bind_param($stmt, 'si', $normalized, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/* ═══════════════════════════════════════════════════════════════════════════════
   FINALIZE LOGIN
   Sets session variables and redirects the user to the correct landing page.

   Check_multiple_status – count of active tbl_login rows for this email.
     > 1 means the same email is shared between a firm and a client account.

   active_inactive_status – 0 = blocked/pending, 1 = active.
     Blocks login only when value is 0.
   ═══════════════════════════════════════════════════════════════════════════════ */

function finalize_login_from_row($conn, $row, $agent, $ipAddress, $host_name, $DATE1, $DATE2, $DATE4)
{
    $loginStatus   = safe_array_value($row, 'loginStatus');
    $userType      = safe_array_value($row, 'userType');
    $state         = safe_array_value($row, 'state');
    $portfolioCode = safe_array_value($row, 'portfolioCode');
    $role          = safe_array_value($row, 'role');
    $role1         = safe_array_value($row, 'role');
    $fullName      = safe_array_value($row, 'fullName');
    $email         = safe_array_value($row, 'email');
    $userloginType = safe_array_value($row, 'userloginType');
    $productCode   = safe_array_value($row, 'productCode');
    $firmCode      = safe_array_value($row, 'firmCode');
    $clientCode    = safe_array_value($row, 'clientCode');
    $companyId     = safe_array_value($row, 'companyId');
    $LastName      = safe_array_value($row, 'LastName');
    $id            = (int)safe_array_value($row, 'id', 0);

    if ((int)$role === 6 || (int)$role === 10) {
        $role = 6;
    }

    session_regenerate_id(true);

    $_SESSION['email']                         = $email;
    $_SESSION['userType']                      = $userType;
    $_SESSION['state']                         = $state;
    $_SESSION['portfolioCode']                 = $portfolioCode;
    $_SESSION['role']                          = $role;
    $_SESSION['role60r10']                     = $role1;
    $_SESSION['fullName']                      = $fullName;
    $_SESSION['userloginType']                 = $userloginType;
    $_SESSION['productCode']                   = $productCode;
    $_SESSION['firmCode']                      = $firmCode;
    $_SESSION['clientCode']                    = $clientCode;
    $_SESSION['companyId']                     = $companyId;
    $_SESSION['LastName']                      = $LastName;
    $_SESSION['id']                            = $id;
    $_SESSION['UserGroup']                     = safe_array_value($row, 'UserGroup');
    $_SESSION['phoneNo']                       = safe_array_value($row, 'phoneNo');
    $_SESSION['timeout']                       = time();
    $_SESSION['login_time_stamp']              = time();
    $_SESSION['firmCodenew']                   = $firmCode;
    $_SESSION['clientCodenew']                 = $clientCode;
    $_SESSION['deviceFingerprint']             = safe_array_value($_SESSION, 'otp_login_device', '');
    $_SESSION['AACA_RCVD_BATCH_FROM']          = $DATE1;
    $_SESSION['AACA_RCVD_BATCH_END']           = $DATE2;
    $_SESSION['AACA_RCVD_BATCH_FROM_PIE']      = '2002-01';
    $_SESSION['AACA_RCVD_BATCH_END_PIE']       = $DATE2;
    $_SESSION['SETLMNT_BATCH_FROM']            = $DATE1;
    $_SESSION['SETLMNT_BATCH_END']             = $DATE2;
    $_SESSION['AACA_RCVD_BATCH_FROM_TIMELINE'] = $DATE4;
    $_SESSION['AACA_RCVD_BATCH_END_TIMELINE']  = $DATE2;

    normalize_passexpdate_in_db($conn, $id, safe_array_value($row, 'Passexpdate'));

    $eulaQue    = "SELECT * FROM MANAGE_EULA WHERE UserId=" . $id;
    $eularesult = mysqli_query($conn, $eulaQue);
    $roweula    = $eularesult ? mysqli_fetch_array($eularesult) : [];

    $eulaStatus        = safe_array_value($roweula, 'EulaStatus', 0);
    $eulaDateStr       = parse_date_to_standard(safe_array_value($roweula, 'EulaDate'));
    $createdAtStr      = parse_date_to_standard(safe_array_value($roweula, 'createdAt'));
    $passexpStr        = parse_date_to_standard(safe_array_value($row, 'Passexpdate'));

    $currentDate       = strtotime(date('Y-m-d'));
    $logindatediff     = $eulaDateStr  ? (($currentDate - strtotime($eulaDateStr))  / 86400) : 0;
    $logindateyeardiff = $createdAtStr ? (($currentDate - strtotime($createdAtStr)) / 86400) : 0;
    $passexpday        = $passexpStr   ? (($currentDate - strtotime($passexpStr))   / 86400) : 0;

    $countQuery         = "SELECT count(1) as Check_multiple_status FROM tbl_login
                            WHERE bit_deleted_flag = 0
                              AND email = '" . mysqli_real_escape_string($conn, (string)$email) . "'";
    $rescountQuery      = mysqli_query($conn, $countQuery);
    $fetchrescountQuery = $rescountQuery ? mysqli_fetch_assoc($rescountQuery) : [];
    $multiLoginCount    = (int)safe_array_value($fetchrescountQuery, 'Check_multiple_status', 0);

    // Block login only when active_inactive_status = 0 (inactive/pending)
    if ($multiLoginCount >= 1 && (int)safe_array_value($row, 'active_inactive_status') == 0) {
        $_SESSION['login_error'] = 'Please authorise yourself';
        return false;
    }
    if ($passexpday >= 90 && $multiLoginCount >= 1) {
        header('Location: Passexp');
        exit();
    }
    if ($logindateyeardiff >= 366 && $multiLoginCount >= 1) {
        header('Location: EULA?val=1');
        exit();
    }
    if ($multiLoginCount >= 1 && $eulaStatus == 0) {
        header('Location: EULA');
        exit();
    }
    if ($multiLoginCount >= 1 && $eulaStatus == 1 && $logindatediff >= 90) {
        header('Location: EULA');
        exit();
    }
    if ($multiLoginCount >= 1 && $eulaStatus == 1 && $logindatediff < 90) {
        $date = date('Y-m-d H:i:s');
        mysqli_query($conn, "UPDATE MANAGE_EULA SET EulaDate='" . mysqli_real_escape_string($conn, $date) . "' WHERE UserId=" . $id);

        $safeFullName = trim((string)$fullName);
        $safeEmail    = trim((string)$email);
        $safeIp       = trim((string)$ipAddress);
        $safeAgent    = trim((string)$agent);
        $safeHost     = trim((string)$host_name);

        if ($safeFullName !== '' && $safeEmail !== '' && $safeIp !== '') {
            $qryloginDetails = "INSERT INTO logged_in_logs
                (`userName`,`emailId`,`ipAddress`,`browserDetails`,`LoggedinWith`)
                VALUES ('"
                . mysqli_real_escape_string($conn, $safeFullName) . "','"
                . mysqli_real_escape_string($conn, $safeEmail)    . "','"
                . mysqli_real_escape_string($conn, $safeIp)       . "','"
                . mysqli_real_escape_string($conn, $safeAgent)    . "','"
                . mysqli_real_escape_string($conn, $safeHost)     . "')";
            mysqli_query($conn, $qryloginDetails);
        }

        update_ip_history($conn, $id, safe_array_value($row, 'IPaddress', ''), $safeIp, 5);

        if ($multiLoginCount > 1) {
            $_SESSION['email'] = $email;
            header('Location: loginnew');
            exit();
        }
        if ((int)$_SESSION['role'] === 9) {
            header('Location: judgment_layout');
            exit();
        }
        if (isset($_SESSION['settlement_number'])) {
            header('Location: Settlement_Form/settlement-request');
            exit();
        }
        if (isset($_SESSION['urlloc'])) {
            header('Location: mydownload');
            exit();
        }
        header('Location: inventory_layout');
        exit();
    }
    return false;
}

/* ═══════════════════════════════════════════════════════════════════════════════
   DATE RANGES FOR SESSION
   ═══════════════════════════════════════════════════════════════════════════════ */

$months = [];
for ($i = 1; $i <= 36; $i++) {
    $months[] = date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
}
$DATE1 = $months[10];
$DATE2 = date('Y-m');
$DATE4 = $months[34];

/* ═══════════════════════════════════════════════════════════════════════════════
   MAIN FLOW VARIABLES
   ═══════════════════════════════════════════════════════════════════════════════ */

unset($_SESSION['count']);
$msg              = '';
$Emailmsg         = '';
$passwordmsg      = '';
$unauthuser       = '';
$unauthusermore   = '';

$showLoginForm       = true;
$showOtpForm         = false;
$showNewDeviceChoice = false;
$showRemoveDevice    = false;

$otpPendingName    = '';
$trustedDeviceList = [];
$nicknameMapForUI  = [];

/* ═══════════════════════════════════════════════════════════════════════════════
   STEP A — Resume after successful OTP
   ═══════════════════════════════════════════════════════════════════════════════ */

if (isset($_SESSION['otp_login_resume'], $_SESSION['otp_login_user_id'])
    && (int)$_SESSION['otp_login_resume'] === 1
) {
    $resumeUserId = (int)$_SESSION['otp_login_user_id'];
    $resumeRow    = fetch_login_row_by_id($conn, $resumeUserId);
    unset($_SESSION['otp_login_resume']);

    if (!empty($resumeRow)) {
        $agent     = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $ipAddress = $_SERVER['REMOTE_ADDR']     ?? '';
        $host_name = function_exists('gethostname') ? gethostname() : php_uname('n');
        if (!finalize_login_from_row($conn, $resumeRow, $agent, $ipAddress, $host_name, $DATE1, $DATE2, $DATE4)) {
            $passwordmsg = safe_array_value($_SESSION, 'login_error', '');
            unset($_SESSION['login_error']);
        }
    }
}

/* ═══════════════════════════════════════════════════════════════════════════════
   STEP B — OTP form submitted
   ═══════════════════════════════════════════════════════════════════════════════ */

if (isset($_POST['verify_otp'])) {
    $otpInput  = trim((string)safe_post_value('otp_code'));
    $otpUserId = (int)($_SESSION['otp_login_user_id'] ?? 0);

    if ($otpUserId > 0) {
        $otpRow = fetch_login_row_by_id($conn, $otpUserId);

        if (!empty($otpRow)) {
            $storedOtp       = trim((string)safe_array_value($otpRow, 'otp_code', ''));
            $otpCount        = (int)safe_array_value($otpRow, 'otp_count', 0);
            $otpCreatedAt    = parse_date_to_standard(safe_array_value($otpRow, 'otp_created_at', ''));
            $otpLimitReached = ($otpCount >= 5);

            if ($otpLimitReached) {
                $passwordmsg   = 'Too many OTP attempts. Please log in again to generate a new OTP.';
                $showLoginForm = true;
            } elseif ($otpCreatedAt !== null && (time() - strtotime($otpCreatedAt)) > 300) {
                $passwordmsg   = 'OTP expired. Please log in again to generate a new OTP.';
                $showLoginForm = true;
            } elseif ($otpInput !== '' && hash_equals((string)$storedOtp, (string)$otpInput)) {

                $trustChoice   = $_SESSION['otp_trust_choice'] ?? 'yes';
                $currentDevice = $_SESSION['otp_login_device'] ?? '';

                if ($trustChoice === 'yes' && $currentDevice !== '') {
                    // Add device to trusted list
                    update_device_history($conn, $otpUserId, safe_array_value($otpRow, 'device_ids', ''), $currentDevice, 5);

                    // FIX: Read nickname from session first; fall back to the hidden
                    // POST field carried through the OTP form if the session was lost.
                    $nicknameInput = trim((string)($_SESSION['otp_device_nickname'] ?? ''));
                    if ($nicknameInput === '') {
                        $nicknameInput = trim((string)safe_post_value('otp_device_nickname'));
                    }

                    if ($nicknameInput !== '') {
                        $nm = load_nickname_map($otpRow);
                        $nm[$currentDevice] = $nicknameInput;
                        save_nickname_map($conn, $otpUserId, $nm);
                    }
                }
                // If trust_choice === 'no': one-time access — device is NOT saved.

                clear_login_otp($conn, $otpUserId);
                unset(
                    $_SESSION['otp_trust_choice'],
                    $_SESSION['otp_device_nickname'],
                    $_SESSION['otp_login_pending']
                );

                $_SESSION['otp_login_resume'] = 1;
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();

            } else {
                // Wrong OTP — increment counter
                $sql  = "UPDATE tbl_login SET otp_count = otp_count + 1 WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'i', $otpUserId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                $passwordmsg    = 'Invalid OTP. Please try again.';
                $showLoginForm  = false;
                $showOtpForm    = true;
                $otpPendingName = htmlspecialchars((string)($_SESSION['otp_login_name'] ?? ''), ENT_QUOTES, 'UTF-8');
            }
        }
    }
}

/* ═══════════════════════════════════════════════════════════════════════════════
   STEP C — New-device trust choice submitted
   FIX: $nickname was previously undefined. It is now correctly read from POST
   using safe_post_value('device_nickname') before being stored in the session.
   ═══════════════════════════════════════════════════════════════════════════════ */

if (isset($_POST['device_trust_choice'])) {
    $choiceUserId = (int)($_SESSION['otp_login_user_id'] ?? 0);
    $trustChoice  = safe_post_value('trust_choice'); // 'yes' or 'no'
    $nickname     = safe_post_value('device_nickname'); // FIX: was undefined before

    if ($choiceUserId > 0 && in_array($trustChoice, ['yes', 'no'], true)) {
        $_SESSION['otp_trust_choice']    = $trustChoice;
        $_SESSION['otp_device_nickname'] = $nickname; // now correctly populated

        $choiceRow = fetch_login_row_by_id($conn, $choiceUserId);
        if (!empty($choiceRow)) {
            $otp = generate_login_otp();
            store_login_otp($conn, $choiceUserId, $otp);
            send_login_otp_notification(
                safe_array_value($choiceRow, 'email'),
                safe_array_value($choiceRow, 'fullName'),
                $otp
            );
        }

        $showLoginForm  = false;
        $showOtpForm    = true;
        $otpPendingName = htmlspecialchars((string)($_SESSION['otp_login_name'] ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

/* ═══════════════════════════════════════════════════════════════════════════════
   STEP D — Device removal submitted
   ═══════════════════════════════════════════════════════════════════════════════ */

if (isset($_POST['remove_device_submit'])) {
    $removeUserId = (int)($_SESSION['otp_login_user_id'] ?? 0);
    $fpToRemove   = safe_post_value('remove_fingerprint');

    if ($removeUserId > 0 && $fpToRemove !== '') {
        $removeRow   = fetch_login_row_by_id($conn, $removeUserId);
        $nicknameMap = load_nickname_map($removeRow);

        remove_device_from_history(
            $conn,
            $removeUserId,
            safe_array_value($removeRow, 'device_ids', ''),
            $fpToRemove,
            $nicknameMap
        );

        $showLoginForm       = false;
        $showNewDeviceChoice = true;
    }
}

/* ═══════════════════════════════════════════════════════════════════════════════
   STEP E — Main login form submitted
   ═══════════════════════════════════════════════════════════════════════════════ */

if (isset($_POST['but_submit'])) {
    $agent     = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ipAddress = $_SERVER['REMOTE_ADDR']     ?? '';
    $host_name = function_exists('gethostname') ? gethostname() : php_uname('n');

    $email = safe_post_value('txt_uname');
    $pass  = safe_post_value('txt_pwd');

    // Device fingerprint: JS collects browser UA + screen size + connection type.
    // PHP hashes the result with SHA-256. Falls back to server-side if JS is off.
    $jsFpRaw       = safe_post_value('device_fp_raw');
    $currentDevice = ($jsFpRaw !== '')
        ? build_device_fingerprint_from_js($jsFpRaw)
        : build_device_fingerprint_fallback($agent, $host_name, $ipAddress);

    $postemail        = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $password         = htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');
    $encrypted_string = md5($password);

    if ($postemail === '') { $Emailmsg    = "User id cannot be left blank"; }
    if ($password  === '') { $passwordmsg = "Password cannot be left blank"; }

    if ($postemail !== '' && $password !== '') {
        $escapedEmail = mysqli_real_escape_string($conn, $postemail);

        $sql_query = "SELECT * FROM tbl_login
                       WHERE email = '" . $escapedEmail . "'
                         AND bit_deleted_flag = 0
                         AND vchPassword != ''
                         AND company_status != 4
                       ORDER BY id DESC
                       LIMIT 1";

        $result = mysqli_query($conn, $sql_query);
        $row    = $result ? mysqli_fetch_assoc($result) : [];
        $count  = $row ? 1 : 0;

        $loginStatus            = safe_array_value($row, 'loginStatus');
        $userType               = safe_array_value($row, 'userType');
        $state                  = safe_array_value($row, 'state');
        $portfolioCode          = safe_array_value($row, 'portfolioCode');
        $role                   = safe_array_value($row, 'role');
        $role1                  = safe_array_value($row, 'role');
        $fullName               = safe_array_value($row, 'fullName');
        $email                  = safe_array_value($row, 'email');
        $userloginType          = safe_array_value($row, 'userloginType');
        $productCode            = safe_array_value($row, 'productCode');
        $firmCode               = safe_array_value($row, 'firmCode');
        $clientCode             = safe_array_value($row, 'clientCode');
        $companyId              = safe_array_value($row, 'companyId');
        $companyStatus          = (int)safe_array_value($row, 'company_status', 0);
        $LastName               = safe_array_value($row, 'LastName');
        $passwordDB             = safe_array_value($row, 'vchPassword');
        $id                     = safe_array_value($row, 'id');
        $storedIPList           = normalize_csv_values(safe_array_value($row, 'IPaddress'));
        $AuthorisedFlag         = safe_array_value($row, 'AuthorisedFlag');
        $active_inactive_status = safe_array_value($row, 'active_inactive_status');

        $_SESSION['id'] = $id;

        if ($role == 6 || $role == 10) {
            $role = 6;
        }

        if ($count === 0) {
            $msg = "Invalid userid or password";
        } elseif (strtolower($postemail) !== strtolower($email)) {
            $Emailmsg = "Invalid userid";
        } elseif (
            !hash_equals((string)$passwordDB, (string)$encrypted_string) &&
            !password_verify($pass, (string)$passwordDB)
        ) {
            $passwordmsg = "Invalid Password";
        } else {
            // User status: manage_user registry is authoritative; fallback to AuthorisedFlag
            $userIsActive = is_user_active_in_registry($conn, $id);
            if ($userIsActive === null) {
                $userIsActive = ((int)$AuthorisedFlag === 1);
            }

            // Company status: manage_company_registry is authoritative; fallback to company_status
            $companyIsActive = is_company_active($conn, $companyId);
            if ($companyIsActive === null) {
                $companyIsActive = ($companyStatus === 1);
            }

            if (!$userIsActive) {
                $passwordmsg = "Your account is not active. Please contact your administrator.";
            } elseif (!$companyIsActive) {
                $passwordmsg = "Company is inactive or terminated.";
            }

            if ($passwordmsg === '') {
                $trustedDevices = normalize_csv_values(safe_array_value($row, 'device_ids', ''));

                if (in_array($currentDevice, $trustedDevices, true)) {
                    // Known trusted device — go straight to login
                    $_SESSION['otp_login_device'] = $currentDevice;
                    if (!finalize_login_from_row($conn, $row, $agent, $ipAddress, $host_name, $DATE1, $DATE2, $DATE4)) {
                        $passwordmsg = safe_array_value($_SESSION, 'login_error', '');
                        unset($_SESSION['login_error']);
                    }

                } elseif (count($trustedDevices) >= 5) {
                    // Device list full — show remove-one panel
                    $showLoginForm    = false;
                    $showRemoveDevice = true;

                    $nicknameMapForUI = load_nickname_map($row);
                    $idx = 1;
                    foreach ($trustedDevices as $fp) {
                        $trustedDeviceList[] = [
                            'fingerprint' => $fp,
                            'label'       => get_device_label($fp, $idx, $nicknameMapForUI),
                        ];
                        $idx++;
                    }

                    $_SESSION['otp_login_user_id']      = $id;
                    $_SESSION['otp_login_device']       = $currentDevice;
                    $_SESSION['otp_login_email']        = $email;
                    $_SESSION['otp_login_name']         = $fullName;
                    $_SESSION['otp_login_requested_at'] = date('Y-m-d H:i:s');

                } else {
                    // New device with slots available — ask trust or one-time
                    $showLoginForm       = false;
                    $showNewDeviceChoice = true;

                    $_SESSION['otp_login_user_id']      = $id;
                    $_SESSION['otp_login_device']       = $currentDevice;
                    $_SESSION['otp_login_email']        = $email;
                    $_SESSION['otp_login_name']         = $fullName;
                    $_SESSION['otp_login_requested_at'] = date('Y-m-d H:i:s');
                }
            }
        }
    }
}

/* ═══════════════════════════════════════════════════════════════════════════════
   Restore panel state on page reload
   ═══════════════════════════════════════════════════════════════════════════════ */

if (!$showOtpForm && !$showNewDeviceChoice && !$showRemoveDevice) {
    if (isset($_SESSION['otp_login_pending']) && (int)$_SESSION['otp_login_pending'] === 1) {
        $showLoginForm  = false;
        $showOtpForm    = true;
        $otpPendingName = htmlspecialchars((string)($_SESSION['otp_login_name'] ?? ''), ENT_QUOTES, 'UTF-8');
    }
    if (isset($_GET['otp']) && (int)$_GET['otp'] === 1) {
        $showLoginForm  = false;
        $showOtpForm    = true;
        $otpPendingName = htmlspecialchars((string)($_SESSION['otp_login_name'] ?? ''), ENT_QUOTES, 'UTF-8');
    }
}
?>

<!-- ═══════════════════════════════════════════════════════════════════════════
     HTML OUTPUT
     ═══════════════════════════════════════════════════════════════════════════ -->

<div class="wrapper-login fadeInDown login-section" id="warning-message1">
  <div id="formContent" class="modal-dialog">
    <div class="formHeader clearfix">

      <div class="col-sm-12 mar20B">
        <div class="logo-row fadeIn first">
          <img src="img/aaca-net.png" class="aacanet-logo" alt="AACANet logo" />
          <img src="img/pipeway-logo.gif" class="pipeway-logo" alt="Pipeway logo" />
        </div>
      </div>

      <div class="col-sm-12">

        <?php if ($msg !== '') : ?>
          <p style="color:red;font-size:12px;text-align:center;"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <!-- PANEL 1 — Standard login form -->
        <?php if ($showLoginForm) : ?>
        <form action="" id="loginForm" method="post" autocomplete="off">
          <input type="hidden" id="device_fp_raw" name="device_fp_raw" value="">

          <span style="color:red"><?php echo $unauthuser; ?></span>
          <span style="color:red"><?php echo $unauthusermore; ?></span>

          <div class="form-group clearfix">
            <div class="input-group fadeIn second user">
              <span class="input-group-addon" style="background-color:rgba(0,0,0,0);border-bottom:0;color:#012f5c;transition:all .5s ease;border-radius:10px;">
                <i class="fa fa-user" aria-hidden="true"></i>
              </span>
              <span class="clearable">
                <input type="text" class="bor" id="email" name="txt_uname"
                       placeholder="User name" maxlength="50" autofocus
                       value="<?php echo isset($_POST['txt_uname']) ? htmlspecialchars($_POST['txt_uname'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                <i class="clearable__clear" style="display:inline;">&times;</i>
              </span>
            </div>
            <span style="color:red;font-size:11px;margin-left:45px;"><?php echo $Emailmsg; ?></span>
          </div>

          <div class="form-group clearfix">
            <div class="input-group fadeIn third user">
              <span class="input-group-addon" style="background-color:rgba(0,0,0,0);border-bottom:0;color:#012f5c;transition:all .5s ease;border-radius:10px;">
                <i class="fa fa-lock" aria-hidden="true"></i>
              </span>
              <span class="clearable">
                <input type="password" class="bor" id="password" name="txt_pwd"
                       placeholder="Password" maxlength="20">
                <i class="clearable__clear" style="display:inline;">&times;</i>
              </span>
            </div>
            <p style="color:red;font-size:11px;margin-left:45px;margin-bottom:0;"><?php echo $passwordmsg; ?></p>
            <?php if ($Emailmsg !== '' || $passwordmsg !== '') : ?>
            <p style="color:#607D8B;font-size:11px;width:100%;margin-left:8px;margin-top:5px;">
              Please enter your user name and password. If you do not have credentials, contact your
              company's Pipeway Administrator. For forgotten details, use the link below.
            </p>
            <?php endif; ?>
          </div>

          <div class="form-group clearfix">
            <button type="submit" class="fadeIn fourth f_wid" name="but_submit" id="but_submit"
                    style="border-radius:15px;background:#002e5b;">
              <i class="fa fa-key" aria-hidden="true"></i> Log In
            </button>
          </div>
          <div class="col-md-12" style="text-align:center;">
            <a class="underlineHover fadeIn fourth" href="forgotpassword">Forgot Password?</a>
          </div>
        </form>
        <?php endif; ?>

        <!-- PANEL 2 — New device trust choice -->
        <?php if ($showNewDeviceChoice) : ?>
        <div class="device-panel">
          <h5><i class="fa fa-laptop" aria-hidden="true"></i>&nbsp; New Device Detected</h5>
          <p>
            We have not seen this device before.<br>
            Would you like to add it to your trusted device list?<br>
            <small>If you choose <strong>No</strong>, you will receive a one-time OTP for this session only and the device will not be saved.</small>
          </p>

          <form action="" method="post" id="deviceChoiceYesForm">
            <input type="hidden" name="device_trust_choice" value="1">
            <input type="hidden" name="trust_choice" value="yes">
            <label for="device_nickname" style="font-size:12px;color:#002e5b;font-weight:600;">
              Give this device a nickname (optional):
            </label>
            <input type="text" id="device_nickname" name="device_nickname"
                   class="device-nickname-input"
                   placeholder="e.g. Office PC, My Laptop"
                   maxlength="60">
            <button type="submit" class="device-choice-btn btn-primary-solid">
              <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; Yes — add this device &amp; send OTP
            </button>
          </form>

          <form action="" method="post" style="margin-top:4px;">
            <input type="hidden" name="device_trust_choice" value="1">
            <input type="hidden" name="trust_choice" value="no">
            <input type="hidden" name="device_nickname" value="">
            <button type="submit" class="device-choice-btn">
              <i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp; No — one-time access only
            </button>
          </form>
        </div>
        <?php endif; ?>

        <!-- PANEL 3 — Device limit reached: remove one -->
        <?php if ($showRemoveDevice) : ?>
        <div class="device-panel">
          <h5><i class="fa fa-shield" aria-hidden="true"></i>&nbsp; Trusted Device Limit Reached</h5>
          <p>
            You already have <strong>5 trusted devices</strong>.<br>
            Please remove one device from the list below to add this new device.
          </p>

          <form action="" method="post" id="removeDeviceForm">
            <input type="hidden" name="remove_device_submit" value="1">

            <?php foreach ($trustedDeviceList as $dv) : ?>
            <div class="device-list-item">
              <input type="radio" name="remove_fingerprint"
                     id="dev_<?php echo htmlspecialchars($dv['fingerprint'], ENT_QUOTES, 'UTF-8'); ?>"
                     value="<?php echo htmlspecialchars($dv['fingerprint'], ENT_QUOTES, 'UTF-8'); ?>">
              <label for="dev_<?php echo htmlspecialchars($dv['fingerprint'], ENT_QUOTES, 'UTF-8'); ?>">
                <i class="fa fa-laptop" aria-hidden="true"></i>&nbsp;
                <?php echo $dv['label']; ?>
              </label>
            </div>
            <?php endforeach; ?>

            <p style="font-size:11px;color:#e53935;margin-top:8px;margin-bottom:10px;">
              * The selected device will be removed from your trusted list immediately.
            </p>
            <button type="submit" class="device-choice-btn btn-primary-solid"
                    onclick="if(!document.querySelector('input[name=remove_fingerprint]:checked')){alert('Please select a device to remove.');return false;}">
              <i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Remove selected &amp; continue
            </button>
          </form>
        </div>
        <?php endif; ?>

        <!-- PANEL 4 — OTP entry -->
        <?php if ($showOtpForm) : ?>
        <div class="device-panel">
          <h5><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp; Enter Your OTP</h5>
          <p>
            An OTP has been sent to your registered email address<?php echo $otpPendingName !== '' ? ' (<strong>' . $otpPendingName . '</strong>)' : ''; ?>.<br>
            <small>The OTP is valid for <strong>5 minutes</strong>. You have a maximum of 5 attempts.</small>
          </p>

          <?php if ($passwordmsg !== '') : ?>
          <p style="color:red;font-size:12px;"><?php echo htmlspecialchars($passwordmsg, ENT_QUOTES, 'UTF-8'); ?></p>
          <?php endif; ?>

          <form action="" method="post" id="otpForm">
            <input type="hidden" name="verify_otp" value="1">
            <!--
              Carries the nickname through the OTP POST as a fallback in case
              the session value was lost between Step C and Step B.
            -->
            <input type="hidden" name="otp_device_nickname"
                   value="<?php echo htmlspecialchars((string)($_SESSION['otp_device_nickname'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
              <input type="text" name="otp_code" class="otp-input-box"
                     placeholder="_ _ _ _ _ _"
                     maxlength="6" autocomplete="one-time-code"
                     inputmode="numeric" pattern="[0-9]{6}"
                     required autofocus>
            </div>
            <button type="submit" class="device-choice-btn btn-primary-solid" style="margin-top:6px;">
              <i class="fa fa-unlock-alt" aria-hidden="true"></i>&nbsp; Verify OTP
            </button>
          </form>

          <div style="margin-top:10px;text-align:center;">
            <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>"
               style="font-size:12px;color:#002e5b;">
              &larr; Back to login
            </a>
          </div>
        </div>
        <?php endif; ?>

      </div><!-- /.col-sm-12 -->
    </div><!-- /.formHeader -->
  </div><!-- /#formContent -->
</div><!-- /.wrapper-login -->

</body>

<script type="text/javascript">
/* Device fingerprint: collects browser UA + screen size + connection type
   and POSTs it in the hidden field "device_fp_raw" for PHP to hash. */
(function () {
    function buildDeviceFpRaw() {
        var ua         = (navigator.userAgent || '').toLowerCase().trim();
        var screen_dim = screen.width + 'x' + screen.height;
        var connection = 'unknown';
        if (navigator.connection && navigator.connection.effectiveType) {
            connection = navigator.connection.effectiveType;
        }
        return ua + '|' + screen_dim + '|' + connection;
    }

    var fpField = document.getElementById('device_fp_raw');
    if (fpField) {
        fpField.value = buildDeviceFpRaw();
    }

    var loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function () {
            var field = document.getElementById('device_fp_raw');
            if (field) {
                field.value = buildDeviceFpRaw();
            }
        });
    }
})();

/* Enter key submits login form */
$("#password").keypress(function (event) {
    if (event.keyCode === 13) {
        $("#but_submit").click();
    }
});

$(document).ready(function () {
    $(".clearable").each(function () {
        var $inp = $(this).find("input:text, input[type=password]"),
            $cle = $(this).find(".clearable__clear");
        $inp.on("input", function () {
            $cle.toggle(!!this.value);
        });
        $cle.on("touchstart click", function (e) {
            e.preventDefault();
            $inp.val("").trigger("input");
        });
    });
});

var auth = <?php echo json_encode($unauthuser); ?>;
if (auth !== '') {
    var email = <?php echo json_encode(isset($_POST['txt_uname']) ? $_POST['txt_uname'] : ''); ?>;
    $.ajax({ type: "GET", url: "authenticate.php", data: { email: email }, success: function () {} });
}
</script>

<?php
if (isset($_SESSION['forgototp'])) { ?>
  <script>swal({title:"",text:"OTP has been sent to your email id",timer:3000,showConfirmButton:false,type:'success'});</script>
<?php } unset($_SESSION['forgototp']);

if (isset($_SESSION['resetforgotpass'])) { ?>
  <script>swal({title:"",text:"Password created successfully",timer:3000,showConfirmButton:false,type:'success'});</script>
<?php } unset($_SESSION['resetforgotpass']);

if (isset($_SESSION['authenticate'])) { ?>
  <script>swal({title:"",text:"User authenticated successfully",timer:3000,showConfirmButton:false,type:'success'});</script>
<?php } unset($_SESSION['authenticate']);

if (isset($_SESSION['changepass'])) {
    unset($_SESSION['email']); ?>
  <script>swal({title:"",text:"Password changed successfully",timer:3000,showConfirmButton:false,type:'success'});</script>
<?php } unset($_SESSION['changepass']);

if (isset($_SESSION['role']) && $_SESSION['role'] == 9) {
    header('Location: judgment_layout');
} else {
    if (isset($_SESSION['settlement_number'])) {
        header('Location: Settlement_Form/settlement-request');
    } else {
        header('Location: inventory_layout');
    }
}
?>

</html>