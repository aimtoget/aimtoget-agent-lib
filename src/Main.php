<?php

namespace Aimtoget\Agent;

abstract class Main
{
    /**
     * Configuration
     *
     * @var Config
     */
    protected $_config;

    /**
     * Constructor
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->_config = $config;
    }
}