<?php
namespace v6\Command;

/**
 * @author willi
 */

require_once __DIR__ . '/ICommand.php';

class WWCommand implements ICommand
{
    private $_scope;
    
    public function __construct()
    {
        $this->_scope = 0x31;   
    }
    
    public function getChecksum($command, $zone)
    {
        $checksum = $this->_scope+0x00+0x00;
        
        if (!empty ($command))
        {
            foreach ($command as $byte)
            {
                $checksum += $byte;
            }
        }
        $checksum += $zone+0x00;
        
        return $checksum;
    }
    
    private function createByteArray($bytes, $bridge, $zone)
    {
        $checksum = $this->getChecksum($bytes, $zone);
        $command  = array (0x80, 0x00, 0x00,
            0x00, 0x11, unpack('c', $bridge[19])[1],
            unpack('c', $bridge[20])[1], 0x00, 0x00,
            0x01, $this->_scope, 0x00, 0x00
            );
            foreach ($bytes as $byte)
                $command[] = $byte;
            $command[] = $zone;
            $command[] = 0x00;
            $command[] = $checksum;
        
            return $command;
    }
    
    
    public function switchOn($bridge, $zone)
    {
        $this->_scope = 0x31;
        $bytesOn      = array (0x07, 0x03, 0x01, 0x00, 0x00, 0x00);
        
        return $this->createByteArray($bytesOn, $bridge, $zone);
    }
    
    public function switchOff($bridge, $zone)
    {
        $this->_scope = 0x31;
        $bytesOff     = array (0x07, 0x03, 0x02, 0x00, 0x00, 0x00);
        
        return $this->createByteArray($bytesOff, $bridge, $zone);
    }
    
    public function link($bridge, $zone)
    {
        $this->_scope = 0x3D;
        $bytesLink    = array (0x07, 0x00, 0x00, 0x00, 0x00, 0x00);
       
        return $this->createByteArray($bytesLink, $bridge, $zone);
    }
    
    public function unlink($bridge, $zone)
    {
        $this->_scope = 0x3E;
        $bytesUnlink  = array (0x07, 0x00, 0x00, 0x00, 0x00, 0x00);
        
        return $this->createByteArray($bytesUnlink, $bridge, $zone);
    }
    
    public function setColor($color, $bridge, $zone)
    {
        $this->_scope = 0x31; 
        $bytes        = null;
        
        if ($color == "white")
        {
            $bytes = array (0x07, 0x03, 0x05, 0x00, 0x00, 0x00);
        }
        
        return $this->createByteArray($bytes, $bridge, $zone);
    }
}
