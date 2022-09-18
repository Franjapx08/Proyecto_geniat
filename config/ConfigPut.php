<?php


class ConfigPut{

    public static function getDataFromPut($form_data)
    {
        /* inicializar variable global */
        $GLOBALS["_PUT"] = null; 
        /* configuraciones */
        $key_size = 52;
        $key = substr($form_data, 1, $key_size);
        $acc_params = explode($key, $form_data);
        array_shift($acc_params);
        array_pop($acc_params);
        /* obtener valores enviados */
        foreach ($acc_params as $item){
        $start_key=' name=\"';
            $end_key = '\"\r\n\r\n';
            $start_key_pos = strpos($item,$start_key)+strlen($start_key);
            $end_key_pos = strpos($item,$end_key);
                
            $key = substr($item, $start_key_pos, ($end_key_pos-$start_key_pos));
            
            $end_value = '\r\n';
            $value = substr($item, $end_key_pos+strlen($end_key), -strlen($end_value));
            $_PUT[$key] = $value;
        }
        return $GLOBALS["_PUT"] = $_PUT;
    }

}