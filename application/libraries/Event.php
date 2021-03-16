<?php

class Event
{
    protected $eventListeners = [];
    // private $tinycache;

    public function __construct()
    {
        // $this->eventListeners = cache()->get('config.eventListeners');
        if(! $this->eventListeners) $this->registerEvents();
    }

    public function getEventListeners()
    {
        return $this->eventListeners;
    }

    private function registerEvents()
    {
        $eventClasses = [];
        $this->eventListeners = [];

        foreach (modules_list() as $module => $detail)
        {
            if($detail['enable'] == false) continue;

            if(file_exists($detail['path'].'Events.php')){
                $fileinfo = pathinfo($detail['path'].'Events.php');
                include($fileinfo['dirname'].'/'.$fileinfo['basename']);

                // Define event objects
                $classAlias = ucfirst($module).'Events';
                $eventClasses[$classAlias] = new $classAlias();

                // define event registered
                $events = $eventClasses[$classAlias]->events; 
                foreach ($events as $event => $callback) {
                    $this->eventListeners[$event][] = [
                        'path' => $fileinfo['dirname'].'/'.$fileinfo['basename'],
                        'class' => $classAlias,
                        'method' => $callback
                    ];
                }
            }
        }

        // cache()->set('config.eventListeners', $this->eventListeners, 86400);
    }

    public function trigger($event, &$params = [])
    {
        // Check if event listener already defined
        if (empty($event) || !is_string($event) || !array_key_exists($event, $this->eventListeners))
            return $params;

        // Run every event callbacks and get their returns
        $return = [];
        $eventObjects = [];
        foreach ($this->eventListeners[$event] as $hook){
            if(! isset($eventObjects[$hook['class']])) {
                if(! class_exists($hook['class'], false) && file_exists($hook['path']))
                    include($hook['path']);
                if(class_exists($hook['class'], false))
                    $eventObjects[$hook['class']] = new $hook['class'];
            } 
            $return[] = $eventObjects[$hook['class']]->{$hook['method']}($params);
        }
        unset($eventObjects);

        return $return;
    }
}