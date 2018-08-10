<?php 
// error_reporting(0); 
define("EOL", "\r\n");  
//define("SMTP_HOST", "smtp.sina.com.cn");//SMTP服务器  
define("SMTP_PORT", "25");//SMTP服务器端口  
define("SMTP_USER", "2283609260@qq.com");//SMTP服务器的用户帐号  
define("SMTP_PASS", "510297116yx");//SMTP服务器的用户密码  
  
define("LOG", "./mail.log");  
  
$from = "2283609260@qq.com";//SMTP服务器的用户邮箱  
$to = "1315752027@qq.com";//发送给谁 可用逗号隔开多个邮箱  
$cc = "eqeqwe";  
$bcc = "wewe";  
$attachment="4069.doc";//附件目录  
$subject="每日汇总";//邮件主题 很多客户端会有乱码，所以转一下码  
$body = "现为系统自动发送邮件，详情见附件！,若有问题请及时联系";//邮件内容  
$smtp = new smtp(SMTP_HOST,SMTP_PORT,SMTP_USER,SMTP_PASS, true);//这里面的一个true是表示使用身份验证,否则不使用身份验证.  
$smtp->addAttachment($attachment);  
$smtp->sendmail($to, $from, $subject, $body, $cc, $bcc);  
  
  
class smtp {  
  
    /* Public Variables */  
    public $attachments = array();  
    /* Private Variables */  
    private $smtp_host;  
    private $smtp_port;  
    private $time_out;  
    private $host_name;  
    private $auth;  
    private $user;  
    private $pass;  
    private $sock;  
  
    /* Constractor */  
    public function smtp($smtp_host = null, $smtp_port = null, $user = null, $pass = null, $auth = true) {  
        $this->smtp_host = (!empty($smtp_host)) ? $smtp_host : SMTP_HOST;  
        $this->smtp_port = (!empty($smtp_port)) ? $smtp_port : SMTP_PORT;  
        $this->user = (!empty($user)) ? $user : SMTP_PORT;  
        $this->pass = (!empty($pass)) ? $pass : SMTP_PORT;  
        $this->auth = $auth;  
        $this->time_out = 15;  
        #  
        $this->host_name = "localhost";  
        $this->sock = FALSE;  
    }  
  
    /* Main Function */  
    public function sendmail($to, $from, $subject = "", $body = "", $cc = "", $bcc = "") {  
        $bndp = md5(uniqid("")) . rand(1000, 9999);  
        $bnd  = md5(uniqid("")) . rand(1000, 9999);  
        list ($msec, $sec) = explode(" ", microtime());  
  
        $mail_from = $this->strip_line_breaks($from);  
        $mail_to = explode(",", $to);  
        $body = preg_replace("/(^|(\r\n))(\\.)/", "", $body);  
        if ($cc != "") $mail_to = array_merge($mail_to, explode(",", $cc));  
        if ($bcc != "") $mail_to = array_merge($mail_to, explode(",", $bcc));  
  
        $headers  = "MIME-Version:1.0" . EOL;  
        $headers .= "To: " . $to . EOL;  
        if ($cc != "") {  
        $headers .= "Cc: " . $cc . EOL;  
        }  
        $headers .= "From: $from<" . $from . ">" . EOL;  
        $headers .= "Subject: " . $subject . EOL;  
        $headers .= "Date: " . date("r") . EOL;  
        $headers .= "X-Mailer: Webmail ver 1.0 (PHP Version/" . phpversion() . ")" . EOL;  
        $headers .= "Message-ID: <" . date("YmdHis", $sec) . "." . ($msec * 1000000) . "." . $from . ">" . EOL;  
        if (count($this->attachments) > 0) {  
            $headers .= "Content-Type: multipart/mixed;" . EOL . chr(9) . " boundary=\"" . $bndp . "\"" . EOL . EOL;  
            $headers .= '--'.$bndp . EOL;  
            $headers .= 'Content-Type : multipart/alternative; boundary="' . $bnd . '"' . EOL . EOL;  
            $headers .= '--' . $bnd . EOL;  
            $headers .= 'Content-Type: text/plain; charset=utf-8' . EOL;  
            $headers .= "Content-Transfer-Encoding: 8bit" . EOL . EOL;  
            $headers .= $body . EOL;  
            $headers .= '--' . $bnd . EOL;  
            $headers .= 'Content-type: text/html; charset=utf-8' . EOL;  
            $headers .= "Content-Transfer-Encoding: 8bit" . EOL . EOL;  
            $headers .= $body . EOL;  
            $headers .= '--' . $bnd . '--' . EOL;  
  
            foreach ($this->attachments as $att) {  
                $headers .= "--" . $bndp . EOL . $att;  
            }  
            $headers .= '--' . $bndp . '--' . EOL;  
            $this->clear_attachments();  
        } else {  
            $headers .= 'Content-Type : multipart/alternative;boundary="'.$bnd.'"' . EOL . EOL;  
            $headers .= '--'.$bnd . EOL;  
            $headers .= 'Content-Type: text/plain; charset=utf-8' . EOL;  
            $headers .= "Content-Transfer-Encoding: 8bit" . EOL . EOL;  
            $headers .= $body . EOL;  
            $headers .= '--'.$bnd . EOL;  
            $headers .= 'Content-type: text/html; charset=utf-8' . EOL;  
            $headers .= "Content-Transfer-Encoding: 8bit" . EOL . EOL;  
            $headers .= $body . EOL;  
            $headers .= '--'.$bnd.'--' . EOL;  
        }  
  
        $sent = TRUE;  
        foreach ($mail_to as $rcpt_to) {  
            $rcpt_to = $this->strip_line_breaks($rcpt_to);  
            if (!$this->smtp_sockopen($rcpt_to)) {  
                $this->log_write("Error: Cannot send email to " . $rcpt_to);  
                $sent = FALSE;  
                continue;  
            }  
            if ($this->smtp_send($this->host_name, $mail_from, $rcpt_to, $headers, $body)) {  
                $this->log_write("E-mail has been sent to <" . $rcpt_to . ">");  
            } else {  
                $this->log_write("Error: Cannot send email to <" . $rcpt_to . ">");  
                $sent = FALSE;  
            }  
            fclose($this->sock);  
        }  
//                var_dump($mail_to);die;  
        $this->log_write("{$mail_to[0]} send over;");  
        return $sent;  
    }  
  
    public function addAttachment($file, $dispo = "attachment") {  
        $file_data = (file_exists($file)) ? file_get_contents($file) : "";  
        if ($file_data != "") {  
            $filename = basename($file);  
            $ext = pathinfo($filename, PATHINFO_EXTENSION);  
            $chunks = chunk_split(base64_encode($file_data));  
            $parts  = "Content-Type: application/$ext; name=\"" . $filename . "\"" . EOL;  
            $parts .= "Content-Transfer-Encoding: base64" . EOL;  
            $parts .= "Content-Disposition: " . $dispo . "; filename=\"" . $filename . "\"" . EOL . EOL;  
            $parts .= $chunks . EOL . EOL;  
            $this->attachments[] = $parts;  
        }  
    }  
  
    private function clear_attachments() {  
        unset($this->attachments);  
        $this->attachments = array();  
    }  
  
    /* Private Functions */  
    private function smtp_send($helo, $from, $to, $header, $body = "") {  
        if (!$this->smtp_putcmd("HELO", $helo)) {  
            //$this->log_write("Error: Error occurred while sending HELO command.");  
            return FALSE;  
        }  
        #auth  
        if ($this->auth) {  
            if (!$this->smtp_putcmd("AUTH LOGIN", base64_encode($this->user))) {  
                //$this->log_write("Error: Error occurred while sending HELO command.");  
                return FALSE;  
            }  
            if (!$this->smtp_putcmd("", base64_encode($this->pass))) {  
                //$this->log_write("Error: Error occurred while sending HELO command.");  
                return FALSE;  
            }  
        }  
        if (!$this->smtp_putcmd("MAIL", "FROM:<" . $from . ">")) {  
            //$this->log_write("Error: Error occurred while sending MAIL FROM command.");  
            return FALSE;  
        }  
        if (!$this->smtp_putcmd("RCPT", "TO:<" . $to . ">")) {  
            //$this->log_write("Error: Error occurred while sending RCPT TO command.");  
            return FALSE;  
        }  
        if (!$this->smtp_putcmd("DATA")) {  
            //$this->log_write("Error: Error occurred while sending DATA command.");  
            return FALSE;  
        }  
        if (!$this->smtp_message($header, $body)) {  
            //$this->log_write("Error: Error occurred while sending message.");  
            return FALSE;  
        }  
        if (!$this->smtp_eom()) {  
            //$this->log_write("Error: Error occurred while sending <CR><LF>.<CR><LF> [EOM].");  
            return FALSE;  
        }  
        if (!$this->smtp_putcmd("QUIT")) {  
            //$this->log_write("Error: Error occurred while sending QUIT command.");  
            return FALSE;  
        }  
        return TRUE;  
    }  
    private function smtp_sockopen($address) {  
        if ($this->smtp_host == "") {  
            return $this->smtp_sockopen_mx($address);  
        } else {  
            return $this->smtp_sockopen_relay();  
        }  
    }  
    private function smtp_sockopen_relay() {  
        $this->log_write("Trying to Connect " . $this->smtp_host . ":" . $this->smtp_port . "...");  
        $this->sock = @fsockopen($this->smtp_host, $this->smtp_port, $errno, $errstr, $this->time_out);  
        if (!($this->sock && $this->smtp_ok())) {  
            $this->log_write("Error: connenct error" . $errstr . " (" . $errno . ")");  
            return FALSE;  
        }  
        $this->log_write("Connected Ok");  
        return TRUE;  
    }  
    private function smtp_sockopen_mx($address) {  
        $domain = preg_replace("/^.+@([^@]+)$/", "\1", $address);  
        if (!@getmxrr($domain, $MXHOSTS)) {  
            $this->log_write("Error: Cannot resolve MX \"" . $domain . "\"");  
            return FALSE;  
        }  
        foreach ($MXHOSTS as $host) {  
            $this->log_write("Trying to " . $host . ":" . $this->smtp_port);  
            $this->sock = @fsockopen($host, $this->smtp_port, $errno, $errstr, $this->time_out);  
            if (!($this->sock && $this->smtp_ok())) {  
                $this->log_write("Connect Error ," . $errstr . " (" . $errno . ")");  
                continue;  
            }  
            $this->log_write("Connected to mx host " . $host);  
            return TRUE;  
        }  
        $this->log_write("Error: Cannot connect to any mx hosts (" . implode(", ", $MXHOSTS) . ")");  
        return FALSE;  
    }  
    private function smtp_message($header, $body) {  
        fputs($this->sock, $header . "\r\n" . $body);  
        return TRUE;  
    }  
    private function smtp_eom() {  
        fputs($this->sock, "\r\n.\r\n");  
        return $this->smtp_ok();  
    }  
    private function smtp_ok() {  
        $response = str_replace("\r\n", "", fgets($this->sock, 512));  
        if (!preg_match("/^[23]/", $response)) {  
            fputs($this->sock, "QUIT\r\n");  
            fgets($this->sock, 512);  
            $this->log_write("Error: Remote host returned \"" . $response . "\"");  
            return FALSE;  
        }  
        return TRUE;  
    }  
    private function smtp_putcmd($cmd, $arg = "") {  
        if ($arg != "") $cmd = ($cmd == "") ? $arg : ($cmd . " " . $arg);  
        fputs($this->sock, $cmd . "\r\n");  
        return $this->smtp_ok();  
    }  
    private function strip_line_breaks($address) {  
        $address = preg_replace("/([\t\r\n])+/", "", $address);  
        $address = preg_replace("/^.*<(.+)>.*$/", "", $address);  
        return $address;  
    }  
    public function log_write($message) {  
        $message = date("M d H:i:s ") . get_current_user() . "[" . getmypid() . "]: " . $message;  
        file_put_contents(LOG, $message . PHP_EOL, FILE_APPEND | LOCK_EX);  
    }  
}  