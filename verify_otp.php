<?php
ob_start();
error_reporting(1);
include_once "config.php";
session_start();

// Check if user is in OTP verification mode
if (!isset($_SESSION['otp_login_user_id']) || !isset($_SESSION['otp_login_pending'])) {
    header('Location: Login_KNT.php');
    exit();
}

$otpPendingName = htmlspecialchars($_SESSION['otp_login_name'] ?? '', ENT_QUOTES, 'UTF-8');
$passwordmsg = '';

if (isset($_POST['verify_otp'])) {
    $otpInput = trim($_POST['otp_code'] ?? '');
    $otpUserId = $_SESSION['otp_login_user_id'];

    if ($otpUserId > 0) {
        $otpRow = fetch_login_row_by_id($conn, $otpUserId);

        if (!empty($otpRow)) {
            $storedOtp = trim($otpRow['otp_code'] ?? '');
            $otpCount = (int)($otpRow['otp_count'] ?? 0);
            $otpCreatedAt = parse_date_to_standard($otpRow['otp_created_at'] ?? '');

            if ($otpCount >= 5) {
                $passwordmsg = 'Too many OTP attempts. Please log in again to generate a new OTP.';
            } elseif ($otpCreatedAt !== null && (time() - strtotime($otpCreatedAt)) > 300) {
                $passwordmsg = 'OTP expired. Please log in again to generate a new OTP.';
            } elseif ($otpInput !== '' && hash_equals($storedOtp, $otpInput)) {
                // OTP correct — proceed with device trust logic
                $trustChoice = $_SESSION['otp_trust_choice'] ?? 'yes';
                $currentDevice = $_SESSION['otp_login_device'] ?? '';
                $nicknameInput = trim($_SESSION['otp_device_nickname'] ?? '');

                if ($trustChoice === 'yes' && $currentDevice !== '') {
                    update_device_history($conn, $otpUserId, $otpRow['device_ids'] ?? '', $currentDevice, 5);
                    if ($nicknameInput !== '') {
                        $nm = load_nickname_map($otpRow);
                        $nm[$currentDevice] = $nicknameInput;
                        save_nickname_map($conn, $otpUserId, $nm);
                    }
                }

                clear_login_otp($conn, $otpUserId);
                unset($_SESSION['otp_trust_choice'], $_SESSION['otp_device_nickname'], $_SESSION['otp_login_pending']);

                $_SESSION['otp_login_resume'] = 1;
                header('Location: Login_KNT.php');
                exit();
            } else {
                $sql = "UPDATE tbl_login SET otp_count = otp_count + 1 WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'i', $otpUserId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                $passwordmsg = 'Invalid OTP. Please try again.';
            }
        }
    }
}

// Helper functions (copied from Login_KNT.php for simplicity)
function safe_post_value($key, $default = '') {
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

function safe_array_value($array, $key, $default = '') {
    return (is_array($array) && array_key_exists($key, $array)) ? $array[$key] : $default;
}

function fetch_login_row_by_id($conn, $userId) {
    $sql = "SELECT * FROM tbl_login WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return [];
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : [];
    mysqli_stmt_close($stmt);
    return $row ?: [];
}

function parse_date_to_standard($value) {
    $value = trim((string)$value);
    if ($value === '') return null;
    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $value);
    if ($dt instanceof DateTime) return $dt->format('Y-m-d H:i:s');
    $dt = DateTime::createFromFormat('Y-m-d', $value);
    if ($dt instanceof DateTime) return $dt->format('Y-m-d') . ' 00:00:00';
    return null;
}

function update_device_history($conn, $userId, $existingCsv, $currentDevice, $maxItems = 5) {
    $currentDevice = trim((string)$currentDevice);
    if ($currentDevice === '') return;
    $list = normalize_csv_values($existingCsv);
    if (!in_array($currentDevice, $list, true)) $list[] = $currentDevice;
    $list = array_values(array_unique(array_filter($list, fn($v) => trim((string)$v) !== '')));
    if (count($list) > $maxItems) $list = array_slice($list, -$maxItems);
    $newCsv = implode(',', $list);
    if ($newCsv === implode(',', normalize_csv_values($existingCsv))) return;
    $sql = "UPDATE tbl_login SET device_ids = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return;
    mysqli_stmt_bind_param($stmt, 'si', $newCsv, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function normalize_csv_values($value) {
    $value = trim((string)$value);
    if ($value === '') return [];
    $clean = [];
    foreach (explode(',', $value) as $part) {
        $part = trim($part);
        if ($part !== '' && !in_array($part, $clean, true)) $clean[] = $part;
    }
    return $clean;
}

function load_nickname_map($row) {
    $raw = safe_array_value($row, 'device_nicknames', '');
    if ($raw === '') return [];
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

function save_nickname_map($conn, $userId, $nicknameMap) {
    $json = json_encode($nicknameMap, JSON_UNESCAPED_UNICODE);
    $sql = "UPDATE tbl_login SET device_nicknames = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return;
    mysqli_stmt_bind_param($stmt, 'si', $json, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function clear_login_otp($conn, $userId) {
    $sql = "UPDATE tbl_login SET otp_code = NULL, otp_count = 0, otp_created_at = NULL WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AACANet | Verify OTP</title>
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
    .device-panel {
        background: #fff;
        border: 2px solid #002e5b;
        border-radius: 12px;
        padding: 18px 20px;
        margin-top: 10px;
        max-width: 400px;
        margin: 50px auto;
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
    .device-choice-btn {
        display: block;
        width: 100%;
        padding: 9px 14px;
        margin-bottom: 8px;
        border-radius: 8px;
        border: 2px solid #002e5b;
        background: #002e5b;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        transition: background 0.2s, color 0.2s;
    }
    .device-choice-btn:hover { background: #001f42; }
  </style>
</head>

<body class="hold-transition skin-yellow sidebar-mini" style="background-color: rgba(0,0,0,0);">
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
    <div class="form-group">
      <input type="text" name="otp_code" class="otp-input-box"
             placeholder="_ _ _ _ _ _"
             maxlength="6" autocomplete="one-time-code"
             inputmode="numeric" pattern="[0-9]{6}"
             required autofocus>
    </div>
    <button type="submit" class="device-choice-btn">
      <i class="fa fa-unlock-alt" aria-hidden="true"></i>&nbsp; Verify OTP
    </button>
  </form>

  <div style="margin-top:10px;text-align:center;">
    <a href="Login_KNT.php" style="font-size:12px;color:#002e5b;">
      &larr; Back to login
    </a>
  </div>
</div>

<script>
$("#otpForm").submit(function(e) {
    var otp = $("input[name=otp_code]").val();
    if (otp.length !== 6 || !/^\d{6}$/.test(otp)) {
        alert("Please enter a valid 6-digit OTP.");
        e.preventDefault();
        return false;
    }
});
</script>

<?php ob_end_flush(); ?>
</body>
</html>