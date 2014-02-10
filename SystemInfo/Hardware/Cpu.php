<?php
namespace SystemInfo\Hardware;

class Cpu{
	
   /**
    * Contains the strings that represent type of CPU,
    * Type is taken directly from the OS and can vary a lot.
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
	