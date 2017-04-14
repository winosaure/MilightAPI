<?php
namespace v6\Command;

/**
 *
 * Factory
 * 
 * @author willi
 */

require_once __DIR__ . '/WWCommand.php';
require_once __DIR__ . '/../ColorRendering.php';

class CommandFactory
{
    public static function create($render)
    {
        $renderClass = new \ReflectionClass('v6\ColorRendering');
        $typeRender  = $renderClass->getConstants();

        if (!empty ($typeRender))
        {
            foreach ($typeRender as $key => $val)
            {
                if ($val == $render)
                {
                    return self::$key();
                }
            }
        }
    }
    
    private static function WW()
    {
        return new WWCommand();
    }
}
