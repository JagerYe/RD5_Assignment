<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/RD5_Assignment/websockets.php";

class AmountChangeServer extends WebSocketServer
{
    private $users = array();

    protected function process($user, $message)
    {
        echo "got message: $message \r\n";
        $this->send($user, $message);
    }
    protected function connected($user)
    {
        $users[] = $user;
    }
    protected function closed($user)
    {
        
    }
}
