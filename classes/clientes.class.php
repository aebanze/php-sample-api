<?php

class Clientes
{
    public function listarTodos()
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM clientes ORDER BY nome");
        $rs->execute();
        $obj = $rs->fetchAll(PDO::FETCH_ASSOC);

        if($obj){
            echo json_encode(["dados" => $obj]);
        } else{
            echo json_encode(["dados" => "sem dados para visualizar"]);
        }
    }

    public function listarUnico($param)
    {
        $db = DB::connect();
        $rs = $db->prepare("SELECT * FROM clientes WHERE id={$param}");
        $rs->execute();
        $obj = $rs->fetchObject();

        if($obj){
            echo json_encode(["dados" => $obj]);
        } else{
            echo json_encode(["dados" => "sem dados para visualizar"]);
        }
    }

    public function adicionar()
    {
        $sql = "INSERT INTO clientes (";

        //contador para virgula
        $cont = 1;
        foreach (array_keys($_POST) as $indice) {
            if(count($_POST) > $cont){
                $sql .= "{$indice},";
            } else {
                $sql .= "{$indice}";
            }
            $cont++;
        }

        $sql .= ") VALUES (";
        
        //contador para virgula
        $cont = 1;
        foreach (array_values($_POST) as $valor) {
            if(count($_POST) > $cont){
                $sql .= "'{$valor}',";
            } else {
                $sql .= "'{$valor}'";
            }
            $cont++;
        }

        $sql .= ")";

        $db = DB::connect();
        $rs = $db->prepare($sql);
        $exec = $rs->execute();

        if($exec){
            echo json_encode(["dados" => 'Dados inseridos com sucesso.']);
        }else{
            echo json_encode(["dados" => 'Erro ao inserir os dados']);
        }
    }

    public function actualizar($param)
    {
        //Eliminar primeiro dado do array
        array_shift($_POST);

        // *UPDATE clientes SET nome = `novo nome`, email = `novo email` WHERE id= id*

        $sql = "UPDATE clientes SET ";

        //variavel contadora para a virgula
        $cont = 1;
        foreach (array_keys($_POST) as $indice){
            if(count($_POST) > $cont){
                $sql .= "{$indice} = '{$_POST[$indice]}', ";
            }else{
                $sql .= "{$indice} = '{$_POST[$indice]}' ";
            }
            $cont++;
        }
        $sql .= "WHERE id = {$param}";

        $db = DB::connect();
        $rs = $db->prepare($sql);
        $exec = $rs->execute();

        if($exec){
            echo json_encode(["dados" => 'Dados actualizados com sucesso.']);
        }else{
            echo json_encode(["dados" => 'Erro ao actualizar os dados']);
        }
    }

    public function apagar($param)
    {
        //"DELETE FROM clientes WHERE id = {$param}"

        $db = DB::connect();
        $rs = $db->prepare("DELETE FROM clientes WHERE id = {$param}");
        $exec = $rs->execute();

        if($exec){
            echo json_encode(["dados" => 'Os dados foram excluidos com sucesso.']);
        }else{
            echo json_encode(["dados" => 'Houve um erro ao excluir os dados']);
        }
    }
}