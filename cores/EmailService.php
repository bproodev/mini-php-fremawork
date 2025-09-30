<?php

namespace Core;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
    
class EmailService {

    private $mail;
    private $logger;
    private $db;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV['SMTP_HOST'] ?? 'sandbox.smtp.mailtrap.io';
        $this->mail->SMTPAuth = $_ENV['SMTP_AUTH'] ?? true;
        $this->mail->Username = $_ENV['SMTP_USERNAME'] ?? 'f21891a86e5e3f';
        $this->mail->Password = $_ENV['SMTP_PASSWORD'] ?? 'a1c7e23a400e33';
        $this->mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = $_ENV['SMTP_PORT'] ?? 587;
        $this->logger = $GLOBALS['logger'];
        $this->db = Database::getInstance();
    }

    public function sendEmail($to, $subject, $body, $altBody = ''): bool {
        try {
            //Server settings
            $this->mail->isSMTP();
            $this->mail->Host = $this->mail->Host;
            $this->mail->SMTPAuth = $this->mail->SMTPAuth;
            $this->mail->Username = $this->mail->Username;
            $this->mail->Password = $this->mail->Password;
            $this->mail->SMTPSecure = $this->mail->SMTPSecure;
            $this->mail->Port = $this->mail->Port;

            //Recipients
            $this->mail->setFrom($_ENV['SMTP_FROM'] ?? 'from@example.com', $_ENV['APP_NAME'] ?? 'Mailer');
            $this->mail->addAddress($to);

            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            $this->logger->log("Erreur lors de l'envoi de l'email: {$this->mail->ErrorInfo}", "ERROR");
            return false;
        }
    }

    public function enqueueEmail($to, $subject, $body): bool {
        $sql = "INSERT INTO `email_queue` (to_address, subject, body) VALUES (:to_address, :subject, :body)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':to_address' => $to,
            ':subject' => $subject,
            ':body' => $body
        ]);
        $this->logger->log("Email to $to queued for sending.", "INFO");
        return true;
    }
}