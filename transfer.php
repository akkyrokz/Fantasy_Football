<?php
	session_start();
	
	require 'connect.php';
	
	$sql = "select * from PLAYER_TABLE;";
	$result = mysqli_query($conn,$sql);
	
	$GK = array();
	$DF = array();
	$MF = array();
	$FW = array();
	$GK_size=0;
	$DF_size=0;
	$MF_size=0;
	$FW_size=0;
	
	if ($result->num_rows > 0)
	{
		while($player = mysqli_fetch_array($result))
		{
			if($player["POSITION"] == "GK")
				{array_push($GK,$player);
					$GK_size=$GK_size+1;
					}
			else if($player["POSITION"] == "DF")
				{array_push($DF,$player);
					$DF_size=$DF_size+1;
					}
			else if($player["POSITION"] == "MF")
				{array_push($MF,$player);
					$MF_size=$MF_size+1;
					}
			else if($player["POSITION"] == "FW")
				{array_push($FW,$player);	
					$FW_size=$FW_size+1;	
					}
		}		
	}

	if(!isset($_SESSION['SIGNEDUP']))
	{
		$sql = 'SELECT * FROM USER_TEAM_TABLE WHERE USER_ID = ' . $_SESSION['USER_ID'] . ';';
		$result = mysqli_query($conn, $sql);
		$tuple = null;

		if($result->num_rows == 1)
		{
			$tuple = mysqli_fetch_array($result);
		
			$GKP = array(null,$tuple["GK1"],$tuple["GK2"]);
			$DFP = array(null,$tuple["DF1"],$tuple["DF2"],$tuple["DF3"],$tuple["DF4"],$tuple["DF5"]);
			$MFP = array(null,$tuple["MF1"],$tuple["MF2"],$tuple["MF3"],$tuple["MF4"],$tuple["MF5"]);
			$FWP = array(null,$tuple["FW1"],$tuple["FW2"],$tuple["FW3"]);
		}
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $GKP[1] . ';';
		$result = mysqli_query($conn, $sql);
		$GKP[1] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $GKP[2] . ';';
		$result = mysqli_query($conn, $sql);
		$GKP[2] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $DFP[1] . ';';
		$result = mysqli_query($conn, $sql);
		$DFP[1] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $DFP[2] . ';';
		$result = mysqli_query($conn, $sql);
		$DFP[2] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $DFP[3] . ';';
		$result = mysqli_query($conn, $sql);
		$DFP[3] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $DFP[4] . ';';
		$result = mysqli_query($conn, $sql);
		$DFP[4] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $DFP[5] . ';';
		$result = mysqli_query($conn, $sql);
		$DFP[5] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $MFP[1] . ';';
		$result = mysqli_query($conn, $sql);
		$MFP[1] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $MFP[2] . ';';
		$result = mysqli_query($conn, $sql);
		$MFP[2] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $MFP[3] . ';';
		$result = mysqli_query($conn, $sql);
		$MFP[3] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $MFP[4] . ';';
		$result = mysqli_query($conn, $sql);
		$MFP[4] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $MFP[5] . ';';
		$result = mysqli_query($conn, $sql);
		$MFP[5] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $FWP[1] . ';';
		$result = mysqli_query($conn, $sql);
		$FWP[1] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $FWP[2] . ';';
		$result = mysqli_query($conn, $sql);
		$FWP[2] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM PLAYER_TABLE WHERE PLAYER_ID = ' . $FWP[3] . ';';
		$result = mysqli_query($conn, $sql);
		$FWP[3] = mysqli_fetch_array($result);
		
		$sql = 'SELECT * FROM USER_TABLE WHERE USER_ID = ' . $_SESSION['USER_ID'] . ';';
		$result = mysqli_query($conn, $sql);
		$tuple = mysqli_fetch_array($result);
		$teamvalue = $tuple['TEAM_VALUE'];
		$balance = $tuple['BALANCE'];				
	}
?>
	
<html>
<head>
<h2>Welcome, <?php echo " ". $_SESSION['username'];?> </h2><br>
<h2>Team Name: <?php echo " ". $_SESSION['teamname'];?> </h2>
</head>		
	
<style>
	div{
	overflow:hidden;
    overflow-y: scroll;
    height: 500px; // change this to desired height
    display: inline-block;
}
    
    #players{ position: absolute; padding: 10px; padding-right:15px; top: 100px; right: 500px; z-index: 99;}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<body>
	
<button id="GK_BUTTON" onclick="myfun('GK_TABLE')">GK</button>
<button id="DF_BUTTON" onclick="myfun('DF_TABLE')">DF</button>	
<button id="MF_BUTTON" onclick="myfun('MF_TABLE')">MF</button>
<button id="FW_BUTTON" onclick="myfun('FW_TABLE')">FW</button>	

<script>	
	function myfun(id)
	{
		document.getElementById("GK_TABLE").style.display = 'none'; 
		document.getElementById("DF_TABLE").style.display = 'none'; 
		document.getElementById("MF_TABLE").style.display = 'none'; 
		document.getElementById("FW_TABLE").style.display = 'none'; 

		document.getElementById(id).style.display = 'block';
		document.getElementById(id).scrollTop = 0;
	}
	
	var team = [];
	
	for(i = 0; i < 21; i++) {
		team.push(0);
	}
	
	function remove_player(id)
	{
		var x = id.substr(3,5);
		var pname = "S_".concat(x);
		var pid = "PID_".concat(x);
		var cid = "CID_".concat(x);
		var price_pl = "PRI_".concat(x);		
		
		var price = document.getElementById(price_pl).value;
		
		price = Number(price);
		
		document.getElementById('TEAM_VALUE').value = (Number(document.getElementById('TEAM_VALUE').value) - price).toFixed(1);
		document.getElementById('BANK_BALANCE').value = (Number(document.getElementById('BANK_BALANCE').value) + price).toFixed(1);
		
		team[Number(document.getElementById(cid).value)]--;
		
		document.getElementById(pid).value="";
		document.getElementById(cid).value="";
		document.getElementById(pname).value="";
		document.getElementById(price_pl).value=0;
	}	
		
	
	
	function take_player(id)
	{
		document.getElementById(id).style.background = "#6666FF";
		
		var pname = "#".concat(id.concat(" td:nth-child(1)"));
		var cid = "#".concat(id.concat(" td:nth-child(4)"));
		var pid = "#".concat(id.concat(" td:nth-child(5)"));
		var pos = "#".concat(id.concat(" td:nth-child(6)"));
		var price1 = "#".concat(id.concat(" td:nth-child(3)"));
		var price = Number($(price1).text());
		
		if($(pos).text().localeCompare("GK")==0)
		{			
			flag = false;
			
			for(i=1;i<=2;i++)
			{
				var s_gk = "S_GK".concat(i.toString());
			
				if(document.getElementById(s_gk).value.localeCompare($(pname).text())==0)
				{
					alert("Player already chosen");
					flag = true;
					break;
				}
			}
			
			if(team[Number($(cid).text())]==3)
			{	
				alert("More than 3 players from same team");
				return;
			}
			
			if(!flag)
			{
			for(i=1;i<=2;i++)
			{
				var s_gk = "S_GK".concat(i.toString());
				var pid_gk = "PID_GK".concat(i.toString());
				var cid_gk = "CID_GK".concat(i.toString());
				var pri_gk = "PRI_GK".concat(i.toString());
				
				if(document.getElementById(s_gk).value.localeCompare("")==0)
				{
					document.getElementById(s_gk).value=$(pname).text();
					document.getElementById(pid_gk).value=$(pid).text();
					document.getElementById(cid_gk).value=$(cid).text();
					document.getElementById(pri_gk).value=price;
					document.getElementById('TEAM_VALUE').value = (Number(document.getElementById('TEAM_VALUE').value) + price).toFixed(1);	
					document.getElementById('BANK_BALANCE').value = (Number(document.getElementById('BANK_BALANCE').value) - price).toFixed(1);
					
					team[Number($(cid).text())]++;
					
					flag = true;
					break;
				}
			}
			if(!flag)
			{
				alert("Goalkeepers Full");
			}
			}
		}
		else if($(pos).text().localeCompare("DF")==0)
		{
			flag = false;
			for(i=1;i<=2;i++)
			{
				var s_df = "S_DF".concat(i.toString());
			
				if(document.getElementById(s_df).value.localeCompare($(pname).text())==0)
				{
					alert("Player already chosen");
					flag = true;
					break;
				}
			}
			
			if(team[Number($(cid).text())]==3)
			{	
				alert("More than 3 players from same team");
				return;
			}
			
			if(!flag)
			{
			for(i=1;i<=5;i++)
			{
				var s_df = "S_DF".concat(i.toString());
				var pid_df = "PID_DF".concat(i.toString());
				var cid_df = "CID_DF".concat(i.toString());
				var pri_df = "PRI_DF".concat(i.toString());
			
				if(document.getElementById(s_df).value.localeCompare("")==0)
				{
					document.getElementById(s_df).value=$(pname).text();
					document.getElementById(pid_df).value=$(pid).text();
					document.getElementById(cid_df).value=$(cid).text();
					document.getElementById(pri_df).value=price;
					document.getElementById('TEAM_VALUE').value = (Number(document.getElementById('TEAM_VALUE').value) + price).toFixed(1);	
					document.getElementById('BANK_BALANCE').value = (Number(document.getElementById('BANK_BALANCE').value) - price).toFixed(1);
					
					team[Number($(cid).text())]++;
					
					flag = true;
					break;
				}
			}
			if(!flag)
			{
				alert("Defenders Full");
			}
			}
		}
		else if($(pos).text().localeCompare("MF")==0)
		{
			flag = false;
			
			for(i=1;i<=2;i++)
			{
				var s_mf = "S_MF".concat(i.toString());
			
				if(document.getElementById(s_mf).value.localeCompare($(pname).text())==0)
				{
					alert("Player already chosen");
					flag = true;
					break;
				}
			}
			
			if(team[Number($(cid).text())]==3)
			{	
				alert("More than 3 players from same team");
				return;
			}
			
			if(!flag)
			{
			for(i=1;i<=5;i++)
			{
				var s_mf = "S_MF".concat(i.toString());
				var pid_mf = "PID_MF".concat(i.toString());
				var cid_mf = "CID_MF".concat(i.toString());
				var pri_mf = "PRI_MF".concat(i.toString());
			
				if(document.getElementById(s_mf).value.localeCompare("")==0)
				{
					document.getElementById(s_mf).value=$(pname).text();
					document.getElementById(pid_mf).value=$(pid).text();
					document.getElementById(cid_mf).value=$(cid).text();
					document.getElementById(pri_mf).value=price;
					document.getElementById('TEAM_VALUE').value = (Number(document.getElementById('TEAM_VALUE').value) + price).toFixed(1);	
					document.getElementById('BANK_BALANCE').value = (Number(document.getElementById('BANK_BALANCE').value) - price).toFixed(1);
					
					team[Number($(cid).text())]++;
					
					flag = true;
					break;
				}
			}
			if(!flag)
			{
				alert("Midfielders Full");
			}
			}
		}
		else if($(pos).text().localeCompare("FW")==0)
		{
			flag = false;
			
			for(i=1;i<=2;i++)
			{
				var s_fw = "S_FW".concat(i.toString());
			
				if(document.getElementById(s_fw).value.localeCompare($(pname).text())==0)
				{
					alert("Player already chosen");
					flag = true;
					break;
				}
			}
			
			if(team[Number($(cid).text())]==3)
			{	
				alert("More than 3 players from same team");
				return;
			}
			
			if(!flag)
			{
			for(i=1;i<=3;i++)
			{
				var s_fw = "S_FW".concat(i.toString());
				var pid_fw = "PID_FW".concat(i.toString());
				var cid_fw = "CID_FW".concat(i.toString());
				var pri_fw = "PRI_FW".concat(i.toString());
			
				if(document.getElementById(s_fw).value.localeCompare("")==0)
				{
					document.getElementById(s_fw).value=$(pname).text();
					document.getElementById(pid_fw).value=$(pid).text();
					document.getElementById(cid_fw).value=$(cid).text();
					document.getElementById(pri_fw).value=price;
					document.getElementById('TEAM_VALUE').value = (Number(document.getElementById('TEAM_VALUE').value) + price).toFixed(1);	
					document.getElementById('BANK_BALANCE').value = (Number(document.getElementById('BANK_BALANCE').value) - price).toFixed(1);
					
					team[Number($(cid).text())]++;
					
					flag = true;
					break;
				}
			}
			if(!flag)
			{
				alert("Forwards Full");
			}
			}
		}
	}
</script>	

<?php	

	function get_club_name($cid) 
	{
		require 'connect.php';
	
		$sql = 'SELECT NAME FROM CLUB_TABLE WHERE CLUB_ID = ' . $cid . ';';
		$result = mysqli_query($conn, $sql);
		$tuple = null;

		if($result->num_rows == 1)
		{
			$tuple = mysqli_fetch_array($result);
			
			$cname = $tuple["NAME"];
		}
	
		return $cname;
	}

	
	///////////////////   GK TABLE   //////////////////////
	
	echo '<div id="GK_TABLE"><table>';
	for($i=0; $i<$GK_size; $i++)
    {
		echo '<tr onclick="take_player(this.id)" id="GKR_' . $i .'">';
		echo '<td>' .$GK[$i]['PLAYER_NAME'] .'</td>'
		.'<td>' .get_club_name($GK[$i]['CLUB_ID']) .'</td>'
		.'<td>'.$GK[$i]['PRICE'].'</td>'
		.'<td hidden>'.$GK[$i]['CLUB_ID'].'</td>'
		.'<td hidden>'.$GK[$i]['PLAYER_ID'].'</td>'
		.'<td hidden>'.$GK[$i]['POSITION'].'</td>'; 
		echo '</tr>';
    }
	echo '</table></div>';
	
	///////////////////   DF TABLE   //////////////////////
	
	echo '<div style="display:none" id="DF_TABLE"><table >';
	for($i=0; $i<$DF_size; $i++)
    {
		echo '<tr onclick="take_player(this.id)" id="DFR_' . $i .'">';
		echo '<td>'.$DF[$i]['PLAYER_NAME'].'</td>'
		.'<td>'.get_club_name($DF[$i]['CLUB_ID']).'</td>'
		.'<td>'.$DF[$i]['PRICE'].'</td>'
		.'<td hidden>'.$DF[$i]['CLUB_ID'].'</td>'
		.'<td hidden>'.$DF[$i]['PLAYER_ID'].'</td>'
		.'<td hidden>'.$DF[$i]['POSITION'].'</td>';        
    echo '</tr>';
    }
	echo '</table></div>';
	
	///////////////////   MF TABLE   //////////////////////
	
	echo '<div style="display:none" id="MF_TABLE"><table >';
	for($i=0; $i<$MF_size; $i++)
    {
		echo '<tr onclick="take_player(this.id)" id="MFR_' . $i .'">';
		echo '<td>'.$MF[$i]['PLAYER_NAME'].'</td>'
		.'<td>'.get_club_name($MF[$i]['CLUB_ID']).'</td>'
		.'<td>'.$MF[$i]['PRICE'].'</td>'
		.'<td hidden>'.$MF[$i]['CLUB_ID'].'</td>'
		.'<td hidden>'.$MF[$i]['PLAYER_ID'].'</td>'
		.'<td hidden>'.$MF[$i]['POSITION'].'</td>';             
		echo '</tr>';
    }
	echo '</table></div>';
	
	///////////////////   FW TABLE   //////////////////////
	
	echo '<div style="display:none" id="FW_TABLE"><table >';
	for($i=0; $i<$FW_size; $i++)
    {
		echo '<tr onclick="take_player(this.id)" id="FWR_' . $i .'">';
		echo '<td>'.$FW[$i]['PLAYER_NAME'].'</td>'
		.'<td>'.get_club_name($FW[$i]['CLUB_ID']).'</td>'
		.'<td>'.$FW[$i]['PRICE'].'</td>'
		.'<td hidden>'.$FW[$i]['CLUB_ID'].'</td>'
		.'<td hidden>'.$FW[$i]['PLAYER_ID'].'</td>'
		.'<td hidden>'.$FW[$i]['POSITION'].'</td>';             
    echo '</tr>';
    }
	echo '</table></div>';
?>

<form id="players" action="save_transfer.php" method="POST">
TEAM VALUE : 
<input type="text" disabled id='TEAM_VALUE' name="TEAM_VALUE" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $teamvalue;} else {echo 0.0;}?> style="text-align: center; width: 50px; padding: 5px; border-radius: 20px 20px 20px 20px; border: 0px;"><br>
BANK BALANCE :
<input type="text" disabled id='BANK_BALANCE' name="BANK_BALANCE" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $balance;} else {echo 100.0;}?> style="text-align: center; width: 50px; padding: 5px; border-radius: 20px 20px 20px 20px; border: 0px;"><br>
<input type="text" disabled id='S_GK1' name="S_GK1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $GKP[1]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_GK1">x</button><input type="hidden" id="PID_GK1" name="PID_GK1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $GKP[1]['PLAYER_ID'];}?>"><input type="hidden" id="CID_GK1" name="CID_GK1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $GKP[1]['CLUB_ID'];}?>"><input type="hidden" id="PRI_GK1" name="PRI_GK1" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $GKP[1]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_GK2' name="S_GK2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $GKP[2]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_GK2">x</button><input type="hidden" id="PID_GK2" name="PID_GK2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $GKP[2]['PLAYER_ID'];}?>"><input type="hidden" id="CID_GK2" name="CID_GK2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $GKP[2]['CLUB_ID'];}?>"><input type="hidden" id="PRI_GK2" name="PRI_GK2" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $GKP[2]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_DF1' name="S_DF1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[1]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_DF1">x</button><input type="hidden" id="PID_DF1" name="PID_DF1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[1]['PLAYER_ID'];}?>"><input type="hidden" id="CID_DF1" name="CID_DF1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[1]['CLUB_ID'];}?>"><input type="hidden" id="PRI_DF1" name="PRI_DF1" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[1]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_DF2' name="S_DF2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[2]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_DF2">x</button><input type="hidden" id="PID_DF2" name="PID_DF2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[2]['PLAYER_ID'];}?>"><input type="hidden" id="CID_DF2" name="CID_DF2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[2]['CLUB_ID'];}?>"><input type="hidden" id="PRI_DF2" name="PRI_DF2" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[2]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_DF3' name="S_DF3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[3]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_DF3">x</button><input type="hidden" id="PID_DF3" name="PID_DF3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[3]['PLAYER_ID'];}?>"><input type="hidden" id="CID_DF3" name="CID_DF3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[3]['CLUB_ID'];}?>"><input type="hidden" id="PRI_DF3" name="PRI_DF3" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[3]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_DF4' name="S_DF4" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[4]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_DF4">x</button><input type="hidden" id="PID_DF4" name="PID_DF4" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[4]['PLAYER_ID'];}?>"><input type="hidden" id="CID_DF4" name="CID_DF4" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[4]['CLUB_ID'];}?>"><input type="hidden" id="PRI_DF4" name="PRI_DF4" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[4]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_DF5' name="S_DF5" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[5]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_DF5">x</button><input type="hidden" id="PID_DF5" name="PID_DF5" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[5]['PLAYER_ID'];}?>"><input type="hidden" id="CID_DF5" name="CID_DF5" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[5]['CLUB_ID'];}?>"><input type="hidden" id="PRI_DF5" name="PRI_DF5" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $DFP[5]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_MF1' name="S_MF1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[1]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_MF1">x</button><input type="hidden" id="PID_MF1" name="PID_MF1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[1]['PLAYER_ID'];}?>"><input type="hidden" id="CID_MF1" name="CID_MF1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[1]['CLUB_ID'];}?>"><input type="hidden" id="PRI_MF1" name="PRI_MF1" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[1]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_MF2' name="S_MF2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[2]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_MF2">x</button><input type="hidden" id="PID_MF2" name="PID_MF2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[2]['PLAYER_ID'];}?>"><input type="hidden" id="CID_MF2" name="CID_MF2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[2]['CLUB_ID'];}?>"><input type="hidden" id="PRI_MF2" name="PRI_MF2" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[2]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_MF3' name="S_MF3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[3]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_MF3">x</button><input type="hidden" id="PID_MF3" name="PID_MF3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[3]['PLAYER_ID'];}?>"><input type="hidden" id="CID_MF3" name="CID_MF3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[3]['CLUB_ID'];}?>"><input type="hidden" id="PRI_MF3" name="PRI_MF3" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[3]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_MF4' name="S_MF4" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[4]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_MF4">x</button><input type="hidden" id="PID_MF4" name="PID_MF4" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[4]['PLAYER_ID'];}?>"><input type="hidden" id="CID_MF4" name="CID_MF4" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[4]['CLUB_ID'];}?>"><input type="hidden" id="PRI_MF4" name="PRI_MF4" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[4]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_MF5' name="S_MF5" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[5]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_MF5">x</button><input type="hidden" id="PID_MF5" name="PID_MF5" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[5]['PLAYER_ID'];}?>"><input type="hidden" id="CID_MF5" name="CID_MF5" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[5]['CLUB_ID'];}?>"><input type="hidden" id="PRI_MF5" name="PRI_MF5" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $MFP[5]['PRICE'];} else {echo 0;}?>><br> 
<input type="text" disabled id='S_FW1' name="S_FW1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[1]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_FW1">x</button><input type="hidden" id="PID_FW1" name="PID_FW1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[1]['PLAYER_ID'];}?>"><input type="hidden" id="CID_FW1" name="CID_FW1" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[1]['CLUB_ID'];}?>"><input type="hidden" id="PRI_FW1" name="PRI_FW1" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[1]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_FW2' name="S_FW2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[2]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_FW2">x</button><input type="hidden" id="PID_FW2" name="PID_FW2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[2]['PLAYER_ID'];}?>"><input type="hidden" id="CID_FW2" name="CID_FW2" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[2]['CLUB_ID'];}?>"><input type="hidden" id="PRI_FW2" name="PRI_FW2" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[2]['PRICE'];} else {echo 0;}?>><br>
<input type="text" disabled id='S_FW3' name="S_FW3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[3]['PLAYER_NAME'];}?>"><button type="button" onclick="remove_player(this.id)" id="RM_FW3">x</button><input type="hidden" id="PID_FW3" name="PID_FW3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[3]['PLAYER_ID'];}?>"><input type="hidden" id="CID_FW3" name="CID_FW3" value="<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[3]['CLUB_ID'];}?>"><input type="hidden" id="PRI_FW3" name="PRI_FW3" value=<?php if(!isset($_SESSION['SIGNEDUP'])) {echo $FWP[3]['PRICE'];} else {echo 0;}?>><br>
<input type='submit' value='Confirm Team' style="position: absolute; padding: 10px; padding-right:15px; top: 100px; right: 360px; z-index: 99; border-radius: 20px 20px 20px 20px; border: 0px;">
</form>	

</body>
</html>
