<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

if((isset($_POST["day"]))&&($_POST["day"]!=0))
{		
	$day = strtotime(date("Y-m-d",$_POST["day"]));
	
    // get the HTML
    ob_start();
    include(dirname(__FILE__).'/see-pdf-week-events.php');
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 3);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('week_schedule.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
} else { echo "Sorry! Impossible to print the events!"; }