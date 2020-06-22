<?php 

// DEBUG FILE
////

require_once($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbinit.php");
require($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php");
$conf = require("dbconfig.php");
//require($_SERVER["DOCUMENT_ROOT"] . "/portal/include/phpseclib/Net/SSH2.php");

use phpseclib\Net\SFTP;


$db = new db_connection();

error_reporting(E_ALL);

$sftp = new SFTP($conf["sftp-host"]);
if (!$sftp->login($conf["sftp-user"], $conf["sftp-pass"])) {
    exit('Login Failed');
}

// puts a three-byte file named filename.remote on the SFTP server
$sftp->put('/writable/filename.remote', 'xxx');
// puts an x-byte file named filename.remote on the SFTP server,
// where x is the size of filename.local
$sftp->put('/writable/remote.sql', 'dbschema.sql', SFTP::SOURCE_LOCAL_FILE);

?>