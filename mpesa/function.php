<?php
    session_start();
    require "../require/connection.php";

    $authenticate = 0;
    if(isset($_SESSION['authenticate'])){
        $authenticate = $_SESSION['authenticate'];
    }
    /**
     * @param Table name to find datas
     * @return Results find in table
     */

     function generatedSaleCode($length){
        $aphabet = "0123456789";
        $returnValue = "";
        for($i = 0; $i < $length; $i++){
            $random = random_int(0,strlen($aphabet));
            $returnValue = $returnValue."".substr($aphabet,$random,1);
        }
        return $returnValue;
     }
    function createSale(){
        global $conn;
        global $authenticate;
        $code = generatedSaleCode(15);
        $sql_query = "INSERT INTO sales(user_id,sale_code) VALUES (:user,:code)";
		$user = 3;
		$statement = $conn->prepare($sql_query);
		$statement->bindParam(':user',$authenticate, PDO::PARAM_INT);
        $statement->bindParam(':code',$code);
		$statement->execute();
		$ultimo = $conn->lastInsertId();
        return $ultimo;
    }

    function saleItem($sale,$product,$quantity,$total,$color,$size,$telefone){
        global $conn;
        $sql_query = "INSERT INTO items_sales(product_id, sale_id,quantity, price,color_id,size_id,telefone) 
			VALUES (:product,:sale_id,:quantity,:price,:color,:size,:telefone)";
		$statement = $conn->prepare($sql_query);
		$statement->bindParam(':product',$product, PDO::PARAM_INT);
		$statement->bindParam(':sale_id',$sale, PDO::PARAM_INT);
		$statement->bindParam(':quantity',$quantity, PDO::PARAM_INT);
		$statement->bindParam(':price',$total);
		$statement->bindParam(':color',$color,PDO::PARAM_INT);
		$statement->bindParam(':size',$size,PDO::PARAM_INT);
		$statement->bindParam(':telefone',$telefone,PDO::PARAM_INT);
		$statement->execute();
        updateProduct($product,$quantity);
		$ultimo = $conn->lastInsertId();
        return $ultimo;
    }

    function disponivel($product){
        global $conn;
        $sql_query = "SELECT quantity FROM products WHERE product_id = :product";
        $statement = $conn->prepare($sql_query);
        $statement->bindParam(':product', $product, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results; 
    }

    function updateProduct($product,$quantity){
        $availables = disponivel($product);
        foreach($availables as $available)
            $now = $available;
        $quantity = $now - $quantity;
        global $conn;
        $sql_query = "UPDATE products SET quantity = :quantity WHERE id = :product";
		$statement = $conn->prepare($sql_query);
		$statement->bindParam(':product',$product, PDO::PARAM_INT);
		$statement->bindParam(':quantity',$quantity, PDO::PARAM_INT);
		$statement->execute();
    }

    function createDelivery($telefone,$sale,$province,$code){
        global $conn;
        global $authenticate;
        $sql_query = "INSERT INTO delivery(user_id,province,sale_id,p_code,contact) 
                VALUES (:user,:phone,:sale,:province,:code)";
		$statement = $conn->prepare($sql_query);
		$statement->bindParam(':user',$authenticate, PDO::PARAM_INT);
		$statement->bindParam(':phone',$telefone, PDO::PARAM_INT);
		$statement->bindParam(':sale',$sale, PDO::PARAM_INT);
        $statement->bindParam(':province',$province, PDO::PARAM_INT);
		$statement->bindParam(':code',$code, PDO::PARAM_INT);
		$statement->execute();
        $ultimo = $conn->lastInsertId();
        $_SESSION['payment'] = "Pagamento efectuado com sucesso, enviamos um email de confirmacao!";
        return $ultimo;
    }

    function email(){
        global $conn;
        global $authenticate;
        $sql_query = "SELECT email FROM users WHERE id = :id";
		$statement = $conn->prepare($sql_query);
		$statement->bindParam(':id',$authenticate, PDO::PARAM_INT);
		$statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach($users as $user)
            $email = $user->email;
        return $email;
    }

    include "enviarLink.php";
    $email = email();

?>