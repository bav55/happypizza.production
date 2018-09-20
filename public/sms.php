<?php
session_start();
if (isset($_SESSION['sms_message'])) {
    foreach ($_SESSION['sms_message'] as $message) {
        echo $message;    
    }
}