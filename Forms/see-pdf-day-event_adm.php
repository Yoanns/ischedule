<page backtop="10mm" backbottom="10mm" backleft="0mm" backright="0mm">
    
	<?php
// protection de page ADMIN
   include_once('../Admin/fonctions/_protectpageadm.php');
// **************************************
// Parametres de Connexion a la BD
	include_once('../connexion.php');
	include_once('../Model/class.event.php');
	include_once("../Model/class.location.php");
	include_once('../Admin/fonctions/functions.php');
	
	
	?>
<link rel="stylesheet" media="screen" type="text/css" href="../css/print.css" />
	<link rel="shortcut icon" type="image/x-icon" href="../Admin/icones/ischedule_logo1.ico">

	<page_header>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left;    width: 33%">Shift-Scheduler.com</td>
                <td style="text-align: center;    width: 34%">Events of the day</td>
                <td style="text-align: right;    width: 33%"><?php echo date('M j, Y'); ?></td>
            </tr>
        </table>
    </page_header>
	
    <page_footer>
        <table style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left;    width: 50%">Shift-Scheduler.com</td>
                <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
	

	
<div class="row">
		<div class="twelve columns centered">
			<div class="panel">
	<table align="center">
			<tr> 
				<th><strong>
<?php 
		$evt = new event(null);
		$TodayEvt = $evt -> DayEventsAdm($DayEvt);
		
	  	if(!empty($TodayEvt))
	  	{
	  		
			$day = strtotime($DayEvt);
			$theday = date("l M j, Y",$day);
			
			 echo $theday ;
			 
		}
		
			 ?> 
			 </strong>
			 </th>
			</tr>
		</table>
		
	<br/>
		<table align="center">
			<thead>
			<tr style="border:1px dashed #CCCCCC">
				<td width="35%"></td>
				<th width="10%" style=" padding:10px;">Guests</th>
				<th width="25%" style=" padding:10px;">Time slot</th>
				<th style=" padding:10px;">Duration</th>
				<th style=" padding:10px;">location</th>
			</tr>
			</thead>
			<?php 
	
		
			//Retrieve the position of each employee
			 $evt_query = "SELECT * FROM event  WHERE DayEvt = '$DayEvt' ORDER BY BegEvt ASC";
	 $evt_result = mysql_query($evt_query) or die('Erreur SQL :<br />'.$evt_query.'<br />'.mysql_error());
	 $evt_num = mysql_num_rows($evt_result);
	 
if ($evt_num > 0)
	{
	 
	 while ($evt_row = mysql_fetch_array($evt_result))
		{
			$evtID  = 	stripslashes($evt_row['IdEvt']);
			$evtName = 	stripslashes($evt_row['NameEvt']);
			$evtGuest  = 	stripslashes($evt_row['GuestEvt']);
			$evtDesc = 	stripslashes($evt_row['DescEvt']);
			$evtDay = 	stripslashes($evt_row['DayEvt']);
			$evtBeg  = 	stripslashes($evt_row['BegEvt']);
			$evtEnd = 	stripslashes($evt_row['EndEvt']);
			$IdLoc = 	stripslashes($evt_row['IdLoc']);
			
			$Loc = new location($IdLoc);
			$NameLoc = $Loc -> NameLoc;
			
			
			$X = strtotime($evtBeg) ;
			$Y = strtotime($evtEnd);
			
	if ($X > $Y)
		{
			$hours = strtotime("+1 day");
			$temp = dateDiff($X, $Y) ;
			$duration =  dateDiff($hours, $temp) ;
		}
	elseif ($X <= $Y) $duration =  dateDiff($X, $Y) ;
	
	 	?>
			
			<tr style="border:1px dashed #CCCCCC">
				<th style=" padding:10px;"><?php echo $evtName; ?></th>
				<td style=" padding:10px;"><?php echo $evtGuest; ?></td>
				<td style=" padding:10px;"><?php echo $evtBeg." - ".$evtEnd; ?></td>
				<td style=" padding:10px;"><?php echo $duration; ?></td>
				<td style=" padding:10px;"><?php echo $NameLoc; ?></td>
				
			</tr>
							
		<?php 
			 } // End while for events
		} //End if  $evt_num
		 else
		 	{ ?>
			<tr style="border:1px dashed #CCCCCC">
				<td colspan="8"> <div align="center">No event scheduled for that day.</div></td>
			</tr>
			
			<?php
			}
			?>
			
		</table>
		<br/>
		</div>
	</div>
</div>

<?php // } // end if
?>
</page>