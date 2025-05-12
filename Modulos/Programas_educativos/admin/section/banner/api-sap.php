<?php
function getSAP($episodio ) {
    $IdentityNum = $episodio; //0004164656
    $CentroSanitario = 'HSVM';
    $username = "po_appintern";
    $password = "8HQS65oFjZ";
    //calidad
    //$url = 'http://aspod.hospital.com:50000/RESTAdapter/appinternos_qas/datosdemograficospaciente?Centro_Sanitario=' . $CentroSanitario . '&Episodio=' . $IdentityNum;
    // productivo
    $url= 'http://aspop.hospital.com:50000/RESTAdapter/appinternos_prd/datosdemograficospaciente?Centro_Sanitario=' . $CentroSanitario . '&Episodio=' . $IdentityNum;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $respuestas = curl_exec($ch);
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ['error' => $error_msg]; // Retornar el error
    }
    curl_close($ch);
   
    $data = json_decode($respuestas, true);

    if ($data === null) {
        return ['error' => 'JSON decode error'];
    }
   
    return $data;
}
?>
