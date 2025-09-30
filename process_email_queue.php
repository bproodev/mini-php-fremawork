<?php

require __DIR__ . '/vendor/autoload.php'; // if using Composer

use Core\Database;
use Core\EmailService;
use Core\Logger;
$logger = new Logger();

$db = Database::getInstance();
$emailService = new EmailService();


$sql = "SELECT * FROM email_queue WHERE status = 'pending' ORDER BY created_at ASC LIMIT 10";
$stmt  = $db->query($sql);
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($emails as $email){
    try {
        $emailService->sendEmail($email['to_address'], $email['subject'], $email['body'], $altBody = '');

        $updateSql = "UPDATE email_queue SET status = 'sent', sent_at = NOW() WHERE id = ?";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->execute([$email['id']]);

        $logger->log("Email envoye avec success", "INFO");
    } catch (\Throwable $th) {
        $updateSql = "UPDATE email_queue SET status = 'failed' WHERE id = ?";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->execute([$email['id']]);
        $logger->log("Erreur d'envoi d'email: {$emailService->ErrorInfo}");
    }
}