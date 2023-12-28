<?php

    if(!empty($_GET['id_produtos']))
    {
        include('config.php');

        $id_produtos = $_GET['id_produtos'];

        $sqlSelect = "SELECT *  FROM produtos WHERE id_produtos=$id_produtos";

        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
            $sqlDelete = "DELETE FROM produtos WHERE id_produtos=$id_produtos";
            $resultDelete = $conexao->query($sqlDelete);
        }
    }
    header('Location: ../adm.php');
   
?>