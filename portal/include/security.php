<?php

function generate_indempotency() {

	// https://stackoverflow.com/questions/4356289/php-random-string-generator/31107425#31107425
	return bin2hex(openssl_random_pseudo_bytes(10)); // 20 chars

}

?>