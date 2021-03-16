<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Qa Lib
 * 
 * @author Oriza
 * @package Question to answer.
 */

class QaLib
{
	public function getProfile($id)
    {
        return $this->request('GET', 'https://forum.codepolitan.com/qa-external/qa-rest.php?p=getUserPoint&userid=' . $id);
    }

    public function request($method, $url, $param = null)
    {
        if ($method == 'POST')
        {
            $ch = curl_init();
            
            $param = http_build_query($param);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close($ch);
            
            return true;
        }
        else if ($method == 'GET')
        {
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close($ch);

            if (!empty($server_output))
                return json_decode($server_output);

            return false;
        }
        
        return false;
    }
}