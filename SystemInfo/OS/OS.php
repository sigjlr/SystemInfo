<?php

namespace SystemInfo\OS;

interface OS{
            
    /**
     * Retrurn data about CPU
     *
     * @return array(SystemInfo\Hardware\Cpu)
     */
    public function CpuInfo();

    
    /**
     * Retrurn data about Memory size
     *
     * @return int
     */        
    public function MemoryInfo();
    
    
    /**
     * Retrurn data about Network Interface Card
     *
     * @return array([SystemInfo\Hardware\Nic])
     */      
    public function NicInfo();
}
