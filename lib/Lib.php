<?php
/**
 *
 */
class Lib {
	private $path;

	 function __construct($path) {
		$this->path= $path;
		?>
		<script src="<?=$path.'/'?>jquery19.js"></script>
		<?php
	}

	public function jqui(){
		?>
		<script src="<?= $this->path.'/' ?>jqui/js/jquery-ui-1.10.3.custom.js"></script>
		<link rel="stylesheet" href="<?= $this->path.'/' ?>jqui/css/estilo1.css" />
		<?php
	}

	public function ldap(){
		require_once 'ldap/adLDAP.php';
	}

	public function tablas(){
		?>
		<link rel="stylesheet" href="<?= $this->path.'/' ?>tablas/tablas.css" />
		<?php
	}

	public function validador(){
		?>
		<script src="<?= $this->path.'/' ?>validador/live.js"></script>
		<?php
	}
	public function excelLib(){
            require_once './excelib/PHPExcel.php';
	}
        
        public function mailer(){
            require_once $this->path.'/mailer/PHPMailerAutoload.php';
        }


}

?>