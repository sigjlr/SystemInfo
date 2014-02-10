<?php
namespace SystemInfo\Hardware;

class Nic{
	
   /**
    * Contains the strings that represent type of CPU,
    * for each CPU in sysytem. Type is taken directly
    * from the OS and can vary a lot.
    *
    * @var string
    */
	public $type;
	
	/**
     * Contains the speed of CPU in MHz.
     *
     * @var (float)
     */
	public $speed;
}
	