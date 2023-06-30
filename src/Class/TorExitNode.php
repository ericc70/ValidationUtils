<?php

namespace  Ericc70\ValidationUtils\Class;

use Exception;

class TorExitNode
{
    private $torExitNodes;

    public function __construct()
    {
        $this->torExitNodes = $this->fetchTorExitNodes();
    }

    private function fetchTorExitNodes()
    {
        $torExitNodesURL = 'https://check.torproject.org/torbulkexitlist';
        $torExitNodes = file($torExitNodesURL, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (!$torExitNodes) {
            throw new Exception("Unable to fetch Tor exit nodes");
        }

        return $torExitNodes;
    }

    public function isTorExitNode($ip)
    {

        return in_array($ip, $this->torExitNodes);
    }



    public function torProjetApi($ip)
    {

        $api_url = 'https://onionoo.torproject.org/details';


        $curl = curl_init($api_url . "?search=" . $ip);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($result);
        if (isset($json->relays[0]->aS)) {
            $as_name = $json->relays[0]->aS;
            if (strpos(strtolower($as_name), 'tor') !== false) {
                return true;
            }
        }
        return false;
    }
}

// public function isTorExitNode($ipAddress)
// {
//     $apiUrl = 'https://onionoo.torproject.org/details?search=ip:'.$ipAddress;
//     $response = file_get_contents($apiUrl);
//     $json = json_decode($response, true);

//     if ($json && isset($json['relays']) && count($json['relays']) > 0) {
//         foreach ($json['relays'] as $relay) {
//             if (isset($relay['exit_probability']) && $relay['exit_probability'] > 0) {
//                 return true;
//             }
//         }
//     }

//     return false;
// }
