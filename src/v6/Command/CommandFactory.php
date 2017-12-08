<?php

namespace Winosaure\MilightApi\v6\Command;

/**
 *
 * Factory
 * 
 * @author willi
 */

class CommandFactory
{
    public static function create($render)
    {
        $renderClass = new \ReflectionClass('\Winosaure\MilightApi\v6\ColorRendering');
        $typeRender  = $renderClass->getConstants();

        if (!empty ($typeRender))
        {
            foreach ($typeRender as $key => &$val)
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
