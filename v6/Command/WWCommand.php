<?php
namespace v6\Command;

/**
 * @author willi
 */

require_once __DIR__ . '/ICommand.php';

class WWCommand implements ICommand
{
    private $_scope;
    private $_bytesCommand = array (
        'link'       => array (0x07, 0x00, 0x00, 0x00, 0x00, 0x00),
        'unlink'     => array (0x07, 0x00, 0x00, 0x00, 0x00, 0x00),
        'on'         => array (0x07, 0x03, 0x01, 0x00, 0x00, 0x00),
        'off'        => array (0x07, 0x03, 0x02, 0x00, 0x00, 0x00),
        'white'      => array (0x07, 0x03, 0x05, 0x00, 0x00, 0x00),
        'blue'       => array (0x07, 0x01, 0xBA, 0xBA, 0xBA, 0xBA),
        'aqua'       => array (0x07, 0x01, 0x85, 0x85, 0x85, 0x85),
        'red'        => array (0x07, 0x01, 0xFF, 0xFF, 0xFF, 0xFF),
        'lavender'   => array (0x07, 0x01, 0xD9, 0xD9, 0xD9, 0xD9),
        'green'      => array (0x07, 0x01, 0x7A, 0x7A, 0x7A, 0x7A),
        'lime'       => array (0x07, 0x01, 0x54, 0x54, 0x54, 0x54),
        'orange'     => array (0x07, 0x01, 0x1E, 0x1E, 0x1E, 0x1E),
        'yellow'     => array (0x07, 0x01, 0x3B, 0x3B, 0x3B, 0x3B),
        'brightness' => array (0x07, 0x02, 0x64, 0x00, 0x00, 0x00)
    );
    
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
            if (!empty ($bytes))
            {
               foreach ($bytes as $byte)
                   $command[] = $byte;
            }
            $command[] = $zone;
            $command[] = 0x00;
            $command[] = $checksum;
        
            return $command;
    }
    
    
    public function switchOn($bridge, $args)
    {
        $this->_scope = 0x31;
        
        return $this->createByteArray($this->_bytesCommand[$args['action']], $bridge, $args['zone']);
    }
    
    public function switchOff($bridge, $args)
    {
        $this->_scope = 0x31;
        
        return $this->createByteArray($this->_bytesCommand[$args['action']], $bridge, $args['zone']);
    }
    
    public function link($bridge, $args)
    {
        $this->_scope = 0x3D;
       
        return $this->createByteArray($this->_bytesCommand[$args['action']], $bridge, $args['zone']);
    }
    
    public function unlink($bridge, $args)
    {
        $this->_scope = 0x3E;
        
        return $this->createByteArray($this->_bytesCommand[$args['action']], $bridge, $args['zone']);
    }
    
    public function setBrightness($bridge, $args)
    {
        if (!isset ($args['intensity']))
        {
            die("You must specify the insity");
        }
        $this->_scope  = 0x31;
        $brightness    = $this->_bytesCommand[$args['action']];
        $brightness[2] = $args['intensity'];
        
        return $this->createByteArray($brightness, $bridge, $args['zone']);
    }
    
    public function setColor($bridge, $args)
    {
        $this->_scope = 0x31; 
        
        if (!isset ($this->_bytesCommand[$args['color']]))
        {
            die("Unkown color");
        }


        return $this->createByteArray($this->_bytesCommand[$args['color']], $bridge, $args['zone']);
    }
}
