
        <?php 
    //CONEXIÓN A LA API PARA BUSCAR CON NUMERO DE IDENTIFICACIÓN
    function getApi($typeData = 0, $IdentityNum, $CentroSanitario = "HSVM"){
        //$TypeData = 0 -> Search by Document
        //$TypeData = 1 -> Search by Episodio
        //$CentroSanitario RSVF= -> Hospital Rionegro
        //$CentroSanitario HSVM= -> Hospital Medellin

        if($IdentityNum != 0 && $IdentityNum != ''){

            $username = "po_appintern";  
            //$password = "8HQS65oFjZ";
	        $password = "3AqHS4MJIM";
            $data = [];
            $dataR = [];

            //URL DESARROLLO
            $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;

            //URL CALIDAD
            //$url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;

            //URL PRODUCTIVO
            //$url1 = 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;


            switch($typeData){
                case 0:

                        $url2 = '&Numero_documento='. $IdentityNum .'&Datos_ultimo_episodio=X';
            
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
                                
                            if(!is_null($dataR)){
                                if(array_key_exists('DatosUltimoEpisodio', $dataR) && !is_null($dataR['DatosUltimoEpisodio'])){
            
                                    $url3 = '&Episodio='. $dataR['DatosUltimoEpisodio']['Episodio'] .'&Datos_ultimo_episodio=X&Ubicacion_episodio=X&Diagnostico_episodio=X';
            
                                    $url .= $url3;
            
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
            
                    $url3 = '&Episodio='.$IdentityNum.'&Datos_ultimo_episodio=X&Ubicacion_episodio=X&Diagnostico_episodio=X&MonitorIQ=X';  //Esto es muy importante, añadir el parámetro

                    $url = $url1.$url3;

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
                        return $dataR;
                    }
                    
                
            }
        } 
    }

    //CONEXIÓN A LA API PARA BUSCAR CITAS CON EL NÚMERO DE IDENTIFICACIÓN
    function getAppointmentList($IdentityNum, $CentroSanitario  = "HSVM", $TipoDocumento = "CC") {
        //$CentroSanitario RSVF= -> Hospital Rionegro
        //$CentroSanitario HSVM= -> Hospital Medellin
    
        if ($IdentityNum != 0 && $IdentityNum != '') {
    
            $username = "po_appintern";  
            $password = "3AqHS4MJIM";
            
            // URL Desarrollo
            $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/appointmentlistpatient?Centro_Sanitario='.$CentroSanitario;
    
            $url2 = '&TDocumento='.$TipoDocumento.'&NDocumento='.$IdentityNum;
            
            $url = $url1 . $url2;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                return null;
            } else {
                $dataR = json_decode($response, true);
                return $dataR;
            }
        } else {
            return null;
        }
    }
    
    //CONEXIÓN A LA API PARA BUSCAR CON EL NÚMERO DE EPISODIO
    function getAppointment($typeData , $Episodio, $CentroSanitario="HSVM") { //COLOCAR LOS NOMBRES DE LAS FUNCIONES DIFERENTES PARA NO INTERFERRIR
        if ($Episodio != 0 && $Episodio != '') {
            $username = "po_appintern";  
            $password = "8HQS65oFjZ";
            $dataR = [];
    
            // URL DESARROLLO
            // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL CALIDAD
            // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL PRODUCTIVO
            $url1 = 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            switch ($typeData) {
                case 0:
                    $url2 = '&Episodio=' . $Episodio . '&Datos_ultimo_episodio=X';
                    $url = $url1 . $url2;
    
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
                        } else {
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
        return null; // Return null if $Episodio is 0 or empty
    }

    function getEpidemiologiaApi($Episodio, $CentroSanitario) { //COLOCAR LOS NOMBRES DE LAS FUNCIONES DIFERENTES PARA NO INTERFERRIR
        
        if ($Episodio != 0 && $Episodio != '') {      
            $username = "po_appintern";  
            //$password = "8HQS65oFjZ";
            $password = "3AqHS4MJIM";
            $dataR = [];
    
            // URL DESARROLLO
            $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL CALIDAD
            //$url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL PRODUCTIVO
            //$url1 = 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;


                    $url3 = '&Episodio=' . $Episodio . '&Datos_ultimo_episodio=X&Diagnostico_episodio=X&Ubicacion_episodio=X';
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
            } return null;// Return null if $Episodio is 0 or empty
    }
    function getApiOdonto($Episodio, $CentroSanitario) { //COLOCAR LOS NOMBRES DE LAS FUNCIONES DIFERENTES PARA NO INTERFERRIR
    
        if ($Episodio != 0 && $Episodio != '') {      
            $username = "po_appintern";  
            $password = "8HQS65oFjZ";
            $dataR = [];
    
            // URL DESARROLLO
            // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL CALIDAD
            //$url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL PRODUCTIVO
            $url1 = 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;


                    $url3 = '&Episodio=' . $Episodio . '&Datos_ultimo_episodio=X&Diagnostico_episodio=X&Ubicacion_episodio=X';
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
            } return null;// Return null if $Episodio is 0 or empty
        }

        function getProg_edu_API($IdentityNum) {
            //$CentroSanitario RSVF= -> Hospital Rionegro
            //$CentroSanitario HSVM= -> Hospital Medellin
            $CentroSanitario = "HSVM";
            if ($IdentityNum != 0 && $IdentityNum != '') {
        
                $username = "po_appintern";  
                $password = "8HQS65oFjZ";
                
                    //calidad
                    //$url = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario=' . $CentroSanitario . '&Episodio=' . $IdentityNum;
                    // productivo
                    $url= 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario=HSVM&Ubicacion_episodio=x&Numero_documento='. $IdentityNum. "&Datos_ultimo_episodio=x&Diagnostico_episodio=x" ;
                
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
            return null;
        }
        function getDerechoMorirDignamenteApi($numeroDocumento, $CentroSanitario ) { //COLOCAR LOS NOMBRES DE LAS FUNCIONES DIFERENTES PARA NO INTERFERRIR
        
            if ($numeroDocumento != 0 && $numeroDocumento != '') {      
                $username = "po_appintern";  
                $password = "8HQS65oFjZ";
                $dataR = [];
        
                // URL DESARROLLO
                // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
        
                // URL CALIDAD
                // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
        
                // URL PRODUCTIVO
                $url1 = 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
    
                        $url3 = '&Numero_documento=' . $numeroDocumento . '&Datos_ultimo_episodio=x&Ubicacion_episodio=x';
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
            return null;// Return null if $Episodio is 0 or empty
        }
	 function getUbicacionXnombreApi($primerNombre,$primerApellido,$segundoApellido, $CentroSanitario="HSVM" ) { //COLOCAR LOS NOMBRES DE LAS FUNCIONES DIFERENTES PARA NO INTERFERRIR
        
            if (($primerNombre != 0 && $primerNombre != '')|| ($primerApellido != 0 && $primerApellido != '')||($segundoApellido != 0 && $segundoApellido != '')) {      
                $username = "po_appintern";  
                $password = "3AqHS4MJIM";
                $dataR = [];
        
                // URL DESARROLLO
                // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
        
                // URL CALIDAD
                // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
        
                // URL PRODUCTIVO
                 $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/v1/busquedapaciente?CentroSanitario=RSVF&PrimerNombre='.$primerNombre.'&PrimerApellido='.$primerApellido.'&ReadNPAP=false';    

                    if(($primerNombre != 0 && $primerNombre != '')&&($primerApellido != 0 && $primerApellido != '')&&($segundoApellido != 0 && $segundoApellido != '')){
                        $url3 = '&PrimerNombre='. $primerNombre .'&PrimerApellido='. $primerApellido .'&SegundoApellido='. $segundoApellido;
                    }else
                    if(($primerNombre != 0 && $primerNombre != '')&&($primerApellido != 0 && $primerApellido != '')){
                        $url3 = '&PrimerNombre=' . $primerNombre.'&PrimerApellido='. $primerApellido."&ReadNPAP=false";
                    }else
                    if(($primerNombre != 0 && $primerNombre != '')&&($segundoApellido != 0 && $segundoApellido != '')){
                        $url3 = '&PrimerNombre=' . $primerNombre.'&SegundoApellido='. $segundoApellido."&ReadNPAP=false";
                    }else
                    if(($primerApellido != 0 && $primerApellido != '')&&($segundoApellido != 0 && $segundoApellido != '')){
                        $url3 = '&PrimerApellido=' . $primerApellido.'&SegundoApellido='. $segundoApellido."&ReadNPAP=false";
                    }
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
            return null;// Return null if $Episodio is 0 or empty
        }
	function getApiRehabilitacion($Episodio, $CentroSanitario="HSVM" ) { //COLOCAR LOS NOMBRES DE LAS FUNCIONES DIFERENTES PARA NO INTERFERRIR
    
        if ($Episodio != 0 && $Episodio != '') {      
            $username = "po_appintern";  
            $password = "8HQS65oFjZ";
            $dataR = [];
    
            // URL DESARROLLO
            // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL CALIDAD
            // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL PRODUCTIVO
            $url1 = 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;


                    $url3 = '&Episodio=' . $Episodio . '&Datos_ultimo_episodio=X&Diagnostico_episodio=X&Ubicacion_episodio=X';
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
            } return null;// Return null if $Episodio is 0 or empty
    }
     

        function getRestriccionesApi($Episodio, $CentroSanitario="HSVM" ) { //COLOCAR LOS NOMBRES DE LAS FUNCIONES DIFERENTES PARA NO INTERFERRIR
        
        if ($Episodio != 0 && $Episodio != '') {      
            $username = "po_appintern";  
            $password = "8HQS65oFjZ";
              // $password = "3AqHS4MJIM";
            $dataR = [];
    
            // URL DESARROLLO
            // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_dev/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL CALIDAD
            // $url1 = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;
    
            // URL PRODUCTIVO
            $url1 = 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario='.$CentroSanitario;


                    $url3 = '&Episodio=' . $Episodio . '&Datos_ultimo_episodio=X&Diagnostico_episodio=X&Ubicacion_episodio=X';
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
            } return null;// Return null if $Episodio is 0 or empty
    }


        ?>

       

        
