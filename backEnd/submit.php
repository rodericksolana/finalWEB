<?php
/**
 * Created by IntelliJ IDEA.
 * User: rodericksolana
 * Date: 30/11/16
 * Time: 04:59 PM
 */

session_start();

include_once("config.php");

//require_once("login.php");

if(isset($_POST["login"])){

    $Pwd=$_POST["Pwd"];
    $eMail=$_POST["eMail"];
    if(!empty($eMail) && !empty($Pwd)){
        $sql = "select idUsuario, TipoUsuario from exf_Usuarios where eMail='$eMail' and Pwd= '$Pwd'";

        $nume = mysqli_query($con, $sql) or die ('Query incorrecto: ' . $sql);
        //echo "Terminé el query";
        //echo $num;
        if(mysqli_num_rows($nume) > 0) {


            while ($rows = $nume->fetch_assoc()) {
                if($rows['TipoUsuario'] == 1) {
                    $_SESSION["idSession"] = $rows['idUsuario'];
                    header("Location:../admin.html");

                }

                else {
                    header("Location:../cliente.html");

                }

            }


        }
        else {

            echo '<script language="javascript">alert("Datos Incorrectos");
                    var url = "http://ubiquitous.csf.itesm.mx/~daw-1129839/ExFin/login.html";
                    window.location.href = url;</script>';

        }

    }
    else
        //header("Location:error.html");
        echo "Falta uno de los datos";
        echo "PWD: ";  echo $Pwd;
    echo "eMail: ";  echo $eMail;
}
else if(isset($_POST["register"])){

    $eMail=$_POST['eMail'];
    $Pwd=$_POST['Pwd'];
    $Nombre=$_POST['Nombre'];
    $ApPaterno=$_POST['ApPaterno'];
    echo"PAterno";
    echo $ApPaterno;

    if(!empty($eMail) && !empty($Pwd))
    {

        $sql = "select idUsuario from exf_Usuarios where eMail='$eMail'";

        $res = mysqli_query($con, $sql) or die ('Query incorrecto: ' . $sql);

        if(mysqli_num_rows($res) > 0) {
            echo '<script language="javascript">alert("ERROR! Ese correo ya se ha registrado antes");
                    var url = "http://ubiquitous.csf.itesm.mx/~daw-1129839/ExFin/login.html";
                    window.location.href = url;</script>';
        }

        else
        {

            $sql = "insert into exf_Usuarios (eMail, Pwd, TipoUsuario) values ('$eMail','$Pwd', 0)";

            $res = mysqli_query($con, $sql) or die ('Query incorrecto: ' . $sql);

            $sql = "select idUsuario from exf_Usuarios where eMail='$eMail' and Pwd= '$Pwd'";

            $res = mysqli_query($con, $sql) or die ('Query incorrecto: ' . $sql);

            while ($rows = $res->fetch_assoc()) {
                echo "adentro del while: ";
                echo $rows['idUsuario'];
                $sql = "insert into exf_Clientes (idUsuario, Nombre, ApPaterno) values (\"".$rows['idUsuario']."\",'$Nombre', '$ApPaterno')";
                $res2 = mysqli_query($con, $sql) or die ('Query incorrecto: ' . $sql);
                echo "inserte";
            }

echo "Final del if";
           /* echo '<script language="javascript">
                    var url = "http://ubiquitous.csf.itesm.mx/~daw-1129839/ExFin/registraCliente.html";
                    window.location.href = url;</script>';*/
        }





    }
}

?>
