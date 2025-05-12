
<?php
class ZplPrinter{
        
        public function __construct() {
        }
        
        public static function send($label, $printer, $printD = true, $debug = false) {
                            
            // Crear archivo temporal
            $file = tempnam(sys_get_temp_dir(), 'lbl');
            
            // Abrir archivo para escritura
            $handle = fopen($file, "w");
            fwrite($handle, $label);
            fclose($handle); // Cerra el archivo        
    
            if ($printD) {
                // Imprimir archivo
                $pcname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		//$print =  exec('lp -d ' . '127.0.0.1' . '/' . $printer . '" "' . $file . '"');

		$print =  exec('print /d:"\\\\' . '127.0.0.1' . '\\' . $printer . '" "' . $file . '"');
                //$print =  exec('print /d:"\\\\' . 'ML-120820' . '\\' . $printer . '" "' . $file . '"');
                //$print =  exec('print /d:"\\\\' . $pcname . '\\' . $printer . '" "' . $file . '"');
                //$print =  exec('print /d:"\\\%COMPUTERNAME%\\' . $printer . '" "' . $file . '"');
            }             
            
            // Eliminar archivo
            $delete =  unlink($file);
    
            if ($debug) {
                /*echo ("<h4>Comandos ZPL: ".$label."</h4>");
                echo ("<h4>Archivo temporal eliminado: ".$delete."</h4>");
    
                if ($printD) {
                    echo ("<h4>Impresión: ".$print."</h4>");
                }else{
                    echo ("<h4>Impresión: La impresión esta desactivada (habilitar en la función send).</h4>");
                }       */    
            }
         }

        public static function compile($data, $quantity = 1){
           // Crear encabezado de la etiqueta
           $compiled = ''.(new ZplPrinter())->_eol();
        
           // Juntar los datos
           $compiled .= $data;

           // Añadir el final de la etiqueta
           $compiled .= ',' . (int) $quantity . (new ZplPrinter())->_eol();
        
           return $compiled;
        }
         
        protected function _eol(){
           return PHP_EOL;
        }

}
?>