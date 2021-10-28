<?php
    session_start();
    require "connection.php";
    function redirect($user_role){
        if($user_role == 3){
            header('Location:../customer');
        }else if($user_role == 2){
            header('Location:../guest');
        }        
    }
    if(isset($_SESSION['username']) && isset($_SESSION['user_role']) && isset($_SESSION['user_image'])){
        $user_role = $_SESSION['user_role'];
        redirect($user_role);               
    }else{
        header('Location:../checkout.php');
    }    //require "connection.php";
    $estudante = $_GET['id'];
    $usuario = $_SESSION['user_id'];
    $sql = "SELECT u.nome as nome, u.apelido as apelido FROM usuarios as u WHERE u.id = :id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $usuario, PDO::PARAM_INT);
    $statement->execute();
    $usuarios = $statement->fetchAll(PDO::FETCH_OBJ);
    foreach ($usuarios as $usuario) {
        $returnValue = $usuario->nome.' '.$usuario->apelido;
    }

    $sql = "SELECT e.nome as nome, e.apelido as apelido, e.nascimento as nascimento, e.genero as genero, e.morada as morada, e.identificacao as identificacao FROM estudantes as e WHERE e.id = :id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $estudante, PDO::PARAM_INT);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_OBJ);

    $sql = "SELECT d.nome as disciplina, d.preco_inscricao as matricula, d.preco_mensal as mensal, d.regime as regime, d.duracao as duracao, d.inicio as inicio, i.create_at as inscrido, day(i.create_at) as day, month(i.create_at) as month, year(i.create_at) as year, i.id as codigo FROM disciplina as d INNER JOIN estudantes as e INNER JOIN inscricao as i WHERE d.id = i.disciplina_id AND i.estudante_id = e.id AND e.id = :id ORDER BY(d.nome)";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $estudante, PDO::PARAM_INT);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_OBJ);
require('fpdf.php');

class PDF extends FPDF
{

    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = ''){
        $txt = utf8_decode($txt);
        parent::Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

    }

    function BasicTable($header, $data){
        $total_inscricao = 0;
        $total_mensal = 0;
        // Header
        foreach($header as $col){
            $this->SetFillColor(255,0,0);
            $this->Cell(28,10,$col,1,0,'C');
        }
        $this->Ln(13);
        //Data
        foreach($data as $row)
        {
            $this->SetFont('Times','',9);
            $count = 1;
            foreach($row as $col){
                if($count == 5){
                    $this->Cell(28,10,$col ." Meses",0,0,'C');
                }else{
                    if($count == 2 || $count == 3)
                        $this->Cell(28,10,number_format($col ).".00MT",0,0,'C');
                    else{
                        if($count == 1){
                            $this->Cell(28,10,$col,0,0,'L');
                        }else
                            $this->Cell(28,10,$col,0,0,'C');
                    }
                }
                $count++;
            }
            $total_inscricao += $row->matricula;
            $total_mensal += $row->mensal;
            $this->Ln();
        }
        $this->Cell(195,1,"",1,0,'R');
        $this->Ln();
        $total = $total_mensal + $total_inscricao;
        $total_mensal = number_format($total_mensal);
        $total_inscricao = number_format($total_inscricao);
        $this->SetFont('Times','B',10);
        $this->Cell(28,8,'Sub Total: ',0,0,'');
        $this->Cell(28,8,"{$total_inscricao} .00MT",0,0,'C');
        $this->Cell(28,8,"{$total_mensal} .00MT",0,0,'C');
        $this->Ln();
        $this->SetFont('Times','B',10);
        $this->Cell(28,8,'Total: ',0,0,'L');
        $total = number_format($total);
        $this->Cell(162,8,"{$total} .00MT",0,0,'R');
    }
}

$subjects = 0;
$date;
foreach ($data as $date) {
    $subjects++;
    $codigo = $date->codigo;
    $date = "{$date->day}{$date->month}{$date->year}";
}

$pdf = new PDF();
// Column headings
$header = array('DISCIPLINA','INSCRICAO','MENSALIDADE','REGIME','DURACAO','INICIO','INSCRITO');
$pdf->AddPage();
$pdf->SetCreator("SA-Epsilon",true);
$pdf->SetKeywords('keyword1', true);
$pdf->Image('../images/logo/logo2.jpg',80,2,-600);
$pdf->Cell(140);
// Framed title
$pdf->SetFont('Times','',8);
$pdf->Cell(200,5,'NUIT: 401187219',2,0,'');
$pdf->Ln();
// Framed title
$pdf->Cell(140);
$pdf->SetFont('Times','',8);
$pdf->Cell(200,5,'Rua Correia de Brito No. 613',2,0,'');
$pdf->Ln();
$pdf->Cell(140);
$pdf->Cell(200,5,'Caixa Postal 544, Ponta Gea-Beira',2,0,'');
$pdf->Ln();
$pdf->Cell(140);
$pdf->Cell(200,5,'Cell: (+258) 860762211/ 833138455',2,0,'');
$pdf->Ln();
$pdf->Cell(140);
$pdf->Cell(200,5,'Email: secretariageral@saepsilon.org',2,0,'');
$pdf->Ln();
$pdf->Cell(140);
$pdf->Cell(200,5,'Website: http://www.saepsilon.org',2,0,'');
$pdf->Ln(20);
//$pdf->Cell(80);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'COMPROVATIVO DE PAGAMENTOS DE INSCRICOES',2,0,'C');
// Line break
$pdf->Ln();
// Set font
$pdf->SetFont('Times','B',10);
$pdf->Cell(20,10,"RECIBO No. {$date}.{$subjects}.{$estudante}.{$codigo}");
$pdf->Ln();

foreach ($results as $result) {
   $nomeCompleto = $result->nome." ".$result->apelido;
   $nascimento = $result->nascimento;
   $genero = $result->genero;
   $morada = $result->morada;
   $identificacao = $result->identificacao;
}
$pdf->Cell(197,1,"",1,0,'R');
$pdf->Ln();
$pdf->SetFont('Times','B',10);
$pdf->Cell(28,10,"Nome Completo: ");
$pdf->SetFont('Times','',9);
$pdf->Cell(50,10,$nomeCompleto,0,0,'L');
$pdf->Cell(51);
$pdf->SetFont('Times','B',10);
$pdf->Cell(22,10,"Genero: ",0,0,'R');
$pdf->SetFont('Times','',9);
$pdf->Cell(20,10,$genero,0,0,'L');
$pdf->SetFont('Times','B',10);
$pdf->Ln(5);
$pdf->Cell(50,10,"Documento de Identificacao No.: ");
$pdf->SetFont('Times','',9);
$pdf->Cell(30,10,$identificacao,0,0);
$pdf->Cell(50);
$pdf->SetFont('Times','B',10);
$pdf->Cell(22,10,"Morada: ",0,0,'R');
$pdf->SetFont('Times','',9);
$pdf->Cell(20,10,$morada,0,0,'L');
$pdf->Ln(8);
$pdf->Cell(196,1,"",1,0,'R');

$pdf->Ln();
$pdf->SetFont('Times','B',10);
$pdf->BasicTable($header,$data);
$pdf->Ln();
$pdf->Cell(195,1,"",1,0,'R');
$pdf->Ln(10);
$pdf->Cell(0,10,"Assinatura do funcionario e carimbo: ",0,0,'C');
$pdf->Ln();
$pdf->Cell(0,10,"_______________________________________",0,0,'C');
$pdf->Ln(4);
$pdf->Cell(0,10,"({$returnValue})",0,0,'C');
$pdf->Ln(30);

//$pdf->Cell();
$pdf->SetY(265);
$pdf->Cell(195,1,"",1,0,'R');
$pdf->Ln();
// Select Arial italic 8
$pdf->SetFont('Times','I',8);
// Print centered page number
$data = date('d/M/Y h:i:s');
$pdf->Cell(65,10,'SOCIEDADE  ACADEMICA-EPSILON ',0,0,'L');
$pdf->Cell(65,10,'Documento processado por computador ',0,0,'C');
$pdf->Cell(65,10,"Data: {$data} ",0,0,'R');
$pdf->Output();
?>