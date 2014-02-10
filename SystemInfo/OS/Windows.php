<?php
namespace SystemInfo\OS;

class Windows implements OS{
	
	
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
            $this->getMemoryInfo();
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
     private function getCPUInfo(){
        // query contents of CentralProcessor section.
        $output = shell_exec( "reg query HKLM\\HARDWARE\\DESCRIPTION\\SYSTEM\\CentralProcessor" );
        $outputStrings = explode( "\n", $output );
        // In first two items of output strings we have the signature of reg.exe utility 
        // and path to CentralProcessor section than list of subsections paths follows.
        // One subsection represent info for one CPU.
        // Name of each subsection is index of CPU starting from 0.
        if ( is_array( $outputStrings ) && count( $outputStrings ) > 2 ){
            $this->cpuCount = count( $outputStrings ) - 2; // cpuCount is amount of subsections, output header skipped.
            for ( $i = 0; $i < $this->cpuCount; $i++ ){
            	$cpuData = new \SystemInfo\Hardware\Cpu();
                $output = shell_exec( "reg query HKLM\\HARDWARE\\DESCRIPTION\\SYSTEM\\CentralProcessor\\$i /v ProcessorNameString" );
                preg_match( "/ProcessorNameString\s*\S*\s*(.*)/", $output, $matches );
                if ( isset( $matches[1] ) ){
                    $cpuData->type = $matches[1];
                }
                unset( $matches );

                $output = shell_exec( "reg query HKLM\\HARDWARE\\DESCRIPTION\\SYSTEM\\CentralProcessor\\$i /v ~MHz" );
                preg_match( "/~MHz\s*\S*\s*(\S*)/", $output, $matches );
                if ( isset( $matches[1] ) ){
                    $cpuData->speed = (float)hexdec( $matches[1] ).'.0'; // force to be float value
                }
                unset( $matches );
                $this->cpu[]=$cpuData;
            }
        }
        return true;
    }

    
    private function getMemoryInfo(){
        $output = shell_exec("wmic memorychip get capacity");
        $outputStrings = explode( "\n", $output );
       
        $this->memorySize =  $outputStrings[1];
        return true;
    }
}