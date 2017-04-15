<?php
namespace v6;

/**
 * Entry point
 *
 * @author willi
 */

require_once __DIR__ . '/ColorRendering.php';
require_once __DIR__ . '/Command/WWCommand.php';
require_once __DIR__ . '/Command/CommandFactory.php';

class Milight
{
    private $_ip;
    private $_port;
    private $_colorRendering;
    private $_command;
    private $_sock;
    private $_bridge;
    const   BUFFER_LEN = 22;
    
    public function __construct($ip, $port = 5987)
    {
        $this->_ip          = $ip;
        $this->_port        = $port;
        $this->_command     = null;
        $this->_sock        = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        $this->_bridge      = $this->getWifiBridgeSession();
    }
    
    private function sendCommand($bytes)
    {
        $msg     = vsprintf(str_repeat('%c', count($bytes)), $bytes);
        $buffer  = null;
        
        if ($this->_sock !== FALSE)
        {
            if (socket_sendto($this->_sock, $msg, strlen($msg), 0, $this->_ip, $this->_port) !== FALSE)
            {
                while (true)
                {
                    $ret = socket_recvfrom($this->_sock, $buffer, self::BUFFER_LEN, 0, $this->_ip, $this->_port);
                    if ($ret === false)
                    {
                        die(socket_strerror(socket_last_error()));
                    }
                    else
                        break;
                }
            }
        }
        
        return $buffer;
    }
    
    private function getWifiBridgeSession()
    {
        $command = array (
            0x20,0x00, 0x00,
            0x00, 0x16, 0x02,
            0x62, 0x3A, 0xD5,
            0xED, 0xA3, 0x01,
            0xAE, 0x08, 0x2D,
            0x46, 0x61, 0x41,
            0xA7, 0xF6, 0xDC,
            0xAF, 0xD3, 0xE6,
            0x00, 0x00, 0x1E);
        
        return $this->sendCommand($command);
    }
    
    public function setColorRendering($render)
    {
        $this->_colorRendering = $render;
        $this->_command = Command\CommandFactory::create($render);
    }
    
    public function getColorRendering()
    {
        return $this->_colorRendering;
    }
    
    public function exec($args)
    {
        if (empty ($this->_command))
        {
            throw new Exception ("You must set a color rendering");
        }
        var_dump($this->_bridge);
        if ($this->_sock !== FALSE && !empty ($this->_bridge))
        {
            switch ($args['action'])
            {
                case 'on':
                    $bytesToSend = $this->_command->switchOn($this->_bridge, $args);
                    $this->sendCommand($bytesToSend);
                    break;
                case 'off':
                    $bytesToSend = $this->_command->switchOff($this->_bridge, $args);
                    $this->sendCommand($bytesToSend);
                    break;
                case 'link':
                    $bytesToSend = $this->_command->link($this->_bridge, $args);
                    $this->sendCommand($bytesToSend);
                    break;
                case 'unlink':
                    $bytesToSend = $this->_command->unlink($this->_bridge, $args);
                    $this->sendCommand($bytesToSend);
                    break;
                case 'color':
                    $bytesToSend = $this->_command->setColor($this->_bridge, $args);
                    $this->sendCommand($bytesToSend);
                    break;
                case 'brightness':
                    $bytesToSend = $this->_command->setBrightness($this->_bridge, $args);
                    $this->sendCommand($bytesToSend);
                    break;
                default :
                    break;
            }
        }
        else
        {
            throw new Exception ("socket or bridge error");
        }
    }
    
    public function __destruct() 
    {
        socket_close($this->_sock);
    }
}
