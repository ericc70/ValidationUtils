<?php

namespace  Ericc70\ValidationUtils\Class;

class TorExitNode
{
    private $torExitNodes;

    public function __construct() {
        $this->torExitNodes = $this->fetchTorExitNodes();
    }

    private function fetchTorExitNodes() {
        $torExitNodesURL = 'https://check.torproject.org/torbulkexitlist';
        return file($torExitNodesURL, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    public function isTorExitNode($ip) {
        return in_array($ip, $this->torExitNodes);
    }

}
