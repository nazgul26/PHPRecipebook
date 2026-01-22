<?php
declare(strict_types=1);

namespace App\Mailer\Transport;

use Cake\Mailer\AbstractTransport;
use Cake\Mailer\Message;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * PHPMailer transport for CakePHP Mailer.
 *
 * Uses PHPMailer library to send emails while integrating with
 * CakePHP's Mailer system and ViewBuilder templates.
 */
class PhpMailerTransport extends AbstractTransport
{
    /**
     * Default config for this class
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'host' => 'localhost',
        'port' => 587,
        'timeout' => 30,
        'username' => null,
        'password' => null,
        'tls' => true,
    ];

    /**
     * Send mail using PHPMailer
     *
     * @param \Cake\Mailer\Message $message Email message.
     * @return array<string, mixed> Contains 'headers' and 'message' keys.
     * @throws \PHPMailer\PHPMailer\Exception On mail sending failure.
     */
    public function send(Message $message): array
    {
        $this->checkRecipient($message);

        $config = $this->getConfig();

        // Parse URL if provided
        if (!empty($config['url'])) {
            $config = array_merge($config, $this->parseSmtpUrl($config['url']));
        }

        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->Port = (int)$config['port'];
        $mail->Timeout = (int)($config['timeout'] ?? 30);

        if (!empty($config['username']) && !empty($config['password'])) {
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
        }

        // Use SMTPS (implicit TLS) for port 465, STARTTLS for other ports
        if ($config['port'] == 465) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } elseif (!empty($config['tls'])) {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }

        // Set sender
        $from = $message->getFrom();
        foreach ($from as $email => $name) {
            $mail->setFrom($email, $name ?: '');
            break; // Only one from address
        }

        // Set reply-to
        $replyTo = $message->getReplyTo();
        foreach ($replyTo as $email => $name) {
            $mail->addReplyTo($email, $name ?: '');
        }

        // Set recipients
        foreach ($message->getTo() as $email => $name) {
            $mail->addAddress($email, $name ?: '');
        }

        foreach ($message->getCc() as $email => $name) {
            $mail->addCC($email, $name ?: '');
        }

        foreach ($message->getBcc() as $email => $name) {
            $mail->addBCC($email, $name ?: '');
        }

        // Set subject
        $mail->Subject = $message->getSubject() ?? '';

        // Set content based on email format
        $bodyHtml = $message->getBodyHtml();
        $bodyText = $message->getBodyText();

        if ($bodyHtml) {
            $mail->isHTML(true);
            $mail->Body = $bodyHtml;
            if ($bodyText) {
                $mail->AltBody = $bodyText;
            }
        } elseif ($bodyText) {
            $mail->isHTML(false);
            $mail->Body = $bodyText;
        }

        // Handle attachments
        foreach ($message->getAttachments() as $filename => $attachment) {
            if (isset($attachment['file'])) {
                $mail->addAttachment(
                    $attachment['file'],
                    $filename,
                    PHPMailer::ENCODING_BASE64,
                    $attachment['mimetype'] ?? ''
                );
            } elseif (isset($attachment['data'])) {
                $mail->addStringAttachment(
                    $attachment['data'],
                    $filename,
                    PHPMailer::ENCODING_BASE64,
                    $attachment['mimetype'] ?? ''
                );
            }
        }

        $mail->send();

        // Return headers and message for logging
        $headers = $message->getHeadersString([
            'from',
            'sender',
            'replyTo',
            'to',
            'cc',
            'subject',
        ]);

        return [
            'headers' => $headers,
            'message' => $bodyHtml ?: $bodyText ?: '',
        ];
    }

    /**
     * Parse SMTP URL into configuration array.
     *
     * @param string $url The SMTP URL (e.g., smtp://user:pass@host:port).
     * @return array Configuration array with host, port, username, password.
     */
    protected function parseSmtpUrl(string $url): array
    {
        $parsed = parse_url($url);

        return [
            'host' => $parsed['host'] ?? 'localhost',
            'port' => $parsed['port'] ?? 587,
            'username' => isset($parsed['user']) ? urldecode($parsed['user']) : null,
            'password' => isset($parsed['pass']) ? urldecode($parsed['pass']) : null,
        ];
    }
}
