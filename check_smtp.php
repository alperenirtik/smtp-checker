<?php
header('Content-Type: application/json');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Get POST data
$host = $_POST['host'] ?? '';
$port = $_POST['port'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$encryption = $_POST['encryption'] ?? 'tls';
$fromEmail = $_POST['fromEmail'] ?? '';
$toEmail = $_POST['toEmail'] ?? '';

// Initialize logs array
$logs = [];
$logs[] = "SMTP Bağlantı Testi Başlatılıyor...";
$logs[] = "Sunucu: $host:$port";
$logs[] = "Güvenlik: " . strtoupper($encryption);

// Validate input
if (empty($host) || empty($port) || empty($username) || empty($password) || empty($fromEmail) || empty($toEmail)) {
    echo json_encode([
        'success' => false,
        'message' => 'Lütfen tüm alanları doldurun',
        'logs' => implode("\n", $logs)
    ]);
    exit;
}

try {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    // Enable SMTP debugging
    $mail->SMTPDebug = SMTP::DEBUG_CLIENT;
    
    // Capture SMTP debug output
    $debugOutput = '';
    $mail->Debugoutput = function($str, $level) use (&$debugOutput, &$logs) {
        $debugOutput .= $str . "\n";
        $logs[] = trim(strip_tags($str));
    };

    // Server settings
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->Port = $port;
    $mail->SMTPAuth = true;
    $mail->Username = $username;
    $mail->Password = $password;
    
    // Set encryption
    switch ($encryption) {
        case 'tls':
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            break;
        case 'ssl':
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            break;
        default:
            $mail->SMTPSecure = '';
    }

    // Set timeout
    $mail->Timeout = 30;
    
    // Recipients
    $mail->setFrom($fromEmail);
    $mail->addAddress($toEmail);
    
    // Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'SMTP Test Mesajı';
    $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #4F46E5;">SMTP Bağlantı Testi</h2>
            <p style="color: #374151;">Bu bir SMTP test mesajıdır.</p>
            <div style="background-color: #F3F4F6; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 5px 0;"><strong>Sunucu:</strong> ' . htmlspecialchars($host) . ':' . htmlspecialchars($port) . '</p>
                <p style="margin: 5px 0;"><strong>Güvenlik:</strong> ' . strtoupper(htmlspecialchars($encryption)) . '</p>
                <p style="margin: 5px 0;"><strong>Tarih:</strong> ' . date('Y-m-d H:i:s') . '</p>
            </div>
            <p style="color: #059669; font-weight: bold;">✓ Bağlantı başarıyla test edildi!</p>
        </div>
    ';
    $mail->AltBody = "SMTP Test Mesajı\n\n" .
                     "Bu bir SMTP test mesajıdır.\n" .
                     "Sunucu: $host:$port\n" .
                     "Güvenlik: " . strtoupper($encryption) . "\n" .
                     "Tarih: " . date('Y-m-d H:i:s');

    // Send email
    $logs[] = "Test e-postası gönderiliyor...";
    $mail->send();
    $logs[] = "Test e-postası başarıyla gönderildi!";

    echo json_encode([
        'success' => true,
        'message' => 'SMTP bağlantısı başarılı! Test e-postası gönderildi.',
        'logs' => implode("\n", $logs)
    ]);

} catch (Exception $e) {
    $logs[] = "Hata: " . $mail->ErrorInfo;
    
    echo json_encode([
        'success' => false,
        'message' => 'SMTP Hatası: ' . $e->getMessage(),
        'logs' => implode("\n", $logs)
    ]);
}
