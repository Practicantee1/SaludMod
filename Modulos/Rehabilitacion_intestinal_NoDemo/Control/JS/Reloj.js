var Tiempo=document.getElementById('hora');
var Fecha = document.getElementById('fecha');

function relojDigital(){
    f =new Date();
    dia = f.getDate();
    mes = f.getMonth()+1;
    anio = f.getFullYear();
    diasemana = f.getDay();

    dia= ('0'+dia).slice(-2);
    mes= ('0'+mes).slice(-2);

    var FechaCompleta =  anio + "-" + mes + "-" + dia;

    var timeString= f.toLocaleTimeString();
    if(timeString.split(":")[0] < 10){
        Tiempo.value = "0" + timeString;
    }
    else{
        Tiempo.value = timeString;
    }
    

    Fecha.value = FechaCompleta;

}


setInterval( ()=>{
    relojDigital()
},1000);

