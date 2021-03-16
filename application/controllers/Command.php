<?php
/**
 * This is controller used to run cli task
 *
 * Command: 
 *      php mein command class/method/param1/param2
 * or: 
 *      php mein command class method param1 param2 
 *
 * You can run `sudo chmod +x mein` from root project
 * So you can call the command without command php, like this:
 *
 *      ./mein command class/method/param1/param2 
 *
 * For easy development, you can call this endpoint from browser too :D
 * Like this:
 *      http://localhost/command/class/method/param1/param2 
 *
 * Command run from root project not public/
 * Command class is placed in mein/cli/ folder
 * You can make your own class with any format
 */

class Command extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(false);        
    }

    public function index()
    {
        // TODO: show all available commands
        
        echo "\n";
    }

    public function run($class, $method = 'index', ...$param)
    {
        if(! file_exists(APPPATH.'cli/'.ucfirst($class).'.php'))
        {
            $errorMessage = "Command class ".ucfirst($class)." not found";
            throw new \RuntimeException($errorMessage);
        }
        
        $className = "App\cli\\".ucfirst($class);
        $commandObject = new $className;
        if (!method_exists($commandObject, $method))
        {
            $errorMessage = "Command method ".ucfirst($class)."::$method not found";
            throw new \RuntimeException($errorMessage);
        }
        
        $output = call_user_func_array([$commandObject, $method], $param);
        echo $output;
    }
}
