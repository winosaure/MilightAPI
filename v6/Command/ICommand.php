<?php
namespace v6\Command;

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
     * @param type $zone
     */
    
    public function switchOn($bridge, $zone);
    
    /**
     * 
     * Switch off the light
     * 
     * @param type $bridge
     * @param type $zone
     */
    public function switchOff($bridge, $zone);
    
    /**
     * 
     * Sync the bulb.
     *  within 3 seconds of lightbulb socket power on
     * 
     * @param type $bridge
     * @param type $zone
     */
    
    public function link($bridge, $zone);
    
    /**
     * 
     * Clear the bulb
     * within 3 seconds of lightbulb socket power on
     * 
     * @param type $bridge
     * @param type $zone
     */
    public function unlink($bridge, $zone);
    
    /**
     * 
     * Change the color of the bulb
     * 
     * @param type $color
     * @param type $bridge
     * @param type $zone
     */
    public function setColor($color, $bridge, $zone);
}
