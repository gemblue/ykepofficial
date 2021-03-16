<?php namespace App\hooks;

class PostControllerConstructorHook extends BaseHook {

    protected $methods = [
        'checkAdminSession',
        'registerACL'
    ];

    /**
     * Check session required to access /admin
     * 
     * @package ACL
     * @author Toni
     */
    public function checkAdminSession()
    {
      $uriString = uri_string();
      $segments = explode('/', $uriString);
      $totalSegment = count($segments);

      // First, check /admin or no. By Pass if no.
      if (($segments[0] ?? null) != 'admin')
        return true;

      if (! ci()->ci_auth->isLoggedIn())
        redirect('user/login');
    }

    /**
     * Define ACL for CI3
     * 
     * ACL Stands before Command Request and Command Action. 
     * HTTP Req -> Command Req -> ACL -> Command Action
     * 
     * This class responsible to allow command or deny command by User Role.
     * Instead of putting permission check in each methods, we better do ACL
     * on CI Hooks. So it's become "DRY".
     * 
     * @package ACL
     * @author Oriza
     */
    public function registerACL() 
    {
        // First thing first, if it is superadmin, allow access
        if (ci()->session->role_id == 1) {
            return true;
        } 

        $uriString = uri_string();
        $segments = explode('/', $uriString);
        $totalSegment = count($segments);
        
        // First, check /admin or no. By Pass if no.
        if (($segments[0] ?? null) != 'admin') {
            return true;
        }

        // If there is just /admin, redirect, because /admin is invalid privilege
        if (!isset($segments[1])) {
            redirect('admin/dashboard');
        }

        // Check module, user entry name if it is an entry page
        $module = in_array($segments[1],['entry','page']) ? $segments[2] : $segments[1];

        // Get module or entry privilege list
        $modules = config_item('pages')[$module]
                    ?? config_item('entries')[$module]
                    ?? config_item('modules')[$module]
                    ?? [];

        // Allow access for entry or module that has no any defined privilege
        if(!isset($modules['privileges'])) {
            return true;
        }

        foreach ($modules['privileges'] as $permission) {
            $perm_regex = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $permission);

            if(preg_match('#^admin/'.$perm_regex.'$#', $uriString, $matches) and (isPermitted($permission, $module))) 
                return true;
        }

        show_error("Sorry, you don't have permission to access this page. Please refer this to your admin.");
    }
}
