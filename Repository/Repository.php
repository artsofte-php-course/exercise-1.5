<?php

abstract class Repository
{
    abstract public function add($item);
    abstract public function getItem($key);
}