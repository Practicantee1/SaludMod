<?php
    function getApiImplantes($typeData = 0, $Episodio, $CentroSanitario = "HSVM"){
        //$TypeData = 0 -> Search by Document
        //$TypeData = 1 -> Search by Episodio
        //$CentroSanitario RSVF= -> Hospital Rionegro
        //$CentroSanitario HSVM= -> Hospital Medellin

        if($Episodio != 0 && $Episodio != ''){

            $username = "po_appintern";  
            $password = "8HQS65oFjZ";
            $data = [];
            $dataR = [];
            $DatosPaciente = [];
            //URL PRODUCTIVO
            $url1 = 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;

            //URL DESARROLLO
            //$url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;

            switch($typeData){
                case 0:

                        $url2 = '&Numero_documento='. $Episodio .'&Datos_ultimo_episodio=X';
            
                        $url = $url1 . $url2;
                        
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL,$url);
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            
                        $response = curl_exec($ch);
                        if(curl_errno($ch)){
                            $error_msg= curl_error($ch);
                            return null;
                        }
                        else{
                            
                            $dataR = json_decode($response, true);
                                
                            if (!is_null($dataR)) {
                                if (array_key_exists('DatosUltimoEpisodio', $dataR) && !is_null($dataR['DatosUltimoEpisodio'])) {
                                    $url3 = '&Episodio=' . $dataR['DatosUltimoEpisodio']['Episodio'] . '&Datos_ultimo_episodio=X&Ubicacion_episodio=X&Diagnostico_episodio=X';
                                    $url = $url1 . $url3;
        
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        
                                    $response = curl_exec($ch);
        
                                    if (curl_errno($ch)) {
                                        curl_close($ch);
                                        return null;
                                    } else {
                                        $dataR = json_decode($response, true);
                                        curl_close($ch);
                                        return $dataR;
                                    }
                                }
                                
                            }
                            else{
                                return null;
                            }
                        }
                            
                        
                    
                break;
                
                case 1:
            
                    $url3 = '&Episodio=' . $Episodio . '&Datos_ultimo_episodio=X&Ubicacion_episodio=X&Diagnostico_episodio=X';
                    $url = $url1 . $url3;
    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    
                    $response = curl_exec($ch);
    
                    if (curl_errno($ch)) {
                        curl_close($ch);
                        return null;
                    } else {
                        $dataR = json_decode($response, true);
                        curl_close($ch);
                        return $dataR;
                    }
                    
                
            }
        } 
    } 
?>