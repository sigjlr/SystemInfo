SystemInfo
==========

PHP wrapper to get system information.

##Usage
This example assumes you are autoloading dependencies using Composer or any other [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) compliant autoloader.

SystemInfo available method:

- getInfo()
	Returns an array with the following key:
     - ['sysname'] --> OS type (Linux, Windows NT, FreeBSD,...)
     - ['nodename'] --> hostname
     - ['release'] --> OS release
     - ['version'] --> OS version name
     - ['machine'] --> machine type (x86_64, i586, ...)

		
- getCpuInfo()
	Returns an array of CPU. For every CPU type and speed is returned.

	
- getMemoryInfo()
	Returns total memory in byte
	


###Example
```php
// Create a new SystemInfo object
$si = new \SystemInfo\SystemInfo();


echo 'System info:</br>';
print_r($si->getInfo());


echo 'CPU:</br>';
print_r($si->getCpuInfo());

echo 'System Memory:</br>';
echo($si->getMemoryInfo());

````



##License
The PhpSimpleProfiler is released under the MIT public license

