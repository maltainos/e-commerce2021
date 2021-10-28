<?php
	include "function.php";
	require 'vendor/autoload.php';	

	if(isset($_POST['finish-buy'])){
		$province = $_POST['province'];
		$code = $_POST['code'];
		$quantity = $_POST['quantity'];
		$color = $_POST['color'];
		$size = $_POST['size'];
		$total = $_POST['total'];
		$telefone = $_POST['telefone'];
		$product = $_POST['product'];
	}else{
		header("location:../shop");
	}

	$mpesa = new \Karson\MpesaPhpSdk\Mpesa();
	$mpesa->setApiKey('hsakzwlw45b0znok0lj8jszpblf5zghi');
	$mpesa->setPublicKey('MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAmptSWqV7cGUUJJhUBxsMLonux24u+FoTlrb+4Kgc6092JIszmI1QUoMohaDDXSVueXx6IXwYGsjjWY32HGXj1iQhkALXfObJ4DqXn5h6E8y5/xQYNAyd5bpN5Z8r892B6toGzZQVB7qtebH4apDjmvTi5FGZVjVYxalyyQkj4uQbbRQjgCkubSi45Xl4CGtLqZztsKssWz3mcKncgTnq3DHGYYEYiKq0xIj100LGbnvNz20Sgqmw/cH+Bua4GJsWYLEqf/h/yiMgiBbxFxsnwZl0im5vXDlwKPw+QnO2fscDhxZFAwV06bgG0oEoWm9FnjMsfvwm0rUNYFlZ+TOtCEhmhtFp+Tsx9jPCuOd5h2emGdSKD8A6jtwhNa7oQ8RtLEEqwAn44orENa1ibOkxMiiiFpmmJkwgZPOG/zMCjXIrrhDWTDUOZaPx/lEQoInJoE2i43VN/HTGCCw8dKQAwg0jsEXau5ixD0GUothqvuX3B9taoeoFAIvUPEq35YulprMM7ThdKodSHvhnwKG82dCsodRwY428kg2xM/UjiTENog4B6zzZfPhMxFlOSFX4MnrqkAS+8Jamhy1GgoHkEMrsT5+/ofjCx0HjKbT5NuA2V/lmzgJLl3jIERadLzuTYnKGWxVJcGLkWXlEPYLbiaKzbJb2sYxt+Kt5OxQqC1MCAwEAAQ==
');
	$mpesa->setEnv('test');// 'live' production environment 
	//$result = $mpesa->c2b("T12344C",$telefone,$total,"MU6F0G", "171717");
	//echo $result->status;
	//if($result->status != "201"){
		$sale = createSale();
		$sale_item = saleItem($sale,$product,$quantity,$total,$color,$size,$telefone);
		$completo = createDelivery($telefone,$sale,$province,$code);
		header("location:../my-sales");
	/*}else{
		$_SESSION['payment'] = "Falha ao efectuar pagamento...!";
		header("location:../payment-confirm");
	}*/


?>




































