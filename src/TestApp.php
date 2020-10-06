<?php
namespace TestApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class TestApp implements MessageComponentInterface
{
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $conn, $pack) {
        $package = json_decode($pack);
        switch ($package->type) {
            case 'join':
                $this->joinChat($conn, $package);
                break;
            case 'msg':
                $this->sendMessage($conn, $package);
                break;
            default:
                echo 'Invalid request detected!';
        }

    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
        $package = new \stdClass();
        $package->msg = 'has left the chat';
        $package->status = 'leave';
        $this->sendMessage($conn, $package);
        $this->refreshList($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    public function joinChat(ConnectionInterface $conn, $package) {
        if (!empty($package->msg)) {
            $conn->username = $package->msg;
            $conn->send(json_encode([
                'type' => 'setuser',
                'status' => 1
            ]));
            $package->msg = 'has joined the chat';
            $package->status = 'join';
            $this->sendMessage($conn, $package);
            $this->refreshList($conn);
        } else {
            $conn->send(json_encode([
                'type' => 'setuser',
                'status' => 0
            ]));
        }
    }

    public function sendMessage(ConnectionInterface $conn, $package) {
        $username = $conn->username;
        $status = (isset($package->status)) ? $package->status : 'message';
        $content = [
            'type' => $status,
            'username' => $username,
            'message' => $package->msg
        ];
        $msg = json_encode($content);
        if (!empty($package->msg)) {
            foreach ($this->clients as $client) {
                $client->send($msg);
            }
        }
    }

    public function refreshList($conn) {
        $userlist = [];
        foreach ($this->clients as $client) {
            if (isset($client->username)) {
                $userlist[] = $client->username;
            }
        }
        $package = new \stdClass();
        $package->msg = $userlist;
        $package->status = 'userlist';
        $this->sendMessage($conn, $package);
    }

}
