<meta charset="utf-8">
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/custom.css">
    <link rel=icon href='img/logo-icon.png' sizes="32x32" type="image/png">

    <script src="libraries/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="libraries/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <script>
     comprobar();
    function comprobar(){
        mensaje="Ya son las 7!!";

        var d = new Date();

        var hora = ('0'+((d.getHours()+11)%12 + 1)).slice(-2);
        var minutos = ('0'+d.getMinutes()).slice(-2);
        var tar =  ((d.getHours() >= 12)? 'PM':'AM')

        if(hora=="04" && minutos=="00" && tar == "PM"){
            $.ajax({
                url: './ajax/update_reservas.php',
                type: 'POST',
                data: 'idbus=0',
                dataType: "json",
                beforeSend: function() {
                   
                },
                success: function(response) {
                    
                },
                complete: function(datos) {
                   if (datos.responseText == 1) {
                    Swal('Mensaje','Los asientos reservados se liberaron', 'success');
                   }
                  
                }
            });
        }else{
            console.log(hora+minutos+tar);
        }
        window.setTimeout("comprobar()",60000);
    }
</script>