<?php

function formatName($name)
{
    return preg_replace('/^([^,]*),\s*(.*)$/', '$2 $1', $name);
}
