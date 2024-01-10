<?php


require __DIR__ . '/ticket/autoload.php'; // Nota: Se você renomeou a pasta para algo diferente de "ticket", altere o nome nesta linha
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/*
	Este exemplo imprime um recibo de venda em uma impressora térmica
*/


/*
    Aqui em vez de "Bisofice" (que é o nome da minha impressora)
	Escreva o nome da sua impressora.
	Lembre-se de compartilhar do painel de controle do windows
*/

$nome_impressora = "Bisofice"; 


$connector = new WindowsPrintConnector($nome_impressora);
$printer = new Printer($connector);

#Envio um número de resposta para saber que foi conectado corretamente.
echo 1;

/*
	Iremos imprimir um logotipo
	opcional. Lembre-se que isso
	não funcionará em todos
	impressoras

	Nota pequena: Recomenda-se que a imagem não seja
	transparente (mesmo que seja png você tem que remover o canal alfa)
	e que tem uma resolução baixa. No meu caso
	A imagem que uso é 250 x 250
*/

# Vamos centralizar a próxima coisa que imprimiremos
$printer->setJustification(Printer::JUSTIFY_CENTER);

/*
	Tentaremos fazer upload e imprimir
	o logotipo
*/
try{
	$logo = EscposImage::load("logo.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*Não fazemos nada se houver um erro*/}

/*
	Agora vamos imprimir um cabeçalho
*/

$printer->text("\n"."Táindo Delivery App" . "\n");
$printer->text("End: Rua Augusta, 51 - Centro - JF" . "\n");
$printer->text("Tel: (32) 9 9114 4887" . "\n");

#A data também
date_default_timezone_set("Juiz de Fora / MG - BR");
$printer->text(date("Y-m-d H:i:s") . "\n");
$printer->text("-----------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CANT  DESCRIPCION    P.U   IMP.\n");
$printer->text("-----------------------------"."\n");
/*
	Agora vamos imprimir os	produtos
*/
	/*Alinhe à esquerda para quantidade e nome*/
	$printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("Hamburger\n");
    $printer->text( "2  UN    20.00 40.00   \n");
    $printer->text("Coca-cola lata 475 \n");
    $printer->text( "2  UN    10.00 20.00   \n");
    $printer->text("Batata Frita GD \n");
    $printer->text( "2  UN    18.00 36.00   \n");
/*
	Terminamos de imprimir os produtos, agora vai o total
*/
$printer->text("-----------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("Sub-total: $96.00\n");
$printer->text("Entrega: $16.00\n");
$printer->text("TOTAL: $112.00\n");


/*
	Também podemos colocar um rodapé
*/
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Obrigado pela sua compra\n");



/*Alimentamos o papel 3 vezes*/
$printer->feed(3);

/*
	Cortamos o papel. Se nossa impressora
	não tem suporte para isso, não vai gerar
	não há erro
*/
$printer->cut();

/*
	Através da impressora enviamos um pulso.
	Isso é útil quando o temos conectado
	por exemplo, para uma gaveta
*/
$printer->pulse();

/*
	Para realmente imprimir, temos que "fechar"
	a conexão com a impressora.
	Lembre-se de incluir isso no final de todos os arquivos
*/
$printer->close();

?>