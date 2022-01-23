<?php

function getMax(int $a, int $b): int
{
    return max($a, $b);
}

function fillArray(&$jsonData)
{
    if (!isset($jsonData['name'])) {
        $jsonData['name'] = null;
    }

    if (!isset($jsonData['age'])) {
        $jsonData['age'] = null;
    }

    if (!isset($jsonData['type'])) {
        $jsonData['type'] = null;
    }

    if (!isset($jsonData['id'])) {
        $jsonData['id'] = null;
    }
}
/**
 * Some useful function
 */