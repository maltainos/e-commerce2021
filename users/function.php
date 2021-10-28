<?php
    require "require/connection.php";
    /**
     * @param Table name to find datas
     * @return Results find in table
     */
    function findAll($table){
        global $conn;
        $sql = "SELECT * FROM {$table}";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findOne($table, $id){
        global $conn;
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$id, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findOneCondiction($table,$condiction, $id){
        global $conn;
        $sql = "SELECT * FROM {$table} WHERE {$condiction} = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$id, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function saveImage($imagem, $imagem_tmp){
        $imagem = date('y-m-d')."".time()."".$imagem;
        move_uploaded_file($imagem_tmp,"assets/images/products/$imagem");
        move_uploaded_file($imagem_tmp,"../assets/images/products/$imagem");
        return $imagem;
    }

    function findAllAndJoinTables($product, $category, $subCategory){
        global $conn;
        $sql = "SELECT * FROM {$product} as p INNER JOIN 
                {$category} as c INNER JOIN {$subCategory} as sc WHERE p.category_id = c.id AND p.sub_category_id = sc.id";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findAllAndJoin($category, $subCategory){
        global $conn;
        $sql = "SELECT * FROM {$category} as c INNER JOIN {$subCategory} as sc WHERE sc.category_id = c.id";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findAllToOne($table, $id){
        global $conn;
        $sql = "SELECT * FROM {$table} WHERE category_id = :category_id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':category_id',$id, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function create($sql,$data){
        global $conn;
        $statement->execute();
        if($conn->lastInsertId()){
            $_SESSION['success'] = "<strong>{$data}</strong> guardado com sucesso!";
        }else{
            $_SESSION['unsuccess'] = "<strong>{$data}</strong> nao salvo com sucesso";
        }
    }
?>