<?php

namespace App\Http\Controllers;

// require __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Http\Request;
use phpseclib3\Net\SFTP;

class SupplierController extends Controller
{
    
    // CWR - get inventory file
    public function inventFile() {
        
        // Instantiate supplier ftp log in details
        $localFile = '';
        $remoteFile = '';
        $username = '';
        $password = '';

        $supplier = request('supplier');
        
        if ($supplier == 'CWR') {
            $localFile = 'cwrCSVFile.csv';
            $remoteFile = 'out/catalog.csv';
            $username = env('cwrUser');
            $password = env('cwrPass');

            // make SFTP connection
            $sftp = new SFTP('edi.cwrdistribution.com');
            if (!$sftp->login($username, $password)) {
                exit('Login Failed');
            }

            // Download file
            if (!$sftp->get($remoteFile, $localFile)) {
                exit('Error downloading SFTP file.');
            }

        } elseif ($supplier == 'TWH') {
            $localFile = 'twHouseCSVFile.csv';
            $remoteFile = 'invenfeed_5264.csv';
            $username = env('twhUser');
            $password = env('twhPass');

            // Make FTP connection
            $ftpServer = "ftp.twhouse.com";
            $ftpConn = ftp_connect($ftpServer) or die('Could not connect to ftp server');
            $login = ftp_login($ftpConn, $username, $password);

            // turn passive mode on
            ftp_pasv($ftpConn, true);

            // download server file
            if (!ftp_get($ftpConn, $localFile, $remoteFile, FTP_BINARY)) {
                echo 'Error downloading FTP file.';
            }

            // close connection
            ftp_close($ftpConn);

        }

        return redirect('/')->with('success', 'The supplier\'s inventory file has been downloaded.');

    }
}
