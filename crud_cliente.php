<?php

include('conn.php');

if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    //operación read
    if($accion== 'leer'){
        $sql = "select * from cliente where 1";
        $result = $db->query($sql);

        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $items['id']=$fila['id'];
                $items['nombre'] = $fila['nombre'];
                $items['apellido1'] = $fila['apellido1'];
                $items['apellido2'] = $fila['apellido2'];
                $items['email'] = $fila['email'];
                $arrClientes[]=$items;
            }
            $response["status"]="ok";
            $response["mensaje"]=$arrClientes;
        }
        else{
            $response["status"]="Error";
            $response["mensaje"]="No hay clientes registrados";
        }
        echo json_encode($response);
    }
}   

$data = json_decode(file_get_contents('php://input'),true);
//pasar datos desde postman
    
//operación create
if(isset($data)){
    $accion = $data["accion"];

    if($accion == 'insertar'){
        $nombre= $data['nombre'];
        $apellido1= $data['apellido1'];
        $apellido2 = $data['apellido2'];
        $email = $data['email'];

        $qry = "insert into cliente (nombre, apellido1, apellido2,email) values('$nombre','$apellido1','$apellido2','$email')";
        if($db->query($qry)){
            $response["status"] = "OK";
            $response["mensaje"] = "El registro se agregó correctamente";
        }
        else{
            $response["status"] = "ERROR";
            $response["mensaje"] = "Ocurrió un error";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

//operación update
if($accion == 'modificar'){
    $id = $data["id"];
    $nombre= $data['nombre'];
    $apellido1= $data['apellido1'];
    $apellido2 = $data['apellido2'];
    $email = $data['email'];

    $qry = "update cliente set nombre='$nombre', apellido1='$apellido1', apellido2='$apellido2', email='$email' where id='$id'";
        if($db->query($qry)){
            $response["status"] = "OK";
            $response["mensaje"]="El registro se modificó correctamente";
        }
        else{
            $response["status"] = "ERROR";
            $response["mensaje"]="El registro no se pudo modificar debido a un error";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
}

if($accion == 'eliminar'){
    $id = $data["id"];

    $qry = "delete from cliente where id='$id'";
        if($db->query($qry)){
            $response["status"] = "OK";
            $response["mensaje"]="El registro se eliminó correctamente";
        }
        else{
            $response["status"] = "ERROR";
            $response["mensaje"]="El registro no se pudo eliminar debido a un error";
        }

        header('Content-Type: application/json');
        echo json_encode($response);
}