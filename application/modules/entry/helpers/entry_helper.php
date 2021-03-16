<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Symfony\Component\Yaml\Yaml;

/**
 * Entry module helpers 
 */

if (!function_exists('generate_input'))
{
    function generate_input($config, $value = null)
    {
        $ci = get_instance();
        if(!$value) $value = set_value($config['field'], $config['default'] ?? '', false);
        $config['form'] = $config['form'] ?? 'text';
        if(file_exists(APPPATH.'modules/entry/views/fields/' . $config['form'] . '/input.php'))
            return $ci->load->view('entry/fields/' . $config['form'] . '/input', compact('config','value'), true);
        
        return $ci->load->view('entry/fields/text/input', compact('config','value'), true);
    }
}

if (!function_exists('generate_output'))
{
    function generate_output($config, $result)
    {
        $ci = get_instance();
        $config['form'] = $config['form'] ?? 'text';
        if(file_exists(APPPATH.'modules/entry/views/fields/' . $config['form'] . '/output.php'))
            return $ci->load->view('entry/fields/' . $config['form'] . '/output', compact('config','result'), true);

        return $ci->load->view('entry/fields/text/output', compact('result','config'), true);
    }
}

if (!function_exists('generate_output_api'))
{
    function generate_output_api($config, $result)
    {
        $ci = get_instance();
        $config['form'] = $config['form'] ?? 'text';
        if(file_exists(APPPATH.'modules/entry/views/fields/' . $config['form'] . '/output_api.php'))
            $filepath = APPPATH.'modules/entry/views/fields/' . $config['form'] . '/output_api.php';
        else
            $filepath = APPPATH.'modules/entry/views/fields/text/output_api.php';

        return (include $filepath);
    }
}

if (!function_exists('form_filter'))
{
    function form_filter($config)
    {
        $ci = get_instance();
        $config['form'] = $config['form'] ?? 'text';
        if(file_exists(APPPATH.'modules/entry/views/fields/' . $config['form'] . '/filter.php'))
            return $ci->load->view('entry/fields/' . $config['form'] .'/filter', compact('config'), true);

        return $ci->load->view('entry/fields/text/filter', compact('config'), true);
    }
}

if (!function_exists('get_all_entry_configs'))
{
    function get_all_entry_configs()
    {
        $CI = &get_instance();
        $CI->load->config('entry/config');

        $entry_config_path = config_item('entry_config_path');
        
        $entries = array_map(function($var) use ($entry_config_path) {
            if(substr($var, -4) == '.yml'){
                return pathinfo($entry_config_path.$var);
            }
        }, directory_map($entry_config_path, 1));

        $result = [];
        foreach ($entries as $entry) {
            if(!$entry) continue;
            $yaml = file_get_contents($entry['dirname'].'/'.$entry['basename']);
            $result[$entry['filename']] = \Symfony\Component\Yaml\Yaml::parse($yaml);
            
            // Set default privileges
            $result[$entry['filename']]['privileges'][] = 'entry/'.$entry['filename'];
            $result[$entry['filename']]['privileges'][] = 'entry/'.$entry['filename'].'/add';
            $result[$entry['filename']]['privileges'][] = 'entry/'.$entry['filename'].'/insert';
            $result[$entry['filename']]['privileges'][] = 'entry/'.$entry['filename'].'/edit/:num';
            $result[$entry['filename']]['privileges'][] = 'entry/'.$entry['filename'].'/update/:num';
            $result[$entry['filename']]['privileges'][] = 'entry/'.$entry['filename'].'/delete/:num';
            $result[$entry['filename']]['privileges'][] = 'entry/'.$entry['filename'].'/export_csv';

            // Add custom url and custom menu 
            // for compatibility with admin menu
            if(!isset($result[$entry['filename']]['custom_url']))
                $result[$entry['filename']]['custom_url'] = "admin/entry/{$entry['filename']}/";

            // Define owner id field
            if($result[$entry['filename']]['set_owner'] ?? false)
                $result[$entry['filename']]['fields']['owner'] = [
                    'field' => 'owner',
                    'label' => 'Owner',
                    'form' => 'owner',
                    'type' => 'int',
                    'null' => true,
                    'hide_label' => true
                ];
        }

        return $result;
    }
}

if (!function_exists('get_entry_config'))
{
    function get_entry_config($entry)
    {
        return ci()->Entry_model->get_entry_config($entry);
    }
}

if (!function_exists('setup_entry_model'))
{
    function setup_entry_model($entry)
    {
        // Get entry yaml
        if(!isset(config_item('entries')[$entry])) show_error("Setup entry '$entry' failed, entry not found");
        $entryConf = config_item('entries')[$entry] ?? false;

        // Create main entry model
        $modelName = ucfirst($entry).'Model';
        if(!isset(ci()->$modelName)){
            eval("class $modelName extends MY_Model {};");

            // Register model object to CI global models
            ci()->load->registerModel($modelName, new $modelName($entryConf['table'], $entryConf['fields']));
            ci()->$modelName->protected = ['id'];
        }

        // Instantiate entry relation model object first
        $Relation_model = [];
        foreach ($entryConf['fields'] as $field => $options) 
        {
            if(isset($options['relation']['entry']))
            {
                $relEntry = $options['relation']['entry'];

                $modelName = ucfirst($relEntry).'Model';

                if($options['relation']['model'] ?? null) {
                    ci()->load->model($options['relation']['model_path']);
                    $modelName = $options['relation']['model'];
                }
                
                // Get foreign entry
                elseif($foreign_entry = config_item('entries')[$relEntry] ?? null)
                {
                    // Create children model class on the fly
                    if(! class_exists($modelName, false))
                    {
                        eval("class $modelName extends MY_Model {};");

                        // Register model object to CI global models
                        ci()->load->registerModel($modelName, new $modelName($foreign_entry['table'], $foreign_entry['fields']));
                    }
                
                } else {
                   show_error("Entry $relEntry or native model for $modelName not found.");
                }

                ci()->$modelName->protected = ['id'];

                // Track model relation
                $Relation_model[$relEntry] = [
                    'type' => 'has_one',
                    'modelName' => $modelName,
                    'format' => [
                        'foreign_model' => $modelName, 
                        'foreign_table' => $foreign_entry['table'] ?? ci()->$modelName->table,
                        'foreign_key' => $options['relation']['foreign_key'], 
                        'local_key' => $options['relation']['local_key'],
                        'fields' => $options['relation']['fields'] ?? 'fields:*',
                        'filter' => $options['relation']['filter'] ?? 'filter:null',
                    ]
                ];
            }
        }

        // Instantiate model object
        $Entrydata_model = new MY_Model($entryConf['table'], $entryConf['fields'], $Relation_model);
        $Entrydata_model->protected = ['id'];
        if($entryConf['show_on_table'] ?? null)
            $Entrydata_model->show_on_table = $entryConf['show_on_table'];

        $Entrydata_model->timestamps = $entryConf['timestamps'] ?? true;
        $Entrydata_model->entryConf = $entryConf;

        return $Entrydata_model;
    }

}

// DEPRECATED
if (!function_exists('create_entry_model'))
{
    function create_entry_model($entry)
    {
        // Get entry yaml
        if(!isset(config_item('entries')[$entry])) show_error("Creating entry '$entry' failed, entry not found");
        $entryConf = config_item('entries')[$entry] ?? false;

        $modelName = ucfirst($entry).'Model';
        eval("class $modelName extends MY_Model {};");

        // Register model object to CI global models
        ci()->load->registerModel($modelName, new $modelName($entryConf['table'], $entryConf['fields']));
        ci()->$modelName->protected = ['id'];
    }
}

if (!function_exists('table_explode'))
{
    function table_explode($row_separator, $column_separator, $source)
    {
        $rows = explode($row_separator, $source);
        foreach ($rows as &$row) {
            $row = explode($column_separator, $row);
        }
        return $rows;
    }

}

if (!function_exists('embed_entry_script'))
{
    function embed_entry_script()
    {
        return ci()->load->view('entry/form-script');
    }

}

if (!function_exists('embed_entry_style'))
{
    function embed_entry_style()
    {
        $CI = &get_instance();
        return $CI->load->view('entry/form-style');
    }

}
