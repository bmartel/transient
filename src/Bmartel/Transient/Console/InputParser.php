<?php
namespace Bmartel\Transient\Console;


class InputParser
{
    public function parse($model)
    {
        $segments = explode('\\', str_replace('/', '\\', $model));
        $namespace = implode('\\', $segments);

        return $namespace;
    }

    public function parseProperties($properties)
    {
        return preg_split('/ ?, ?/', $properties, null, PREG_SPLIT_NO_EMPTY);
    }

}