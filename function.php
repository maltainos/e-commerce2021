<?php
    $authenticate = 0;
    if(isset($_SESSION['authenticate'])){
        $authenticate = $_SESSION['authenticate'];
    }
    /**
     * @param Table name to find datas
     * @return Results find in table
     */

     function generatedUserId($length){
        $aphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVXWYZabcdefghijklmnopqrstuvxwyz";
        $returnValue = "";
        for($i = 0; $i < $length; $i++){
            $random = random_int(0,strlen($aphabet));
            $returnValue = $returnValue."".substr($aphabet,$random,1);
        }
        return $returnValue;
     }

     function registerCustomer($nome, $apelido, $email, $password){
        global $conn;
        $sql = "INSERT INTO users(user_id, first_name, last_name, 
                email, encrypt_password) VALUES (:userId, :nome, 
                :apelido, :email, :encrypto)";
        $statement = $conn->prepare($sql);
        $userId = generatedUserId(30);
        $statement->bindParam(':userId', $userId, PDO::PARAM_STR);
        $statement->bindParam(':nome', $nome, PDO::PARAM_STR);
        $statement->bindParam(':apelido', $apelido, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':encrypto', $password, PDO::PARAM_STR);
        $statement->execute();
        $lastInsert = $conn->lastInsertId();
        if($lastInsert){
            $_SESSION['error'] = "Bem vindo a Eshopper...!";
            $_SESSION['login'] = "Ok";
			$_SESSION['typeuser'] = "customer";
			$_SESSION['email'] = $email;
			$_SESSION['first_name'] = $nome;
			$_SESSION['last_name'] = $apelido;
			$_SESSION['user_id'] = $userId;
			$_SESSION['authenticate'] = $lastInsert;
            $sql_cart = "INSERT INTO cart(user_id) VALUES (:userId)";
            $statement = $conn->prepare($sql_cart);
            $statement->bindParam(':userId', $lastInsert, PDO::PARAM_INT);
            $statement->execute();
            $sql_whishlist = "INSERT INTO whishlist(user_id) VALUES (:userId)";
            $statement = $conn->prepare($sql_whishlist);
            $statement->bindParam(':userId', $lastInsert, PDO::PARAM_INT);
            $statement->execute();
            header("location:shop?user=new%customer");
        }else{            
            $_SESSION['error'] = "Ops..! Lamentamos mais houve um erro ao criar sua conta..";
        }
     }

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

    function findAllAndJoinTablesDetails($product, $category, $subCategory,$condiction,$value){
        global $conn;
        $sql = "SELECT * FROM {$product} as p INNER JOIN 
                {$category} as c INNER JOIN {$subCategory} as sc WHERE p.category_id = c.id AND p.sub_category_id = sc.id AND {$condiction}=:condiction";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':condiction',$value, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function cartUser(){
        global $conn;
        global $authenticate;
        $sql = "SELECT id FROM cart  WHERE  user_id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$authenticate, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function countCart(){
        global $conn;
        $cartResult = cartUser();
        $cartId = 0;
        foreach($cartResult as $cartItem)
            $cartId = $cartItem->id;
        $sql = "SELECT count(id) as cart_shopping FROM cart_itens  WHERE  cart_id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$cartId, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function addCart($product){
        global $conn;
        $cartResult = cartUser();
        $cartId = 0;
        foreach($cartResult as $cartItem)
            $cartId = $cartItem->id;
        $sql_cart_find = "SELECT count(id) as register FROM cart_itens WHERE 
                cart_id = :cart AND product_id = :product";
        $statement = $conn->prepare($sql_cart_find);
        $statement->bindParam(':product', $product,PDO::PARAM_INT);
        $statement->bindParam(':cart', $cartId,PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        foreach($results as $result)
            $all = $result->register;
        if($all > 0)
            $_SESSION['error'] = "Este producto nao foi adicionado a carinha anteriormente";
        else{
            $sql_cart = "INSERT INTO cart_itens (product_id , cart_id) VALUES (:product,:cart)";
            $statement = $conn->prepare($sql_cart);
            $statement->bindParam(':product', $product,PDO::PARAM_INT);
            $statement->bindParam(':cart', $cartId,PDO::PARAM_INT);
            $statement->execute();
            if($conn->lastInsertId()) $_SESSION['sucesso'] = "Producto adicionado a carinha";
            else $_SESSION['error'] = "Producto nao foi adicionado a carinha";
        }  
    }

    function wishilistUser(){
        global $conn;
        global $authenticate;
        $sql = "SELECT id FROM whishlist  WHERE  user_id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$authenticate, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function countWishilist(){
        global $conn;
        $cartResult = wishilistUser();
        $cartId = 0;
        foreach($cartResult as $cartItem)
            $cartId = $cartItem->id;
        $sql = "SELECT count(id) as wishilist_shopping FROM wishilist_itens  WHERE  wishilist_id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$cartId, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }
    function addWishilist($product){
        global $conn;
        $wishilistResult = wishilistUser();
        $wishilistId = 0;
        foreach($wishilistResult as $cartItem){
            $wihilisttId = $cartItem->id;
            $sql_cart = "INSERT INTO wishilist_itens (product_id , wishilist_id) VALUES (:product,:cart)";
            $statement = $conn->prepare($sql_cart);
            $statement->bindParam(':product', $product,PDO::PARAM_INT);
            $statement->bindParam(':cart', $wishilistId,PDO::PARAM_INT);
            $statement->execute();
            if($conn->lastInsertId()) $_SESSION['sucesso'] = "Producto adicionado a de desejos";
            else $_SESSION['error'] = "Producto nao foi adicionado a de desejos";
        }     
    }

    function findAllCart(){
        global $conn;
        $cartResult = cartUser();
        $cartId = 0;
        foreach($cartResult as $cartItem)
            $cartId = $cartItem->id;
        $sql = "SELECT ci.id as id, p.image_url as image_url, p.name as nome,p.made_in as made_in, p.units_price as units_price, 
                p.product_id as product_id, sc.sub_category_name as category_name FROM products as p INNER JOIN 
                cart_itens as ci INNER JOIN sub_categories as sc WHERE p.id = ci.product_id AND p.sub_category_id = sc.id AND ci.cart_id = :cart";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':cart',$cartId, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findOneCartItem($cart_item){
        global $conn;
        $sql_cart_product_buy = "SELECT p.id as id, p.quantity as quantity, p.image_url as image_url, p.name as nome,p.made_in as made_in, p.units_price as units_price, 
        p.product_id as product_id, c.category_name as category_name, sc.sub_category_name as sub_category_name FROM products as p INNER JOIN 
        cart_itens as ci INNER JOIN category as c INNER JOIN sub_categories as sc WHERE c.id = p.category_id AND p.id = ci.product_id AND p.sub_category_id = sc.id AND ci.id = :cart_itens";
        $statement = $conn->prepare($sql_cart_product_buy);
        $statement->bindParam(':cart_itens',$cart_item, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findAllAndJoinTablesSorted($product, $category, $subCategory){
        global $conn;
        $returnValue = array("product_id","name","image_url","image2_url","image3_url","units_price","quantity","descriptions","made_in","create_on");
        $typeSort = array("ASC", "DESC");
        $sortedNumber = rand(0, count($returnValue) - 1);
        $mode = rand(0,1);
        $sql = "SELECT * FROM {$product} ORDER BY {$returnValue[$sortedNumber]} {$typeSort[$mode]}";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findAllAndJoinTablesSortedSubCategory($subCategory){
        global $conn;
        $returnValue = array("product_id","name","image_url","image2_url","image3_url","units_price","quantity","descriptions","made_in","create_on");
        $typeSort = array("ASC", "DESC");
        $sortedNumber = rand(0, count($returnValue) - 1);
        $mode = rand(0,1);
        $sql = "SELECT * FROM products as p INNER JOIN sub_categories as sc WHERE sc.sub_category_id = :sub_category AND p.sub_category_id = sc.id ORDER BY {$returnValue[$sortedNumber]} {$typeSort[$mode]}";
        $statement = $conn->prepare($sql);
        $statement->bindParam('sub_category',$subCategory,PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findAllAndJoinTablesSortedLimit($product, $category, $subCategory,$limit){
        global $conn;
        $returnValue = array("product_id","name","image_url","image2_url","image3_url","units_price","quantity","descriptions","made_in","create_on");
        $typeSort = array("ASC", "DESC");
        $sortedNumber = rand(0, count($returnValue) - 1);
        $mode = rand(0,1);
        $sql = "SELECT * FROM {$product} ORDER BY 
                 {$returnValue[$sortedNumber]} {$typeSort[$mode]} LIMIT {$limit}";
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

    function marcas(){
        global $conn;
        $sql_query = "SELECT COUNT(p.id) as registro, 
            sc.sub_category_name as marca, sc.id as id FROM products as p 
            INNER JOIN sub_categories as sc WHERE p.sub_category_id = sc.id 
            GROUP BY(sc.id)";
        $statement = $conn->prepare($sql_query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
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

    function productDetailsColor($product){
        global $conn;
        $sql = "SELECT pc.id as id, pc.color as color FROM products as p 
            INNER JOIN product_color as pc WHERE p.product_id = :id 
            AND p.id = pc.product_id GROUP BY(pc.color)";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$product, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }
    function productDetailsSize($product){
        global $conn;
        $sql = "SELECT ps.id as id, ps.size as size FROM products as p INNER JOIN 
            product_size as ps WHERE p.product_id = :id 
            AND p.id = ps.product_id GROUP BY(ps.size)";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$product, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function countBuy(){
        global $conn;
        global $authenticate;
        $sql = "SELECT COUNT(id) as all_sale FROM sales WHERE user_id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$authenticate, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function salesUser(){
        global $conn;
        global $authenticate;
        $sql = "SELECT id FROM cart  WHERE  user_id = :id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':id',$authenticate, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    function findAllSales(){
        global $conn;
        global $authenticate;
    
        $sql = "SELECT p.name as nome, p.product_id as product,
                p.image_url as imagem,p.units_price as price,
                p.made_in as fabrique, s.sale_code as code, 
                si.quantity as quantity, si.price as total,pc.color as color,
                ps.size as size FROM products as p INNER JOIN sales as s 
                INNER JOIN items_sales as si INNER JOIN product_color as pc 
                INNER JOIN product_size as ps WHERE p.id = si.product_id AND 
                si.sale_id = s.id AND pc.product_id = p.id AND ps.product_id = p.id 
                AND s.user_id = :user AND si.color_id = pc.id AND si.size_id = ps.id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':user',$authenticate, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }
?>