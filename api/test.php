<?php
header("Content-Type: text/plain");
echo "PHP " . PHP_VERSION . "\n";
echo "curl: " . (function_exists('curl_init') ? 'yes' : 'NO') . "\n";
echo "openssl: " . (extension_loaded('openssl') ? 'yes' : 'NO') . "\n";
echo "api key set: " . (getenv('RESEND_API_KEY') ? 'yes' : 'NO') . "\n";