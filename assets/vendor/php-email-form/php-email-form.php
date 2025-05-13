<?php
class PHP_Email_Form {
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $ajax = false;
    private $messages = [];

    public function add_message($content, $label, $min_length = 0) {
        if (strlen(trim($content)) >= $min_length) {
            $this->messages[] = "$label: $content";
        }
    }

    public function send() {
        $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
        $headers .= "Reply-To: {$this->from_email}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body = implode("\n", $this->messages);

        if (mail($this->to, $this->subject, $body, $headers)) {
            return $this->ajax ? 'OK' : 'Message sent!';
        } else {
            http_response_code(500);
            return $this->ajax ? 'Error sending email.' : 'Error sending email.';
        }
    }
}
?>