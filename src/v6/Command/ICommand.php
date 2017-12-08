<?php

namespace Winosaure\MilightApi\v6\Command;

/**
 * This Interface will cover all implementation of different
 * bulb color rendering such as CW, WW, WWX etc..
 *
 * @author willi
 */
Interface ICommand
{
    /**
     * 
     * Switch on the light
     * 
     * @param type $bridge
     * @param type $args
     */
    
    public function switchOn($bridge, $args);
    
    /**
     * 
     * Switch off the light
     * 
     * @param type $bridge
     * @param type $args
     */
    public function switchOff($bridge, $args);
    
    /**
     * 
     * Sync the bulb.
     *  within 3 seconds of lightbulb socket power on
     * 
     * @param type $bridge
     * @param type $args
     */
    
    public function link($bridge, $args);
    
    /**
     * 
     * Clear the bulb
     * within 3 seconds of lightbulb socket power on
     * 
     * @param type $bridge
     * @param type $args
     */
    public function unlink($bridge, $args);
    
    /**
     * 
     * Change the color of the bulb
     * 
     * @param type $bridge
     * @param type $args
     */
    public function setColor($bridge, $args);
}
