<?php
namespace SystemInfo\OS;

class Linux implements OS{
    
    
     /**
     * Contains the amount of CPUs in system.
     *
     * @var int
     */
    protected $cpuCount = null;

    
    /**
     * Contains the data for each CPU in sysytem.
     *
     * @var array(SystemInfo\Hardware\Cpu)
     */
    protected $cpu = array();


    /**
     * Contains the amount of system memory the OS has, the value is in bytes.
     *
     * @var int
     */
    protected $memorySize = null;
    

    		
    //*************************************
    //
    //      Public API
    //
    //*************************************
        
    public function __construct(){
    }
    
  
  
    /**
    * Retrurn data about CPU
    *
    * @return array(SystemInfo\Hardware\Cpu)
    */  
    public function CpuInfo(){
        if(is_null($this->cpuCount)){
            $this->getCPUInfo();
        }        
        return $this->cpu;
    }
  

     /**
     * Retrurn data about Memory size
     *
     * @return int
     */    
    public function MemoryInfo(){
        if(is_null($this->memorySize)){
            $this->getMemInfo();
        }
        return $this->memorySize;
    }
    
    
    /**
     * Retrurn data about Network Interface Card
     *
     * @return array([SystemInfo\Hardware\Nic])
     */       
    public function NicInfo(){
    }

    
    //*************************************
    //
    //      Private methods
    //
    //*************************************   
    
    private function getCPUInfo( $cpuinfoPath = false){
        if (!$cpuinfoPath){
            $cpuinfoPath = '/proc/cpuinfo';
        }
        if (!file_exists($cpuinfoPath)){
            return false;
        }
        
        $cpuCount = 0;
        $fileLines = file( $cpuinfoPath );
        $cpuid = 0;
        foreach ( $fileLines as $line ){
            $exp_line = explode(':', $line);
            if (trim($exp_line[0]) == 'processor'){
                $cpuid = trim($exp_line[1]);
                $this->cpu[$cpuid] = new \SystemInfo\Hardware\Cpu();
            }
            if (trim($exp_line[0]) == 'model name'){
                $this->cpu[$cpuid]->type = trim($exp_line[1]);
            }
            if (trim($exp_line[0]) == 'cpu MHz'){
                 $this->cpu[$cpuid]->speed = trim($exp_line[1]);
            } 
        }
        
        return true;
    }

    
    
    
    
    
    private function getMemInfo($meminfoPath = false ){
        if ( !$meminfoPath ){
            $meminfoPath = '/proc/meminfo';
        }      
        if ( !file_exists( $meminfoPath ) ){
            return false;
        }
        
        $fileLines = file( $meminfoPath );
        foreach ( $fileLines as $line ){
            if ( substr( $line, 0, 8 ) == 'MemTotal' ){
                $mem = trim( substr( $line, 11, strlen( $line ) - 11 ) );
                $memBytes = $mem;
                if ( preg_match( "#^([0-9]+) *([a-zA-Z]+)#", $mem, $matches ) ){
                    $memBytes = (int)$matches[1];
                    $unit = strtolower( $matches[2] );
                    if ( $unit == 'kb' ){
                        $memBytes *= 1024;
                    }else if ( $unit == 'mb' ){
                        $memBytes *= 1024*1024;
                    }else if ( $unit == 'gb' ){
                        $memBytes *= 1024*1024*1024;
                    }
                }else{
                    $memBytes = (int)$memBytes;
                }
                $this->memorySize = $memBytes;
            }
            if ( $this->memorySize !== null ){
                break;
            }
        }
        return true;
    }
}