<?php
// On recupere l URL de la page d'origine
	$nomPageOrigine = $_SERVER["HTTP_REFERER"];
	

if((isset($_POST["Wik"]))&&($_POST["Wik"]!=0))
{		
	$IdWk = $_POST["Wik"] ;
	
    // get the HTML
    ob_start();
    include(dirname(__FILE__).'/see-pdf-schedule.php');
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', 3);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$pdfcontent = $html2pdf->Output('printable_schedule.pdf','S');
		
  
      // Get the contents of the HTML email into a variable for later  
    ob_start();  
    require_once($dir.'/msg_email.php');  
    $html_message = ob_get_contents();  
    ob_end_clean();  
	
// email stuff (change data below)
$to = "yoanns@gmail.com";
$from = "yns1@psu.edu";
$subject = "Schedule from ".$debut." to ".$fin;
//$message = "<p>Please see the attachment.</p>";
// a random hash will be necessary to send mixed content
$separator = md5(time());
// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;
// attachment name
$filename = $html2pdf->Output('printable_schedule.pdf','S'); //"example.pdf";
// encode data (puts attachment in proper format)
//$pdfdoc = $pdf->Output("", "S");
//$attachment = chunk_split(base64_encode($pdfdoc));
$attachment = chunk_split(base64_encode($filename));
// main header (multipart mandatory)
$headers = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
$headers .= "Content-Transfer-Encoding: 7bit".$eol;
$headers .= "This is a MIME encoded message.".$eol.$eol;
// message
$headers .= "--".$separator.$eol;
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$headers .= $html_message.$eol.$eol;
// attachment
$headers .= "--".$separator.$eol;
$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
$headers .= "Content-Transfer-Encoding: base64".$eol;
$headers .= "Content-Disposition: attachment".$eol.$eol;
$headers .= $attachment.$eol.$eol;
$headers .= "--".$separator."--";
// send message
mail($to, $subject, "", $headers);
?>
<link rel="stylesheet" media="screen" type="text/css" href="../Admin/css_adm/news_ADM_style.css" />
<?php

// Send the email, and show user message  
if (mail($to, $subject, "", $headers)) 
	{ 
    $success = true;  
	echo "Emailing the schedules succeeded!";
	echo "<a href=$nomPageOrigine><div class='medium button green'><img src=../Admin/icones/arrow_back.png />Back to the list of schedules</div> </a>";
	}
else  
	{
    $error = true;  
	echo "Emailing the schedules failed!";
	echo "<a href=$nomPageOrigine><div class=medium button red><img src=../Admin/icones/arrow_back.png />Back to the list of schedules</div> </a>";
	}
	
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
} else { echo "Sorry! Impossible to print the schedule!"; }