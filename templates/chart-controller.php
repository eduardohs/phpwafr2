<?php

// Headers //////////////////////////////////////////////////////////////////////////////////////////////////////////////
header("Content-type: image/png");

include_once("../inc/libchart/classes/libchart.php");
include_once("../inc/common.php");

// Inicialização dos dados de saída /////////////////////////////////////////////////////////////////////////////////////
$result["ok"] = "0";

// Captura a ação a ser executada ///////////////////////////////////////////////////////////////////////////////////////
$action = Param::get("action");

// Horizontal Bar ///////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "horizontal") {
	$chart = new HorizontalBarChart(900, 370);

	$dataSet = new XYDataSet();
	$dataSet->addPoint(new Point("Produto Um", 50));
	$dataSet->addPoint(new Point("Produto Dois", 75));
	$dataSet->addPoint(new Point("Produto Três", 122));
	$dataSet->addPoint(new Point("Produto Quatro", 61));

	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphPadding(new Padding(5, 30, 20, 140));
	$chart->setTitle("Demonstrativo de vendas");

	$chart->render();
}

// Vertical Bar //////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "vertical") {
	$chart = new VerticalBarChart(900, 400);

	$dataSet = new XYDataSet();
	$dataSet->addPoint(new Point("Jan 2005", 273));
	$dataSet->addPoint(new Point("Fev 2005", 421));
	$dataSet->addPoint(new Point("Mar 2005", 642));
	$dataSet->addPoint(new Point("Abr 2005", 800));
	$dataSet->addPoint(new Point("Mai 2005", 1200));
	$dataSet->addPoint(new Point("Jun 2005", 1500));
	$dataSet->addPoint(new Point("Jul 2005", 2600));
	$chart->setDataSet($dataSet);

	$chart->setTitle("Demonstrativo de Vendas");
	$chart->render();
}

// Line //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "line") {
	$chart = new LineChart(900, 400);

	$dataSet = new XYDataSet();
	$dataSet->addPoint(new Point("06-01", 273));
	$dataSet->addPoint(new Point("06-02", 421));
	$dataSet->addPoint(new Point("06-03", 642));
	$dataSet->addPoint(new Point("06-04", 799));
	$dataSet->addPoint(new Point("06-05", 1009));
	$dataSet->addPoint(new Point("06-06", 1406));
	$dataSet->addPoint(new Point("06-07", 1820));
	$dataSet->addPoint(new Point("06-08", 2511));
	$dataSet->addPoint(new Point("06-09", 2832));
	$dataSet->addPoint(new Point("06-10", 3550));
	$dataSet->addPoint(new Point("06-11", 4143));
	$dataSet->addPoint(new Point("06-12", 4715));
	$chart->setDataSet($dataSet);

	$chart->setTitle("Vendas de 2006");
	$chart->render();
}

// Multiple Bar //////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "multiplehorizontalbar") {
	$chart = new HorizontalBarChart(900, 400);

	$serie1 = new XYDataSet();
	$serie1->addPoint(new Point("18-24", 22));
	$serie1->addPoint(new Point("25-34", 17));
	$serie1->addPoint(new Point("35-44", 20));
	$serie1->addPoint(new Point("45-54", 25));

	$serie2 = new XYDataSet();
	$serie2->addPoint(new Point("18-24", 13));
	$serie2->addPoint(new Point("25-34", 18));
	$serie2->addPoint(new Point("35-44", 23));
	$serie2->addPoint(new Point("45-54", 22));

	$dataSet = new XYSeriesDataSet();
	$dataSet->addSerie("Masculino", $serie1);
	$dataSet->addSerie("Feminino", $serie2);
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphCaptionRatio(0.80);

	$chart->setTitle("Usuários Firefox vs IE: Idade");
	$chart->render();
}

// Multiple Line ///////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "multipleline") {
	$chart = new LineChart(900,400);

	$serie1 = new XYDataSet();
	$serie1->addPoint(new Point("06-01", 273));
	$serie1->addPoint(new Point("06-02", 421));
	$serie1->addPoint(new Point("06-03", 642));
	$serie1->addPoint(new Point("06-04", 799));
	$serie1->addPoint(new Point("06-05", 1009));
	$serie1->addPoint(new Point("06-06", 1106));

	$serie2 = new XYDataSet();
	$serie2->addPoint(new Point("06-01", 280));
	$serie2->addPoint(new Point("06-02", 300));
	$serie2->addPoint(new Point("06-03", 212));
	$serie2->addPoint(new Point("06-04", 542));
	$serie2->addPoint(new Point("06-05", 600));
	$serie2->addPoint(new Point("06-06", 850));

	$serie3 = new XYDataSet();
	$serie3->addPoint(new Point("06-01", 180));
	$serie3->addPoint(new Point("06-02", 400));
	$serie3->addPoint(new Point("06-03", 512));
	$serie3->addPoint(new Point("06-04", 642));
	$serie3->addPoint(new Point("06-05", 700));
	$serie3->addPoint(new Point("06-06", 900));

	$serie4 = new XYDataSet();
	$serie4->addPoint(new Point("06-01", 280));
	$serie4->addPoint(new Point("06-02", 500));
	$serie4->addPoint(new Point("06-03", 612));
	$serie4->addPoint(new Point("06-04", 742));
	$serie4->addPoint(new Point("06-05", 800));
	$serie4->addPoint(new Point("06-06", 1000));

	$serie5 = new XYDataSet();
	$serie5->addPoint(new Point("06-01", 380));
	$serie5->addPoint(new Point("06-02", 600));
	$serie5->addPoint(new Point("06-03", 712));
	$serie5->addPoint(new Point("06-04", 842));
	$serie5->addPoint(new Point("06-05", 900));
	$serie5->addPoint(new Point("06-06", 1200));

	$dataSet = new XYSeriesDataSet();
	$dataSet->addSerie("Produto 1", $serie1);
	$dataSet->addSerie("Produto 2", $serie2);
	$dataSet->addSerie("Produto 3", $serie3);
	$dataSet->addSerie("Produto 4", $serie4);
	$dataSet->addSerie("Produto 5", $serie5);
	$chart->setDataSet($dataSet);

	$chart->setTitle("Vendas para 2006");
	$chart->getPlot()->setGraphCaptionRatio(0.80);
	$chart->render();
}

// Multiple Vertical Bar /////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "multipleverticalbar") {
	$chart = new VerticalBarChart(900,400);

	$serie1 = new XYDataSet();
	$serie1->addPoint(new Point("YT", 64));
	$serie1->addPoint(new Point("NT", 63));
	$serie1->addPoint(new Point("BC", 58));
	$serie1->addPoint(new Point("AB", 58));
	$serie1->addPoint(new Point("SK", 46));
	
	$serie2 = new XYDataSet();
	$serie2->addPoint(new Point("YT", 61));
	$serie2->addPoint(new Point("NT", 60));
	$serie2->addPoint(new Point("BC", 56));
	$serie2->addPoint(new Point("AB", 57));
	$serie2->addPoint(new Point("SK", 52));
	
	$dataSet = new XYSeriesDataSet();
	$dataSet->addSerie("1990", $serie1);
	$dataSet->addSerie("1995", $serie2);
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphCaptionRatio(0.80);

	$chart->setTitle("Orçamento médio familiar (mil reais)");
	$chart->render();	
}

// Pie ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "pie") {
	$chart = new PieChart(800,500);

	$dataSet = new XYDataSet();
	$dataSet->addPoint(new Point("Mozilla Firefox (80)", 80));
	$dataSet->addPoint(new Point("Konqueror (75)", 75));
	$dataSet->addPoint(new Point("Opera (50)", 50));
	$dataSet->addPoint(new Point("Safari (37)", 37));
	$dataSet->addPoint(new Point("Dillo (37)", 37));
	$dataSet->addPoint(new Point("Other (72)", 70));
	$chart->setDataSet($dataSet);
	$chart->getPlot()->setGraphCaptionRatio(0.70);

	$chart->setTitle("User agents");
	$chart->render();
}
