<?php

include('conn.php');

if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    //operación read
    if($accion== 'leer'){
        $sql = "select * from autos where 1";
        $result = $db->query($sql);

        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $items['id']=$fila['id'];
                $items['marca'] = $fila['marca'];
                $items['modelo'] = $fila['modelo'];
                $items['year'] = $fila['year'];
                $items['no_serie'] = $fila['no_serie'];
                $items['id_cliente'] = $fila['id_cliente'];
                $arrAutos[]=$items;
            }
            $response["status"]="ok";
            $response["mensaje"]=$arrAutos;
        }
        else{
            $response["status"]="Error";
            $response["mensaje"]="No hay autos registrados";
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
        $marca= $data['marca'];
        $modelo= $data['modelo'];
        $year = $data['year'];
        $no_serie = $data['no_serie'];
        $id_cliente = $data['id_cliente'];

        $qry = "insert into autos (marca, modelo, year, no_serie, id_cliente) values('$marca','$modelo','$year','$no_serie','$id_cliente')";
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
    $marca = $data["marca"];
    $modelo = $data["modelo"];
    $year = $data["year"];
    $no_serie = $data["no_serie"];
    $id_cliente = $data["id_cliente"];

    $qry = "update autos set marca='$marca', modelo='$modelo', year='$year', no_serie='$no_serie', id_cliente = '$id_cliente' where id='$id'";
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

    $qry = "delete from autos where id='$id'";
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