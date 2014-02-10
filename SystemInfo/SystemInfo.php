<?php
namespace SystemInfo;

class SystemInfo{
    
    
    /**
     * @var array system information
     * array(
     *      ['sysname'] --> OS type (Linux, Windows NT, FreeBSD,...)
     *      ['nodename'] --> hostname
     *      ['release'] --> OS release
     *      ['version'] --> OS version name
     *      ['machine'] --> machine type (x86_64, i586, ...)
     *      )
     */
    private $sysInfo;
    
    private $osType;
    
    private $OSDataReader;
    
    private $cpuInfo = null;
    
    
    
    //*************************************
    //
    //      Public API
    //
    //*************************************    
    
    /**
    * Constructor
    * Set Operative System type 
    *  
    */    
    public function __construct(){
        $this->setSysInfo();
        $this->osType = $this->setOsType($this->sysInfo['sysname']);
        $osClassType = 'SystemInfo\\OS\\'. $this->osType;
        $this->OSDataReader = new $osClassType();
    }
    
    
    /**
    *
    * @return string
    */
    public function getHostName(){
        return $this->sysInfo['nodename'];
    }
    
    
	/**
    *
    * @return array()
    */
    public function getInfo(){
        return $this->sysInfo;
    }
    
    /**
    *
    * @return array()
    */   
    public function getCpuInfo(){
    	if(is_null($this->cpuInfo)){
    		$this->cpuInfo = $this->OSDataReader->CpuInfo();
    	}
    	return $this->cpuInfo;
    }
    
    /**
    *
    * @return int
    */   
     public function getMemoryInfo(){
       return $this->OSDataReader->MemoryInfo();
    }   
    
    
    
    
    
    
    //*************************************
    //
    //      Private methods
    //
    //*************************************  
    
            
    /**
     * Init $sysInfo
     */
    private function setSysInfo(){
        if(is_callable('posix_uname')){
            $this->sysInfo = posix_uname();
        }else{
            $this->sysInfo = $this->php2posix_uname();
        }
    }
    
    
    /**
    * Set $osType. Translate $sysInfo['sysname'] in class name to invoke
    *
    * @param string $sysname
    *
    * @return string
    */
    private function setOsType($sysname){
    	$os = '';
    	if (substr($sysname, 0, 7) == 'Windows'){
    		$os = 'Windows';
    	}else if (substr($sysname, 0, 6) == 'Darwin'){
    		$os = 'MacOS';
    	}else if (strtolower($sysname) == 'linux'){
    		$os = 'Linux';
    	}else if (strtolower($sysname) == 'freebsd'){
    		$os = 'FreeBSD';
    	}
    	return $os;
    }
    
    
    
    /**
     * Convert php_uname in posix_uname
     *
     * @return array
     */
    private function php2posix_uname(){
        $posix = array();
        $posix['sysname'] = php_uname('s');
        $posix['nodename'] = php_uname('n');
        $posix['release'] = php_uname('r');
        $posix['version'] = php_uname('v');
        $posix['machine'] = php_uname('m');
        return $posix;
    }

}
