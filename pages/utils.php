<?php
/*
	* $Id: utils.php 9 2017-01-18 08:46:47Z ralaad.pr $
*/

class utils {

    public static function check_email_address($email) {
        try {
            if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
                return false;
            }
            $email_array = explode("@", $email);
            $local_array = explode(".", $email_array[0]);
            for ($i = 0; $i < sizeof($local_array); $i++) {
                if
                (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
					↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
                    return false;
                }
            }
            if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
                $domain_array = explode(".", $email_array[1]);
                if (sizeof($domain_array) < 2) {
                    return false; // Not enough parts to domain
                }
                for ($i = 0; $i < sizeof($domain_array); $i++) {
                    if
                    (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
						↪([A-Za-z0-9]+))$", $domain_array[$i])) {
                        return false;
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            $this->runtimefailed($e->getMessage());
            exit(0);
        }
    }

    public static function arrayToString($array) {
        try {
            $i = 0;
            $string = '';
            foreach ($array as $index => $value) {
                if ($i != count($array) - 1) {
                    $string .= "$index :$value, ";
                } else
                    $string .= "$index :$value";
                $i++;
            }
            $string = '[' . $string . ']';
            return $string;
        } catch (Exception $e) {
            $this->runtimefailed($e->getMessage());
            exit(0);
        }
    }

    public static function randomPassword($passlen = 8) {
        try {
            $alphabet = "abcdefghijklmnopqrstuwxyz!@#$%*-+ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < $passlen; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass);
        } catch (Exception $e) {
            $this->runtimefailed($e->getMessage());
            exit(0);
        }
    }

    public static function sendmail($to, $subject, $message) {
        try {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers .= 'From:noreply@iaudits.in' . "\r\n" . 'Bcc:api@iaudit.in' . "\r\n";
            mail($to, $subject, $message, $headers);
        } catch (Exception $e) {
            $this->runtimefailed($e->getMessage());
            exit(0);
        }
    }

    public static function runtimefailed($message) {
        $message .= '\r\n\r\n\r\n';
        $file = './runtime/runtime' . session_id();
        file_put_contents($file, $message, FILE_APPEND | LOCK_EX);
    }

    public static function validatedate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return ($d->format($format) == $date->format($format));
    }

    public static function formatnumber($number, $isopbal = false) {
        if ($number == 0) {
            if ($isopbal) {
                return '0.00';
            }
            return '';
        }

        $number = sprintf('%.2f', abs($number));
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }

    public static function str_lreplace($search, $replace, $subject) {
        $pos = strrpos($subject, $search);

        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

    public static function getbase64encodedpdf($html) {

        error_reporting(0);
        $font = Font_Metrics::get_font("arial");
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
//        $dompdf->set_paper("A4", "portrait");
        $dompdf->render();
//        $dompdf->get_canvas()->page_text(20, 750, "-generated using iAudits. ", $font, 10, array(0, 0, 0));
//        $dompdf->get_canvas()->page_text(500, 750, "Page: {PAGE_NUM} of {PAGE_COUNT} ", $font, 10, array(0, 0, 0));
        $pdf = $dompdf->output(0);
        $retval = '<pdf>' . base64_encode($pdf) . '</pdf>';

        //error_reporting(E_ALL);
        return $retval;
    }

    public static function xmlEscape($string) {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }

    public static function cleanInputs($data) {
        $clean_input = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input [$k] = $this->cleanInputs($v);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $data = trim(stripslashes($data));
            }
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        // $clean_input =
        return $clean_input;
    }

    public static function getCommaString($d1, $d2) {
        $retval = '';
        if ($d1 != '' && $d2 != '') {
            $retval = $d1 . ', ' . $d2;
        } else {
            $retval = $d1 . $d2;
        }
        return $retval;
    }

    public static function getFormattedAmountWithoutZero($value) {
        $amt = (float) $value;
        $ret = '';
        if ($amt != 0) {
            $ret = $amt > 0 ? number_format($amt, 2) : '(' . number_format($amt * -1, 2) . ')';
        }
        return $ret;
    }

    public static function getFormattedAmount($value) {
        $amt = (float) $value;
        $ret = $amt >= 0 ? number_format($amt, 2) : '(' . number_format($amt * -1, 2) . ')';
        return $ret;
    }

    public static function conv2UTF8($str) {

        if (mb_detect_encoding($str, 'UTF-8', true) === false) {
            $str = utf8_encode($str);
        }

        return $str;
    }
    

}

?>
