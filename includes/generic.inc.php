<?php
function GetConnected()
{
	$CON = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD)or die("<strong>ERROR CODE : </strong> COM - 66");
	mysqli_select_db($CON, DB_NAME) or die("<strong>ERROR CODE : </strong> NEW_COM - 67"); 
	
	return $CON;	
}

function NextID($f,$tbl, $base_num='0', $cond='')
{
	$cond_str = (trim($cond)!='')? ' where '.$cond: '';

	$query = "select max($f) from $tbl $cond_str";
	$result = sql_query($query, 'COM13'); 
	list($rid)=sql_fetch_row($result);

	if(!is_numeric ( $rid))
		$rid=0;

	$rid++;

	if(!empty($base_num))
	{
		$_id = GetXFromYID("select $base_num from sys_config");
		if($rid < $_id)
			$rid = $_id;
	}

	return $rid;			
}
function GetXFromYID($q)
{
	$str = false;
	$result = sql_query($q, 'COM25'); 
	
	if(sql_num_rows($result))
		list($str) = sql_fetch_row($result);

	return $str;
}

function GetXArrFromYID($q, $mode="1")
{
	$arr = array();
	$r = sql_query($q, 'COM39');
	
	if(sql_num_rows($r))
	{
		if($mode == "2")
			for($i=0; list($x) = sql_fetch_row($r); $i++)
				$arr[$i] = $x;
		else if($mode == "3")
			for($i=0; list($x, $y) = sql_fetch_row($r); $i++)
				$arr[$x] = $y;
		else if($mode == "4")
			while($a = sql_fetch_assoc($r))
				$arr[$a['I']] = $a;
		else
			while(list($x) = sql_fetch_row($r))
				$arr[$x] = $x;
	}

	return $arr;
}

function GetMaxRank($tbl, $cond="", $fld='iRank')
{
	$cond = (strtoupper(trim($cond)) != "")? " where " . $cond: "";	

	$q = "select max($fld) from $tbl $cond";	
	$r = sql_query($q, 'GEN.94');
	list($max)=sql_fetch_row($r);

	if($max < 1)
		$max = 0;

	return ++$max;
}

function FillTreeData($selected, $ctr, $tp, $comp, $flds, $tbl, $cond, $fn="", $class="form-control")
{	
	$display = ($tp=="COMBO" || $tp=="COMBO2")? "": "size=10";
	$cond = (strtoupper(trim($cond)) != 'N' && trim($cond)!='')? " where " . $cond: "";	
	$class_str = (trim($class)=="")? "": $class;

	$stat_fld = ($tp == "COMBO")? ", 'A' ": ", cStatus";
	
	$q = "select " . $flds . ", iLevel " . $stat_fld . " from " . $tbl . $cond . " order by iRank, vName";
	$result = sql_query($q, 'GEN.112');
	$str = '<select name="'.$ctr.'" id="'.$ctr.'" class="'.$class_str.'" '.$display.' '.$fn.'>'."\n"; //

	if($comp<>'y'&&$comp<>'Y') 
	{
		$str .= '<option value="0" selected> - select - </option>'."\n";
	}

	while(list($id, $nm, $level,$stat)=sql_fetch_row($result))
	{
		$stat_style = ($stat=="A" && $tp=="COMBO2")? "": ' style="background-color: #FFC5C5;"';
		$selected_str = (trim($selected) == trim($id))? "selected": "";
		$space = GenerateSpace($level);
		$str .=  '<option value="'.$id.'" '.$selected_str.'>'.$space.$nm.'</option>'."\n";
	}

	$str .= '</select>'."\n";
	return $str;
}

// function FillTreeCombo($selected, $ctr, $tp, $comp, $cond, $fn="", $class="form-control")
function FillTreeCombo($selected, $ctr, $type, $comp, $values, $fn="", $class="form-control", $combo_type="KEY_VALUE") //fill the values from an array
{
	$display = ($type<>"COMBO" && $type<>"COMBO2")? "size=10": "";

	$str = "<select name='$ctr' id='$ctr' class='$class' $display $fn>"; //  

	if(($comp<>"y" )&&( $comp<>"Y") )
	{
		if($comp=='0')
			$str .= "<option value='0' selected> - select - </option>\n";
		elseif($comp=='1')
			$str .= "<option value='0' selected> - main category - </option>\n";
		elseif($comp=='2')
			$str .= "<option value='0' selected>MM</option>\n";
		elseif($comp=='-1')
			$str .= "<option value='-1' selected> - select - </option>\n";
		else
			$str .= "<option value='0' selected> - select - </option>\n";
	}
	
	if($combo_type == "KEY_VALUE")
	{
		foreach($values as $key=>$V)
		{
			$stat_style = ($V['status']=='A')? "": ' style="background-color: #FFC5C5;"';
			$select_str = ($selected==$key)? "selected": "";
			$space = GenerateSpace($V['level']);
			$str .=  '<option value="'.$key.'" '.$select_str.$stat_style.'>'.$space.$V['text'].'</option>'."\n";
		}
	}

	$str .= "</select>";
	return $str;
}

function FillData($selected, $ctr, $tp, $comp, $flds, $tbl, $cond, $ord, $fn="", $class="form-control")
{	
	$display = ($tp=="COMBO" || $tp=="COMBO2")? "": "size=10";
	$cond = (strtoupper(trim($cond)) != 'N' && trim($cond)!='')? " where " . $cond: "";	
	$class_str = (trim($class)=="")? "": $class;

	$stat_fld = ($tp == "COMBO")? ", 'A' ": ", cStatus";
	
	$q = "select " . $flds . $stat_fld . " from " . $tbl . $cond . " order by " . $ord;
	$result = sql_query($q, 'GEN.141'); 
	$str = '<select name="'.$ctr.'" id="'.$ctr.'" class="'.$class_str.'" '.$display.' '.$fn.'>'."\n"; //

	if($comp<>'y'&&$comp<>'Y')
	{
		if($comp=='-1')
			$str .= '<option value="" selected> - Select Year - </option>'."\n";
		if($comp=='-2')
			$str .= '<option value="" selected> - Select Round - </option>'."\n";
		else
			$str .= '<option value="0" selected> - Select - </option>'."\n";
	}

	while(list($id,$nm,$stat)=sql_fetch_row($result))
	{
		$stat_style = ($stat=="A" && $tp=="COMBO2")? "": ' style="background-color: #FFC5C5;"';
		$selected_str = (trim($selected) == trim($id))? "selected": "";
		$str .=  '<option value="'.$id.'" '.$selected_str.'>'.$nm.'</option>'."\n";
	}

	$str .= '</select>'."\n";
	return $str;
}

function FillCombo($selected, $ctr, $type, $comp, $values, $fn="", $class="form-control", $combo_type="KEY_VALUE") //fill the values from an array
{
	$display = ($type<>"COMBO" && $type<>"COMBO2")? "size=10": "";

	$str = "<select name='$ctr' id='$ctr' class='$class' $display $fn>"; //  

	if(($comp<>"y" )&&( $comp<>"Y") )
	{
		if($comp=='0')
			$str .= "<option value='' selected> - Select  - </option>\n";
		elseif($comp=='-1')
			$str .= "<option value='' selected> - Select Owner  - </option>\n";
		elseif($comp=='-2')
			$str .= "<option value='' selected> - Select Vehicle Type  - </option>\n";
		elseif($comp=='-3')
			$str .= "<option value='' selected> - Select Vehicle Transmission  - </option>\n";
		elseif($comp=='-4')
			$str .= "<option value='' selected> - Select Vehicle Fuel  - </option>\n";
		elseif($comp=='-5')
			$str .= "<option value='' selected> - Select Type  - </option>\n";
		elseif($comp=='-6')
			$str .= "<option value='' selected> - Select Round  - </option>\n";
		else
			$str .= "<option value='' selected> - Select $comp  - </option>\n";
	}
	
	if($combo_type == "KEY_VALUE")
	{
		if($type=='COMBO2')
		{
			foreach($values as $key=>$V)
			{
				$stat_style = ($V['status']=='A')? "": ' style="background-color: #FFC5C5;"';
				$select_str = ($selected==$key)? "selected": "";
				$str .=  '<option value="'.$key.'" '.$select_str.$stat_style.'>'.$V['text'].'</option>'."\n";
			}
		}
		else
		{
			foreach($values as $key_val=>$var)
			{
				$select_str = ($selected==$key_val)? "selected": "";
				$str .= '<option value="'.$key_val.'" '.$select_str.'>'.$var.'</option>';
			}
		}
	}
	elseif($combo_type == "KEY_IS_VALUE")
	{
		foreach($values as $var)
		{
			$select_str = ($selected==$var)? "selected": "";
			$str .= "<option value='$var' $select_str> $var</option>";
		}
	}
	elseif($combo_type == "SPLIT_FOR_KEY_VALUE")
	{
		foreach($values as $var)
		{
			$v = explode("~", $var);
			$key = $v[0];
			$txt = $v[1];
			
			$select_str = ($selected==$key)? "selected": "";
			$str .= "<option value='$key' $select_str> $txt</option>";
		}
	}

	$str .= "</select>";
	return $str;
}

function FillMultipleData($selected_arr, $ctr, $tp, $comp, $flds, $tbl, $cond, $ord ,$fn="")
{	
	$display = (!empty($tp))? "size=" . $tp: "";
	$cond = (strtoupper(trim($cond)) != 'N')? " where " . $cond: "";	

	$q = "select " . $flds . " from " . $tbl . $cond . " order by " . $ord;
	$result = sql_query($q, 'COM190'); 

	$str ="<select name='".$ctr."[]' multiple='multiple' id='$ctr' class='multiselect-dropdown form-control' $display $fn>\n"; //  

	if($comp<>'y'&&$comp<>'Y') 
	{
		if($comp=='0')
			$str .= "<option value='0'> -- select -- </option>\n";
		else
			$str .= "<option value='0' selected> - select one - </option>\n";
	}

	while(list($id,$nm)=sql_fetch_row($result))
	{
		$selected_str = (in_array($id, $selected_arr))? "selected": "";
		$str .=  "<option value='$id' $selected_str>$nm</option>\n";
	}

	$str .= "</select>\n";
	return $str;
}

function FormatDate($date_val, $flag="A")
{
	$dt="";
	$date_val = trim($date_val);

	if($date_val != "" && $date_val!='0000-00-00' && $date_val!="0000-00-00 00:00:00")
	{
		$time_val = strtotime($date_val);
		
		if($flag=="A")	$date_format = "d M";
		elseif($flag=="B")	$date_format = "d M Y";
		elseif($flag=="C")	$date_format = "d-m-Y h:i A";
		elseif($flag=="D")	$date_format = "d M Y h:i A";
		elseif($flag=="E")	$date_format = "H:i";
		elseif($flag=="F")	$date_format = "d/m/y h:i a";
		elseif($flag=="G")	$date_format = "d/m/Y";
		elseif($flag=="H")	$date_format = "Y-m-d";
		elseif($flag=="I")	$date_format = "D, F j";
		elseif($flag=="J")	$date_format = "D, M j";
		elseif($flag=="K")	$date_format = "d/m/y";
		elseif($flag=="L")	$date_format = "M y";
		elseif($flag=="M")	$date_format = "d M Y";
		elseif($flag=="N")	$date_format = "d/m";
		elseif($flag=="O")	$date_format = "d\<\b\\r\>M";
		elseif($flag=="P")	$date_format = "d/m H:i";
		elseif($flag=="Q")	$date_format = "d/M/y";
		elseif($flag=="R")	$date_format = "m/y";
		elseif($flag=="S")	$date_format = "Y-m";
		elseif($flag=="T")	$date_format = "d M\<\b\\r\>D";
		elseif($flag=="U")	$date_format = "dS F Y, H:i A";
		elseif($flag=="V")	$date_format = "d-M-Y";
		elseif($flag=="W")	$date_format = "d-M-Y H:i a";
		elseif($flag=="X")	$date_format = "D, d M Y";
		elseif($flag=="Y")	$date_format = "D, d M Y H:i a";
		elseif($flag=="Z")	$date_format = "my";
		elseif($flag=="1")	$date_format = "d-M-Y";
		elseif($flag=="2")	$date_format = "d\<\s\u\p\>S\<\/\s\u\p\> F, Y";
		elseif($flag=="3")	$date_format = "M d";
		elseif($flag=="4")	$date_format = "h:i a";
		elseif($flag=="5")	$date_format = "l, d F Y - H:i";
		elseif($flag=="6")	$date_format = "dS M Y";
		elseif($flag=="7")	$date_format = "g";
		elseif($flag=="8")	$date_format = "i";
		elseif($flag=="9")	$date_format = "Y";
		elseif($flag=="10")	$date_format = "F d, Y H:i:s";
		elseif($flag=="11")	$date_format = "d-m-Y";
		elseif($flag=="12")	$date_format = "s";
		elseif($flag=="13")	$date_format = "m";
		elseif($flag=="14")	$date_format = "d.m.Y";
		elseif($flag=="15")	$date_format = "d/m/y h:ia";
		elseif($flag=="16") $date_format = "D, M d, H:i A";
		elseif($flag=="17")	$date_format = "h:i";
		elseif($flag=="18")	$date_format = "Y-m";
		elseif($flag=="19")	$date_format = "F, d Y";
		elseif($flag=="20")	$date_format = "F";
		elseif($flag=="21")	$date_format = "M";
		elseif($flag=="22")	$date_format = "m/d/Y";
		elseif($flag=="23")	$date_format = "d";
		elseif($flag=="24")	$date_format = "g:iA";
		elseif($flag=="25")	$date_format = "g:ia";
		elseif($flag=="26")	$date_format = "F d, Y";
	  	else $date_format = "d/m/y";

		$dt = date($date_format, $time_val);
	}

	return $dt;
}

function GetStatusImageString($mode, $status, $id, $ajax_flag=true)
{
	$str = "";
	if($ajax_flag)
	{
		if($status=="A") $str = '<button type="button" class="btn btn-success btn-icon btn-sm" onClick="ChangeStatus(this, \''.$mode.'\',\'I\',\''.$id.'\'); return false;"><i class="fa fa-check"></i></button>';
		else if($status=='P') $str = '<button class="btn btn-warning btn-icon btn-sm" onClick="ChangeStatus(this, \''.$mode.'\',\'A\',\''.$id.'\'); return false;"><i class="fa fa-timnes"></i></button>';
		else $str = '<button class="btn btn-danger btn-icon btn-sm" onClick="ChangeStatus(this, \''.$mode.'\',\'A\',\''.$id.'\'); return false;"><i class="fa fa-times"></i></button>';
	}
	else
	{
		if($status=="A") $str = '<i class="fa fa-check"></i>';
		else if($status=='P') $str = '<i class="fa fa-times"></i>';
		else $str = '<i class="fa fa-times"></i>';
	}


	return $str;
}
function GetYesNoImageString($mode, $status, $id, $ajax_flag=true)
{
	$str = "";
	if($ajax_flag)
	{
		if($status=="Y") $str = '<a onClick="ChangeYesNoStatus(this, \''.$mode.'\',\'N\',\''.$id.'\'); return false;">' . YES_IMG . '</a>';
		else $str = '<a onClick="ChangeYesNoStatus(this, \''.$mode.'\',\'Y\',\''.$id.'\'); return false;">' . NO_IMG . '</a>';
	}
	else
	{
		if($status=="Y") $str = YES_IMG;
		else $str = NO_IMG;
	}

	return $str;
}

function GetFeaturedImageString($mode, $status, $id, $ajax_flag=true)
{
	$str = "";
	if($ajax_flag)
	{
	
		if($status=="Y") $str = '<a style="cursor:pointer;" onClick="ChangeFeatured(this, \''.$mode.'\',\'N\',\''.$id.'\'); return false;">' . FEATURED_IMG . '</a>';
		else $str = '<a style="cursor:pointer;" onClick="ChangeFeatured(this, \''.$mode.'\',\'Y\',\''.$id.'\'); return false;">' . UNFEATURED_IMG . '</a>';

	}
	else
	{
		if($status=="Y") $str = FEATURED_IMG;
		else $str = UNFEATURED_IMG;
	}

	return $str;
}

function IsExistFile($file, $path)
{
	$file = trim($file);
	$path = trim($path);
	
	if( ($file != "") && (strtoupper($file) != "NA") )
	{
		$f = $path . $file;
		//echo($f);
		//exit;
		if(file_exists($f))
			return 1;
	}

	return 0;
}

function DeleteFile($file, $path)
{
	$file = trim($file);
	$path = trim($path);
	
	if( ($file != "") && (strtoupper($file) != "NA") )
	{
		$f = $path . $file;
		if(file_exists($f))
			unlink ($f);
	}
}

function DisplayFormattedArray($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function NormalizeFilename($filename, $newname="")
{
	$filename = trim($filename);
	$pos = strrpos($filename, ".");
	$str_nm = (trim($newname!=""))? $newname: substr($filename,0,$pos);
	$str_ext = substr($filename,$pos);
	
	$invalid_chars=array('`','=',' ','\\','[',']',';','\'',',','/','~','!','@','#','$','%','^','&','*','(',')','|','{','}',':','\"','<','>','?');

	foreach($invalid_chars as $I)
		$str_nm = str_replace($I, "-", $str_nm);

	$str_nm .= $str_ext;
	return $str_nm;
}

function ConvertFromYMDtoDMY($ymd_date, $tmode = false)
{
	$year = $mnth = $days = $hour = $mins = $secs = 0;
	
	if(trim($ymd_date)=="") return $ymd_date;
	elseif($ymd_date == "0000-00-00 00:00:00" || $ymd_date == "0000-00-00") return "";
	
	if($tmode) // time also included
	{
		$t_arr = explode(' ', $ymd_date);
		if(count($t_arr) < 2) return "";
		
		$ymd_date = $t_arr[0];
		$time_str = $t_arr[1];
		
		$tm_arr = explode(':', $time_str);
		if(count($tm_arr) < 3) return "";
		
		$hour = $tm_arr[0];
		$mins = $tm_arr[1];
		$secs = $tm_arr[2];
	}

	$dt_arr = explode('-', $ymd_date);
	if(count($dt_arr) < 3) return "";

	$year = $dt_arr[0];
	$mnth = $dt_arr[1];
	$days = $dt_arr[2];
	
	if($tmode)
		$dmy_date = $days."-".$mnth."-".$year." ".$hour.":".$mins.":".$secs;
	else
		$dmy_date = $days."-".$mnth."-".$year;

	return $dmy_date;
}

function ConvertFromDMYToYMD($dmy_date, $tmode=false)
{
	$year = $mnth = $days = $hour = $mins = $secs = 0;

	if(trim($dmy_date) == "") return $dmy_date;
	elseif($dmy_date == "0000-00-00 00:00:00" || $dmy_date == "0000-00-00") return "";

	if($tmode) // time also included
	{
		$t_arr = explode(' ', $dmy_date);
		if(count($t_arr) < 2) return "";

		$dmy_date = $t_arr[0];
		$time_str = $t_arr[1];
		
		$tm_arr = explode(':', $time_str);
		if(count($tm_arr) < 3) return "";

		$hour = $tm_arr[0];
		$mins = $tm_arr[1];
		$secs = $tm_arr[2];
	}

	$dt_arr = explode('-', $dmy_date);
	if(count($dt_arr) < 3) return "";

	$days = $dt_arr[0];
	$mnth = $dt_arr[1];
	$year = $dt_arr[2];
	
	if($tmode)
		$ymd_date = $year."-".$mnth."-".$days." ".$hour.":".$mins.":".$secs;
	else
		$ymd_date = $year."-".$mnth."-".$days;

	return $ymd_date;
}

function ParseStringForSQL($sqlstr)
{
	$tmp_str = trim($sqlstr);
	$tmp_str = stripslashes($tmp_str);
	$tmp_str = str_replace("'", "''", $tmp_str);
	$tmp_str = str_replace('\\', '\\\\', $tmp_str);
	return $tmp_str;
}

function CheckForXSS($string)
{
	$str = '';
	$x = array('onblur','onchange','onclick','ondblclick','onfocus','onkeydown','onkeypress','onkeyup','onmousedown','onmousemove','onmouseout','onmouseover','onmouseup','onreset','onselect','onsubmit');
	$str = str_replace($x,"",$string);

	return $str;
}
function db_input($string)
{
	$string = CheckForXSS($string);
	//return (get_magic_quotes_gpc())? htmlspecialchars(addslashes($string)): htmlspecialchars(addslashes($string));
	return htmlspecialchars(addslashes($string));
}

function db_input2($string)
{
	$string = CheckForXSS($string);
	//return (get_magic_quotes_gpc())? htmlspecialchars(addslashes($string)): htmlspecialchars(addslashes($string));
	return htmlspecialchars(addslashes($string));
}

/**
 * DB Input with Default
 *
 * @param mixed		$string		Input
 * @param string	$type		Input data type ['dt', 'd', 't', 'v', 'c', 'i', 'f']
 * @param string	$quote		quote type " or '
 * @param string	$default	Input default value can be SQL DEFAULT or NULL or actual value
 * @return string
 **/
function db_input_default($string, $type, $quote="'", $default='DEFAULT')
{
	switch ($type)
	{
		case 'dt':
		case 'd':
		case 't':
		case 'v':
		case 'c':
			$string = !empty($string)?$quote.db_input($string).$quote:$default;
		break;

		case 'i':
		case 'f':
		default:
			$string = !empty($string)?db_input($string):$default;
		break;
	}
	return $string;
}

function db_output($string) 
{
	$string = trim($string);
	return htmlspecialchars($string, ENT_QUOTES);
}

function db_output2($string) 
{
	$string = trim($string);
	//if(!get_magic_quotes_gpc()) $string = stripslashes($string);
	$string = stripslashes($string);
	return htmlspecialchars_decode($string, ENT_QUOTES);
}

function Delay($number=100)
{
	for($i=0; $i < $number; $i++);
}

function FormatNumber($number, $pad_len=0, $mode='ind') // int: international; ind: indian
{
	$sign = ($number < 0)? '-': '';
	$number = abs($number);
	
	if($mode == 'ind')
		$number = exp_to_dec($number);

	$dot = 	strrpos($number, ".");
	$int_buffer = array();

	if($dot===false)
	{
		$int_part  = $number;
		$deci_part = "";
	}
	else
	{
		$int_part = substr($number, 0, $dot);
		$deci_part = substr($number, $dot+1);
	}
	
	// echo '['.$mode . ' ' .$int_part.' . '.$deci_part.']<br>';

	if($pad_len > 0)
	{
		if($deci_part!='')
		{
			$deci_part_str = round('0.'.$deci_part, $pad_len);

			if($deci_part_str >= 1) // decimals have rounded up to 1 => increment integer part...
				$int_part++;
				
			$deci_part = substr($deci_part_str, 2);// , $dot+1);
		}
	}

	if($mode=='ind')
	{
		$len = strlen($int_part);
		for($i=$len-1; $i >= 0; $i--)
			$int_buffer[$i] = substr($int_part, $i, 1);
		
		$i=0;
		$int_part = "";
		foreach($int_buffer as $digit)
		{		
			$int_part = ( ($i==3) || ($i==5) || ($i==7) || ($i==9) ) ? $digit . "," . $int_part: $int_part = $digit . $int_part;			
			$i++;
		}
	}
	else if($mode == 'int')
	{
		$int_part = number_format($int_part);
	}

	$number = $int_part;
	
	if($pad_len > 0)
		$number .=  "." . str_pad($deci_part, $pad_len, "0");

	return $sign . $number;		
}

// formats a floating point number string in decimal notation, supports signed floats, also supports non-standard formatting e.g. 0.2e+2 for 20
// e.g. '1.6E+6' to '1600000', '-4.566e-12' to '-0.000000000004566', '+34e+10' to '340000000000'
// Author: Bob
function exp_to_dec($float_str)
{
    // make sure its a standard php float string (i.e. change 0.2e+2 to 20)
    // php will automatically format floats decimally if they are within a certain range
    $float_str = (string)((float)($float_str));

    // if there is an E in the float string
    if(($pos = strpos(strtolower($float_str), 'e')) !== false)
    {
        // get either side of the E, e.g. 1.6E+6 => exp E+6, num 1.6
        $exp = substr($float_str, $pos+1);
        $num = substr($float_str, 0, $pos);
       
        // strip off num sign, if there is one, and leave it off if its + (not required)
        if((($num_sign = $num[0]) === '+') || ($num_sign === '-')) $num = substr($num, 1);
        else $num_sign = '';
        if($num_sign === '+') $num_sign = '';
       
        // strip off exponential sign ('+' or '-' as in 'E+6') if there is one, otherwise throw error, e.g. E+6 => '+'
        if((($exp_sign = $exp[0]) === '+') || ($exp_sign === '-')) $exp = substr($exp, 1);
        else trigger_error("Could not convert exponential notation to decimal notation: invalid float string '$float_str'", E_USER_ERROR);
       
        // get the number of decimal places to the right of the decimal point (or 0 if there is no dec point), e.g., 1.6 => 1
        $right_dec_places = (($dec_pos = strpos($num, '.')) === false) ? 0 : strlen(substr($num, $dec_pos+1));
        // get the number of decimal places to the left of the decimal point (or the length of the entire num if there is no dec point), e.g. 1.6 => 1
        $left_dec_places = ($dec_pos === false) ? strlen($num) : strlen(substr($num, 0, $dec_pos));
       
        // work out number of zeros from exp, exp sign and dec places, e.g. exp 6, exp sign +, dec places 1 => num zeros 5
        if($exp_sign === '+') $num_zeros = $exp - $right_dec_places;
        else $num_zeros = $exp - $left_dec_places;
       
        // build a string with $num_zeros zeros, e.g. '0' 5 times => '00000'
        $zeros = str_pad('', $num_zeros, '0');
       
        // strip decimal from num, e.g. 1.6 => 16
        if($dec_pos !== false) $num = str_replace('.', '', $num);
       
        // if positive exponent, return like 1600000
        if($exp_sign === '+') return $num_sign.$num.$zeros;
        // if negative exponent, return like 0.0000016
        else return $num_sign.'0.'.$zeros.$num;
    }
    // otherwise, assume already in decimal notation and return
    else return $float_str;
}

function DateDiff($date1, $date2, $mode='1')
{
	list($yr1, $mnt1, $day1) = explode('-', $date1);
	$xx=gmmktime ( 0, 0, 0, $mnt1,$day1,$yr1);
		
	list($yr2, $mnt2, $day2) = explode('-', $date2);	
	$xy = gmmktime(0, 0, 0, $mnt2, $day2, $yr2);
	
	$diff=$xy-$xx;
	$min=$diff/60;
	$hr=$min/60;
	$day=$hr/24;
	
	if($mode == '2')
	{
		$month_arr = array(1=>31, 2=>28, 3=>31, 4=>30, 5=>31, 6=>30, 7=>31, 8=>31, 9=>30, 10=>31, 11=>30, 12=>31);
		$y = $yr2 - $yr1;
		$m = $mnt2 - $mnt1;
		
		if($m < 0)
		{
			$m = 12 + $m;
			$y -= 1;
		}
			
		$d = $day2 - $day1;
		
		if($d < 0)
		{
			$mnt1 = ltrim($mnt1, '0');

			$_adj = $month_arr[$mnt1];			
			if($mnt1==2 && IsLeapYear($y1)) // if start month is Feb and is a Leap Year
				$_adj += 1;
			
			$d = $_adj + $d;			
			$m -= 1;
		}
	
		$y_txt = ($y)? ($y>1)? $y . " yr ": "1 yr ": "";
		$m_txt = ($m)? ($m>1)? $m . " mnths ": "1 mnth ": "";
		$d_txt = ($d)? ($d>1)? $d . " days ": "1 day ": "";
		
		if($y_txt != '')
			$m_txt = "," . $m_txt;
			
		if($m_txt != '')
			$d_txt = "," . $d_txt;

		
		$ret_val = $y_txt . $m_txt . $d_txt;
	}
	else
		$ret_val = $day;
		
	return $ret_val;
}

function IsLeapYear($yr)
{
	return ($yr%4==0 && $yr%100!=0)? true: false;
}

function DateTimeAdd($date, $dd=0, $mm=0, $yy=0, $hh=0, $nn=0, $ss=0, $format="Y-m-d H:i:s")
{
	$d = date("Y-m-d H:i:s", strtotime($date));
	
	//echo $d . " ($dd, $mm, $yy) <br>";	
	$t_arr = explode(' ', $d);
	$date_str = $t_arr[0];
	$time_str = $t_arr[1];
		
	$tm_arr = explode(':', $time_str);
	$hour = $tm_arr[0];
	$mins = $tm_arr[1];
	$secs = $tm_arr[2];

	$dt_arr = explode('-', $date_str);
	$year = $dt_arr[0];
	$mnth = $dt_arr[1];
	$days = $dt_arr[2];

//	echo "mktime($hour, $mins, $secs, ($mnth + $mm), ($days + $dd), ($year + $yy)) <br>";
	$t = mktime(($hour + $hh), ($mins + $nn), ($secs + $ss), ($mnth + $mm), ($days + $dd), ($year + $yy));
	
	if(empty($format)) $format = "Y-m-d H:i:s";		
	$date = date($format, $t);

	return $date;
}

function NewlinesToBR($str, $replace_str='<br />')
{
	return preg_replace("/(\r\n)+|(\n|\r)+/", $replace_str, $str); 
}

function GetRelativeDateDesc($date)
{
	$str = 'Today';
	$d = DateDiff($date, TODAY);
	
	if($d == 1) $str = 'yesterday';
	else if($d > 1) $str = $d . ' days ago';
	else if($d == -1) $str = 'tomorrow';
	else if($d < -1) $str = abs($d) . ' days ahead';
	
	return $str;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
function check_inject($sql_in) 
{
	if (strstr($sql_in,'/*') || strstr($sql_in,'--') || stristr($sql_in,'<script>') || stristr($sql_in,'</script>')) 
		return false;
		
	return true;
}

function shuffle_assoc(&$array) 
{
	if (count($array)>1) //$keys needs to be an array, no need to shuffle 1 item anyway
	{ 
		$keys = array_rand($array, count($array));
		
		foreach($keys as $key)
			$new[$key] = $array[$key];
		
		$array = $new;
	}
	
	return true; //because it's a wannabe shuffle(), which returns true
}

function input_check_mailinj($value)
{
   # mail adress(ess) for reports...
   //$report_to = "noreply@goenchobalcao.com";

   # array holding strings to check...
   $suspicious_str = array("content-type:", "charset=", "mime-version:", "content-transfer-encoding:", "multipart/mixed", "bcc:");

   // remove added slashes from $value...
   $value = stripslashes($value);

   foreach($suspicious_str as $suspect)
   {
       # checks if $value contains $suspect...
       if(eregi($suspect, strtolower($value)))
       {
           $ip = (empty($_SERVER['REMOTE_ADDR'])) ? 'empty' : $_SERVER['REMOTE_ADDR']; // replace this with your own get_ip function...
           $rf = (empty($_SERVER['HTTP_REFERER'])) ? 'empty' : $_SERVER['HTTP_REFERER'];
           $ua = (empty($_SERVER['HTTP_USER_AGENT'])) ? 'empty' : $_SERVER['HTTP_USER_AGENT'];
           $ru = (empty($_SERVER['REQUEST_URI'])) ? 'empty' : $_SERVER['REQUEST_URI'];
           $rm = (empty($_SERVER['REQUEST_METHOD'])) ? 'empty' : $_SERVER['REQUEST_METHOD'];

           die('Script processing cancelled: Your request contains text portions that are ' .
               'potentially harmful to this server. <em>Your input has not been sent!</em> Please use your ' .
               'browser\'s `back`-button to return to the previous page and try refreshing your input.</p>');
       }
   }
}

function CheckSPAM($string)
{
	/* $len=strlen($string);
	$tmp = "";

	for($i=0;$i<=$len;$i++)
	{
		$c=substr($string,$i,1);
		if( (ord($c)>=0 && ord($c)<=127) || ord($c)==156) $tmp .= $c;
		elseif(ord($c)==146)	$tmp .= chr(39);
		else	return 0;
	}

	return $tmp; */
	
	$len=strlen($string);

	for($i=0;$i<=$len;$i++)
	{
		$c=substr($string,$i,1);
		if( (ord($c)>=0 && ord($c)<=127) || ord($c)==156 ) {}
		else
			return false;	
	}
	return true;
}

function GetFolderFileArr($DIR_UPLOAD, $DIR_PATH, $mode=0)
{
	$image_arr = array();
	
	$dir_resource = opendir($DIR_UPLOAD);
	
	for($i=0; $file_name = readdir($dir_resource);)
		if(($file_name!=".") && ($file_name!="..") && (strtolower($file_name)!="thumbs.db") && file_exists($DIR_UPLOAD . $file_name))
			$image_arr[$i++] = $file_name;

	closedir($dir_resource);
	
	return $image_arr;
}

function EnsureValidMode($mode, $valid_modes, $default_mode)
{
	if(empty($mode) || !in_array($mode, $valid_modes))
		$mode = $default_mode;
		
	return $mode;
}

function Str2Arr($str)
{
	$arr = array();

	for($i=0; $i < strlen($str); $i++)
		$arr[$i] = substr($str, $i, 1);
		
	return $arr;
}

function GetFileName($filedir)
{
	$dir = opendir($filedir);

	while ($file_name = readdir($dir)) 
		if($file_name!="." && $file_name!="..")
			return $file_name;
}

function ValidateNumber($num, $default='0')
{
	if(!is_numeric($num))
		$num = $default;
	
	return $num;		
}

function th($number, $flag="")
{
	$suffix = "";
	
	$last_digit = substr($number, -1);
	
	if($last_digit == "1")
		$suffix = "st";
	elseif($last_digit == "2")
		$suffix = "nd";
	elseif($last_digit == "3")
		$suffix = "rd";
	else
		$suffix = "th";		
	
	if($flag == "A")
		$suffix = "<sup>" . $suffix . "</sup>";
		
	return $number . $suffix;
}

function DownloadFile($PATH, $UPLOAD, $file_name)
{
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=".basename($PATH.$file_name).";");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($UPLOAD.$file_name));
	readfile($PATH.$file_name);
	exit();
}

function SetSessionInfo($str)
{
	global $sess_info, $lbl_display;
	$sess_info = $str;
	$lbl_display = ($sess_info!="")? '': 'none';
}

function WriteFile($file_name, $file_str)
{
	$handle = fopen(PRINT_UPLOAD.$file_name, 'w+');
	fwrite($handle, $file_str);
	fclose($handle);
}

function PrintMultiLine($str, $contd=1, $limit=40)
{
	$print_str = '';
	$str = trim($str);
	
	if($str != '')
	{
		$len = strlen($str);
		$x_str = ($len > $limit)? substr($str, 0, $limit): $str;
		$print_str = $x_str.NEWLINE;

		
		if($contd)
		{
			$limit -= 3;
			$contd_str = ' ..';
		}
		else
			$contd_str = '';
			
		if($len > $limit)
			for($a = $limit+3; $a < $len; $a += $limit)
				$print_str .= $contd_str.substr($str, $a, $limit).NEWLINE;
	}
	
	return $print_str;
}

function SearchFromMemory($flag, $disp_url)
{
	global $_SESSION;
	$url_str = $disp_url;
	
	if(isset($_SESSION[PROJ_SESSION_ID]->srch_ctrl_arr[$flag]))
	{
		$srch_ctrl_arr = $_SESSION[PROJ_SESSION_ID]->srch_ctrl_arr[$flag];
		$url_str = $disp_url."?srch_mode=QUERY";
			
		foreach($srch_ctrl_arr as $ctrl_nm=>$ctrl_val)
		{
			if($ctrl_nm == "srch_mode" || $ctrl_nm == "FORM")
				continue;
		
			$url_str .= "&" . $ctrl_nm . "=" . $ctrl_val;
		}
	}

	header("location: " . $url_str);
	exit;
}

function GenerateSQLInsert($tbl, $q)
{
	$str = '';

	$r = sql_query($q, 'COM.2687');
	for($i=1; $assoc = sql_fetch_assoc($r); $i++)
	{
		$str .= 'insert into '.$tbl.' values (';
	
		$fld_i = 0;
		foreach($assoc as $val)
		{
			if($fld_i++) $str .= ',';
			$str .= '"'.db_input($val).'"';
		}
	
		$str .= ');'.NEWLINE;
	}
	
	return $str;
}

function DFA($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

function EnsureValueUBound($val, $ubound=9999)
{
	$val = floatval($val);
	
	if($val > $ubound)
		$val = 0; // $ubound;
	
	return $val;
}

function TimeDiff($dt1, $dt2, $timestamp=false, $mode='m')
{
	if(!$timestamp)
	{
		$t1 = strtotime($dt1);
		$t2 = strtotime($dt2);
	}
	else
	{
		$t1 = $dt1;
		$t2 = $dt2;
	}
		
	$secs = $t1 - $t2;

	if($mode == 's')
		$x = $secs;
	else if($mode == 'm')
	{
		$mins = $secs/ 60;
		$x = $mins;
	}
	else if($mode == 'h')
	{
		$mins = $secs/ 60;
		$hrs = $mins/60;
		$x = $hrs;
	}
	else if($mode == 'd')
	{
		$mins = $secs/ 60;
		$hrs = $mins/60;
		$day = $hrs/24;
		$x = $day;
	}
	
	return $x;
}

function format_uptime($seconds) 
{
	$secs = intval($seconds % 60);
	$mins = intval($seconds / 60 % 60);
	$hours = intval($seconds / 3600 % 24);
	$days = intval($seconds / 86400);
	$uptimeString = '';
	
	if ($days > 0) 
	{
		$uptimeString .= $days;
		$uptimeString .= (($days == 1) ? " day" : " days");
	}

	if ($hours > 0) 
	{
		$uptimeString .= (($days > 0) ? ", " : "") . $hours;
		$uptimeString .= (($hours == 1) ? " hour" : " hours");
	}

	if ($mins > 0) 
	{
		$uptimeString .= (($days > 0 || $hours > 0) ? ", " : "") . $mins;
		$uptimeString .= (($mins == 1) ? " minute" : " minutes");
	}
	
	if ($secs > 0) 
	{
		$uptimeString .= (($days > 0 || $hours > 0 || $mins > 0) ? ", " : "") . $secs;
		$uptimeString .= (($secs == 1) ? " second" : " seconds");
	}

	return $uptimeString;
}

function ClearFolder($filedir) 
{ 
	$dir = opendir($filedir);

	while ($file_name = readdir($dir)) 
		if($file_name!="." && $file_name!="..")
			unlink ($filedir . $file_name);
}

function BackupDB($file_name)
{
	DeletePDF(BACKUP_UPLOAD);
	system('mysqldump -u'.DB_USERNAME.' -p'.DB_PASSWORD.' '.DB_NAME.' | gzip > '.BACKUP_UPLOAD.$file_name,$done);
}

function CheckSqlTables(&$msg, $fast = true, $return_text=true) 
{
	global $table_count;
	$is_corrupted = false;
	$msg = "";
	
	$q = "show tables";
	$r = sql_query($q, 'UTL_CD.77');
	$table_count = sql_num_rows($r);
	if ((!$r || $table_count <= 0) && $return_text)
		$msg = '<tr><td colspan="5" class="err">Could not iterate database tables</td></tr>';
	
	$checktype = "";
	if ($fast)
		$checktype = "FAST";

	for($i=1; list($table_name) = sql_fetch_row($r); $i++)
	{
		$q1 = "check table $table_name $checktype";
		$r1 = sql_query($q1, 'UTL_CD.92');

		if ((!$r1 || sql_num_rows($r1) <= 0) && $return_text)
		{
			$msg = '<tr><td colspan="5" class="err">Could not status for table '.$table_name.'</td></tr>';
			continue;
		}

		# Seek to last row
		mysql_data_seek($r1, sql_num_rows($r1)-1);
		$a = sql_fetch_assoc($r1);
		
		$chk_str = '&nbsp;';
		$css = '';
		if($a['Msg_type'] != "status")
		{
			$css = 'red';
			$chk_str = '<input type="checkbox" name="chk[]" id="chk_'.$i.'" value="'.$table_name.'">';
			$is_corrupted = true;
		}
		
		if($return_text)
		{
			$msg .= '<tr>';
			$msg .= '<td align="right" class="'.$css.'">'.$i.'.</td>';
			$msg .= '<td align="center" class="'.$css.'">'.$chk_str.'</td>';
			$msg .= '<td class="'.$css.'"><label for="chk_'.$i.'">'.$table_name.'</label></td>';
			$msg .= '<td align="center" class="'.$css.'">'.$a['Msg_type'].'</td>';
			$msg .= '<td class="'.$css.'">'.$a['Msg_text'].'</td>';
			$msg .= '</tr>';
		}
	}
	
	return $is_corrupted;
}

function ForceOut($err=false)
{
	$str = ($err===false)? '': '?err='.$err;
	//session_destroy(); // destroy all data in session
	header("location:index.php".$str);
	exit;
}

function ForceOut2($err=false)
{
	$str = ($err===false)? '': '?err='.$err;
	session_destroy(); // destroy all data in session
	header("location:lock_screen.php".$str);
	exit;
}

function ForceOut3($err=false)
{
	$str = ($err===false)? '': '?err='.$err;
	session_destroy(); // destroy all data in session
	header("location:authorise.php".$str);
	exit;
}

function ForceOutFront($err=false,$return_url = 'register.php')
{
	if(strpos($return_url,"?")) $str = ''; //($err===false)? '': '&err='.$err;
	else $str = ''; //($err===false)? '': '?err='.$err;
	
	unset($_SESSION[PROJ_FRONT_SESSION_ID]);
	//session_destroy(); // destroy all data in session
	header("location:".$return_url.$str);
	exit;
}

function Passwordify($password)
{
	$passarr = array();	
	$passarr[0] = substr($password,0,8);
	$passarr[1] = substr($password,8,8);
	$passarr[2] = substr($password,16,8);
	$passarr[3] = substr($password,24,8);
	$passarr[4] = substr($password,32,8);
	$passarr[5] = substr($password,40,8);
	$passarr[6] = substr($password,48,8);
	$passarr[7] = substr($password,56,8);
	$passarr[8] = substr($password,64,4);

	$ptrarr = array();
	$ptrarr[0] = substr($passarr[8],0,1);
	$ptrarr[1] = substr($passarr[8],1,1);
	$ptrarr[2] = substr($passarr[8],2,1);
	$ptrarr[3] = substr($passarr[8],3,1);
	
	$k=1;
	$genpass = array();
	foreach($ptrarr as $key=>$value)
	{
		$genpass[$value] = $passarr[$key+$k];
		$k++;
	}
				
	$password = $genpass[1].$genpass[2].$genpass[3].$genpass[4];
	
	return $password;
}

function LogAttempt($user_name, $log_type, $fail_str)
{
	$now = NOW;
	$hostaddress = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$log_str = ($log_type=='S')? 'Login Successful': 'Login Failed';
	
	$q = "insert into log_signin values('$user_name', '$now', '$hostaddress', '".session_id()."', '$log_str', '$fail_str', '$log_type')";
	$r = sql_query($q, 'GNC.216');
}

function ChangeStatus($url, $id, $status, $desc_str, $tbl, $pk_fld)
{
	$result = false;

	$q = 'update '.$tbl.' set cStatus=\''.$status.'\' where '.$pk_fld.'='.$id;
	$r = sql_query($q, 'GEN.1085');

	if(true) // sql_affected_rows())
	{
		$rstr = ($status=='A')? $desc_str." record has been activated": $desc_str." record has been blocked";
		$str = GetStatusImageString($url, $status, $id);	
		$result = "1~$str~$rstr";
	}

	return $result;
}

function UpdateLog($file_name, $str)
{
	$handle = fopen(PRINT_UPLOAD.$file_name, 'a');
	fwrite($handle, $str);
	fclose($handle);	// *	
}

function GetIDString($q)
{
	$arr = array();
	$arr[0] = 0;

	$r = sql_query($q, 'GEN.1494');
	while(list($val)=sql_fetch_row($r))
		$arr[$val] = $val;

	return implode(',',$arr);
}

function GetIDString2($q)
{
	$arr = array();

	$r = sql_query($q, 'GEN.1494');
	while(list($val)=sql_fetch_row($r))
		$arr[$val] = $val;

	return implode(', ',$arr);
}

function SetupCalendar($date_val, $txt_ctrl, $date_type='D', $clr_flag=true, $txt_flag=false)
{
	$btn_ctrl = 'btn'.substr($txt_ctrl, 3);
	$clr_ctrl = 'clr'.substr($txt_ctrl, 3);
	
	if($txt_flag)
	{
		$btn_ctrl = $txt_ctrl;
	}
	
	if($date_type=='DT') // datetime...
	{
		$format = '%d-%m-%Y %H:%M:00';
		$showtime = 'true';
		$css = 'datetime';
	}
	else
	{
		$format = '%d-%m-%Y';
		$showtime = 'false';
		$css = 'date';
	}
	
	$str = '';	
	$str .= '<input type="text" name="'.$txt_ctrl.'" id="'.$txt_ctrl.'" value="'.$date_val.'" class="'.$css.' box" readonly />';
	
	if(!$txt_flag)
		$str .= '<input name="'.$btn_ctrl.'" type="button" id="'.$btn_ctrl.'" value="..." class="date box">';
	
	$str .= '<script type="text/javascript">';
	$str .= 'Calendar.setup({inputField:"'.$txt_ctrl.'",ifFormat:"'.$format.'",showsTime:'.$showtime.',button:"'.$btn_ctrl.'",singleClick:true,step:2});';
	$str .= '</script>';
	
	if($clr_flag && !$txt_flag)
		$str .= '<input type="button" name="'.$clr_ctrl.'" id="'.$clr_ctrl.'" value="!" class="date box" onClick="this.form.'.$txt_ctrl.'.value=\'\';">';

	return $str;
}

function ParseID($id)
{
	return (is_numeric($id) && !empty($id))? $id: '0';
}

function FillRadioData($selected, $ctrl, $q, $comp='Y', $fn_str="")
{
	$str = '';

	$xtra_arr = array();
	if($comp<>'y'&&$comp<>'Y') 
	{
//		if($comp=='0')
			$xtra_arr['0'] = 'NA';
	}

	foreach($xtra_arr as $key=>$txt)
	{
		$ctrl_id = $ctrl.'_'.strtolower($key);
		$chk_str = ($key == $selected)? 'checked': '';
		$str .= '<input type="radio" name="'.$ctrl.'" id="'.$ctrl_id.'" value="'.$key.'" '.$chk_str.' '.$fn_str.'><label class="label0" for="'.$ctrl_id.'">'.$txt.'</label>';
	}
	
	$r = sql_query($q, 'COM.1573');

	while(list($key,$txt)=sql_fetch_row($r))
	{
		$ctrl_id = $ctrl.'_'.strtolower($key);
		$chk_str = ($key == $selected)? 'checked': '';
		$str .= '<input type="radio" name="'.$ctrl.'" id="'.$ctrl_id.'" value="'.$key.'" '.$chk_str.' '.$fn_str.'><label class="label0" for="'.$ctrl_id.'">'.$txt.'</label>';
	}

	return $str;
}

function empty_date($dt)
{
	$dt = trim($dt);
	return (empty($dt) || $dt=='0000-00-00' || $dt=='0000-00-00 00:00:00')? true: false;
}

function SetCode($x_name, $mode='A', $len=3)
{
	$x_code = '';
	$x_name = trim($x_name);
	
	if($mode=='B') // acronym
	{
		$arr = explode(' ',$x_name); //.split(' ');
		for($i=0; ($i < count($arr) && $i < $len); $i++)
			$x_code .= substr($arr[$i], 0, 1);
	}
	else 
	{
		$x_name_len = strlen($x_name);
	
		if($x_name_len > 0)
			$x_code = ($x_name_len > $len)? $x_name.substr(0, $len): $x_name;
	}

	return strtoupper($x_code);
}

function CHK_ARR2Str($chk_arr)
{
	$str = '';
	
	if(count($chk_arr))
	{
		foreach($chk_arr as $x_str=>$x_count)
			$str .= ', '.$x_str;
		
		$str = substr($str, 2);
	}
	
	return $str;
}

function FillRadiosYN($is_selected, $ctrl, $yes_str='Yes', $no_str='No', $width=90, $fn_str='')
{
	$chk_str = ($is_selected)? 'checked': '';

	$str = '<div class="onoffswitch" style="width:'.$width.'px;">';
	$str .= '<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" '.$chk_str.'>';
	$str .= '<label class="onoffswitch-label" for="myonoffswitch">';
	$str .= '<div class="onoffswitch-inner"><div class="onoffswitch-active">'.$yes_str.'</div><div class="onoffswitch-inactive">'.$no_str.'</div></div>';
	$str .= '<div class="onoffswitch-switch" style="right:'.($width-32).'px;"></div>';
	$str .= '</label>';
	$str .= '</div>';

	return $str;
}

function GetPriorityImg($priority)
{
	global $PRIORITY_ARR;
	if(!isset($PRIORITY_ARR[$priority])) $priority = '4';
	return '<img src="./images/icons/priority'.$priority.'.png" align="absmiddle" title="'.$PRIORITY_ARR[$priority].'" />';
}

function FillTime($selected, $ctr, $comp='n', $fn="", $class="", $mode="12") //fill the values from an array
{
	$str = "<select name='$ctr' id='$ctr' class='$class' $fn>"; //  

	if(strtolower($comp)!='y')
		$str .= "<option value='00:00:00' selected>hh:mm</option>\n";
	
	if($mode=="24")
	{
		for($i=0; $i <24; $i++)
		{
			$hh = ($i < 10)? '0'.$i: $i;
			
			for($j=0; $j < 60; $j=$j+30)
			{
				$mm = ($j < 10)? '0'.$j: $j;
				
				$var = $hh . ':' . $mm;
				$select_str = ($selected==$var)? "selected": "";
				$str .= '<option value="'.$var.':00" '.$select_str.'>'.$var.'</option>';
			}
		}
	}
	else
	{
		for($a=5; $a <= 22; $a++)
		{
			$suffix = ($a >= 12)? 'pm': 'am';			
			$i = ($a > 12)? $a - 12: $a;			
			$hh = ($i < 10)? '0'.$i: $i;
			$hhx = ($a < 10)? '0'.$a: $a;
			
			for($j=0; $j < 60; $j=$j+30)
			{
				$mm = ($j < 10)? '0'.$j: $j;
				
				$var = $hh . ':' . $mm;
				$varx = $hhx . ':' . $mm.':00';
				$select_str = ($selected==$varx)? "selected": "";
				// $str .= "<option value='$var' $select_str>$var $suffix</option>";
				$str .= '<option value="'.$varx.'" '.$select_str.'>'.$var.' '.$suffix.'</option>';
			}
		}
	}

	$str .= "</select>";
	return $str;
}

function FillCheckboxList($selected_arr, $ctrl, $value_arr, $mode='1')
{
	$str = '';

	foreach($value_arr as $key=>$txt)
	{
		$key = strval($key);
		$ctrl_id = str_replace('[]', '', $ctrl).'_'.strtolower($key);
		
		if($mode == '2')
			$chk_str = (in_array($key, $selected_arr))? 'checked': ''; // $chk_str = ($key == $selected)? 'checked': '';
		else
			$chk_str = (isset($selected_arr[$key]))? 'checked': '';
			
		$str .= '<input type="checkbox" name="'.$ctrl.'" id="'.$ctrl_id.'" value="'.$key.'" '.$chk_str.'> <label for="'.$ctrl_id.'">'.$txt.'</label>&nbsp;&nbsp;';
	}

	return $str;
}

function NotFoundRow($colspan=1, $msg='')
{
	$colspan_str = ($colspan>1)? ' colspan="'.$colspan.'"': '';
	return '<tr><td '.$colspan_str.'>No Records Found...</td></tr>';
}

function PrintRow($arr, $width, $opt_pad_str=' ', $newline_flag=true)
{
	$str = '';
	foreach($width as $i=>$w)
	{
		$space = $data = '';
		$pad_str = $opt_pad_str;
		$pad_type = STR_PAD_RIGHT;
		
		if(isset($arr[$i]))
		{
			if(is_array($arr[$i]))
			{
				$data = $arr[$i][0];
				
				if(isset($arr[$i][1]) && $arr[$i][1] == 'L') $pad_type = STR_PAD_LEFT;
				else if(isset($arr[$i][1]) && $arr[$i][1] == 'C') $pad_type = STR_PAD_BOTH;
				if(isset($arr[$i][2])) $pad_str = $arr[$i][2];
				if(isset($arr[$i][3])) $space = ' ';
			}
			else
				$data = $arr[$i];
		}
				
		$str .= $space . str_pad($data, $w, $pad_str, $pad_type);
	}
	
	if($newline_flag)
		$str .= NEWLINE;
	
	return $str;
}

function GetAnniversaryDt($x_dt)
{
	return (!empty($x_dt) && $x_dt!='0000-00-00')? date('M d', strtotime($x_dt)): '';	
}

function FillCheckboxGrid($div_id, $selected_arr, $ctrl_name, $data_arr)
{
	$str = '<div id="'.$div_id.'" style="background-color:#ffffff;border:1px solid #000000;position:absolute;height:200px;overflow:scroll;display:none;">';

	foreach($data_arr as $key=>$value)
	{
		$ctrl_id = $ctrl_name.'_'.$key;
		$_checked = (in_array($key, $selected_arr))? 'checked': '';
		$str .= '<span class="search_ctrl" style="width:200px;">';
		$str .= '<input type="checkbox" name="'.$ctrl_name.'[]" id="'.$ctrl_id.'" value="'.$key.'" '.$_checked.'/>';
		$str .= '<label for="'.$ctrl_id.'">'.$value.'</label></span> ';
	}
	$str .= '</div>';
	
	return $str;	
}

function ParseStringForXML($val)
{
	$invalid_char_arr = array('%E2%80%99', '%E2%80%93', '%E2%80%A6');
	
	$val = trim($val);
	$val = strip_tags($val);								// remove html tags
	$val = urlencode($val);									// encode (makes it easier to find & replace chars)
	$val = str_replace($invalid_char_arr, '%27', $val);		// replace invalid chars
	$val = htmlentities(urldecode($val));					// decode back to txt and then handle special chars
	
	return $val;
}

function EncodeParam($param)
{
	$rand = rand();
	$crypt_str = md5($rand);
	
	$len = strlen($param);
	$a = substr($crypt_str, 0, 1);
	$start = hexdec($a);
	
	$a = substr($crypt_str, 0, $start + 1);
	$b = substr($crypt_str, ($start + 1 + $len + 1));	
	$x =  $a . $len . $param . $b;
	
	return $x;	
}

function DecodeParam($crypt_param)
{
	$a = substr($crypt_param, 0, 1);
	$start = hexdec($a);
	$len = substr($crypt_param, $start + 1, 1);
			
	$param = substr($crypt_param, ($start + 1 + 1), $len);
	return $param;
}

function FirstDateOfMonth($date) // as Y-m-d
{
	list($y, $m, $d) = explode('-',$date);
	return $y.'-'.$m.'-01';
}

function MonthDiff($date1, $date2)
{
	list($y1, $m1, $d1) = explode('-', $date1);		
	list($y2, $m2, $d2) = explode('-', $date2);	

	return (($y2 - $y1) * 12) + ($m2 - $m1) + 1;
}

function EnsureReportStartDate($dfrom, $time_flag=false, $dmy_flag=true)
{
	if($dmy_flag) $dfrom = ConvertFromDMYToYMD($dfrom, $time_flag);
	$start_date = ($time_flag)? START_DATE.' 00:00:00': START_DATE;
	if($dfrom < $start_date) $dfrom = $start_date;
	return ($dmy_flag)? ConvertFromYMDToDMY($dfrom, $time_flag): $dfrom;
}

function MultiSort($a, $b)
{
	$args = explode('~',USORT_ORDER);

	$i = 0; 
	$c = count($args); 
	$cmp = 0; 
	while($cmp == 0 && $i < $c) 
	{
		list($key, $is_asc) = explode(':', $args[$i]);

		$cmp = ($is_asc)? strcmp($a[$key], $b[$key]): strcmp($b[$key], $a[$key]); 
		$i++; 
	} 
	
	return $cmp;
}

function GetFirstDayOfWeek($date, $is_ymd=true)
{
	$today_dayno = date("w", strtotime($date)); // wht day is it?
	$format = ($is_ymd)? 'Y-m-d': 'd-m-Y';
	return DateTimeAdd($date, (WEEK_START_DAY - $today_dayno), 0, 0, 0, 0, 0, $format); // get the 1st day of the given wk, adjust for offset
}

function GetQtrFromMonth($m=THIS_MONTH) // StartDateX
{
	$mn = $m - QTR_MONTH_OFFSET;
	$mn = AdjustMonthValues($mn);
	return ceil($mn / 3);
}

function AdjustMonthValues($mn)
{
	if($mn < 0) $mn = 12 + $mn + 1;
	elseif($mn==0) $mn = 12;
	elseif($mn > 12) $mn = $mn % 12;

	return $mn;
}

function SummarizeDataArr($arr)
{
	foreach($arr as $ref=>$A)
		echo $ref.': '.array_sum($A).'<br />';
}

function ListDataArr($arr)
{
	foreach($arr as $ref=>$A)
		foreach($A as $b_id=>$b_val)
			if($b_val != 0)
				echo $ref.': '.$b_id.' = '.$b_val.'<br />';
}

function ListCalcDataArrByBatch($arr)

{
	$a = array();
	
	foreach($arr as $ref=>$A)
		foreach($A as $b_id=>$b_val)
		{
			if(!isset($a[$b_id])) $a[$b_id] = 0;
			
			if($b_val != 0)
				$a[$b_id] += $b_val;
		}
		
	foreach($a as $id=>$val)
		if($val!=0)
			echo $id.': '.$val.'<br />';

}

function IsDate($date, $is_dmy=false)
{
	//echo $date.'<br/>';

	$x = false;
	
	$date = trim($date);
	if(!empty($date) && strpos($date,'-'))
	{
		$d = explode('-', $date);
		
		if(count($d)==3)
			if((!$is_dmy && checkdate($d[1], $d[2], $d[0])) || checkdate($d[1], $d[0], $d[2]))
				$x = true;
	}
	
	return $x;
}

function JustID(&$val, $default=0) // $mode: INTEGER/ REAL
{
	JustNumeric($val, 'INTEGER');
}

function JustNumeric(&$val, $mode='REAL', $default=0) // $mode: INTEGER/ REAL
{
	$val = trim($val);
	$val = ($mode=='INTEGER')? intval($val): floatval($val);
	if(!is_numeric($val)) $val = $default;
}

function FormatDateForIMS($date_val)
{
	if(!empty($date_val))
	{
		$dt = date("Y-m-d", strtotime($date_val));
		$y1 = date("Y", strtotime($date_val));
		$y2 = date("Y");
		$d = DateDiff($dt, TODAY);
		
		if($d)
		{
			$date_format_str = "M j";
			
			if($y1<$y2)
				$date_format_str .= ", Y";
		}	
		else	
			$date_format_str = "H:i";
		
		return date($date_format_str, strtotime($date_val));	
	}
	else
		return '-NA-';
}

function FormatDateForIMS2($date_val)
{
	$dt = date("Y-m-d", strtotime($date_val));
	$y1 = date("Y", strtotime($date_val));
	$y2 = date("Y");
	$d = DateDiff($dt, TODAY);
	
	if($d)
	{
		$date_format_str = "M j";
		
		if($y1<$y2)
			$date_format_str .= ", Y";

		$date_format_str .= " H:i a";
	}	
	else	
		$date_format_str = "M j, H:i a";
	
	return date($date_format_str, strtotime($date_val));	
}

function FormatDateForIMS3($date_val)
{
	if(!empty($date_val))
	{
		$dt = date("Y-m-d", strtotime($date_val));
		$y1 = date("Y", strtotime($date_val));
		$y2 = date("Y");
		$d = DateDiff($dt, TODAY);
		
		if($d)
		{
			$date_format_str = "M j";
			
			if($y1<$y2)
				$date_format_str .= ", Y";
				
			$dSTR = date($date_format_str, strtotime($date_val));
		}	
		else	
		{
			$minutes = round(abs(strtotime(CURRENTTIME) - strtotime(date('H:i:s', strtotime($date_val)))) / 60,2);
			if($minutes>=5 && $minutes<60) $date_format_str = "i";
			elseif($minutes>=60) $date_format_str = "H";
			else $date_format_str = '';

			if($date_format_str=='i') $dSTR = date($date_format_str, strtotime($date_val)).' mins';
			elseif($date_format_str=='H') $dSTR = date($date_format_str, strtotime($date_val)).' hours';
			else $dSTR = 'just now';
			
			//$dSTR .= ' '.date('H:i:s', strtotime($date_val)).' =>'.CURRENTTIME.' =>'.$minutes.' =>'.$date_format_str;
		}
		
		return $dSTR;	
	}
	else
		return '-NA-';
}

function FormatDateForIMS4($date_val)
{
	$dt = date("Y-m-d", strtotime($date_val));
	$y1 = date("Y", strtotime($date_val));
	$y2 = date("Y");
	$d = DateDiff($dt, TODAY);
	
	if($d)
	{
		$date_format_str = "M j, Y";
	}	
	else	
		$date_format_str = "M j, H:i a";
	
	return date($date_format_str, strtotime($date_val));	
}

function MustString($val)
{
	return (trim($val)=='')? 1: 0;
}

function MustID($val)
{
	JustID($val);
	return ($val<1)? 1: 0;
}

function MustNumeric($val, $mode='REAL', $min_value=0, $max_value=0)
{
	JustNumberic($val, $mode);
	return ($val<$min_value || $val>$max_value)? 1: 0;
}

function EnsureDateTimeDuration(&$dtstart, &$dtend, $min_diff=30) // min_diff is expressed in minutes
{
	$start = strtotime($dtstart);
	$end = strtotime($dtend);
	
	$diff = (strtotime($dtend) - strtotime($dtstart))/ 60;

	if($diff < $min_diff)
		$dtend = DateTimeAdd($dtstart, 0, 0, 0, 0, $min_diff, 0);
}

function GetPageHeader($page_orientation='P', $page_prefix=false)
{
	global $is_pdf;
	
	if($is_pdf)
	{
		if($page_prefix) $page_orientation .= '.'.$page_prefix;
		return '[PAGE_START]['.$page_orientation.']';
	}

	return '';// <div align="center">&nbsp;</div>';
}

function CalcSQMetersToSQFeet($val)
{
	return $val * 10.76391;
}

function IsValidFile($file_type, $extension, $type, $size=false, $max_file_size=false)
{
	global $IMG_TYPE, $DOC_TYPE, $IMG_FILE_TYPE, $DOC_FILE_TYPE;

	$str = false;

	if($type=='P')
	{
		if(in_array($extension,$IMG_TYPE))
			$str = true;
	}
	elseif($type=='D')
	{
		if(in_array($extension,$DOC_TYPE))
			$str = true;
	}

	return $str;
}

function GenerateDayDropDown($ctrl,$sDate='',$fn='')
{
	$str = '<select class="from-day inputbox" name="'.$ctrl.'" id="'.$ctrl.'"'.$fn.'>';
	for($i='1';$i<=31;$i++)
	{
		$j = str_pad($i,'2','0',STR_PAD_LEFT);
		$selected = ($sDate==$j)?' selected="true"':'';
		$str .= '<option value="'.$j.'"'.$selected.'> '.$i.' </option>';
	}	
	$str .= '</select>';
	
	return $str;
}

function GenerateMonthDropDown($ctrl,$sDate='',$fn='')
{
	$mLeft = 12 - CURRENT_MONTH;
	$mGenerate = 24 +  $mLeft;
	$str = '<select class="from-month inputbox" name="'.$ctrl.'" id="'.$ctrl.'"'.$fn.'>';
	for($i='0';$i<=$mGenerate;$i++)
	{
		$date = DateTimeAdd(TODAY, 0, $i, 0, 0, 0, 'Y-m-d');
		$value = date("Y", strtotime($date)).'-'.date("m", strtotime($date));
		$name = date("F", strtotime($date)).'&nbsp;'.date("Y", strtotime($date));

		$selected = ($sDate==$value)?' selected="true"':'';

		$str .= '<option value="'.$value.'"'.$selected.'> '.$name.' </option>';
	}	
	$str .= '</select>';
	
	return $str;
}

function FillMultiCombo($selected, $ctr, $type, $comp, $values, $fn="", $class="box", $combo_type="KEY_VALUE") //fill the values from an array
{
	$display = ($type<>"COMBO")? "size=10": "";

	$str = "<select name='".$ctr."[]' id='$ctr' multiple='multiple' class='$class' $display $fn>"; //  

	if(($comp<>"y" )&&( $comp<>"Y") )
	{
		if($comp=='0')
			$str .= "<option value='0' selected> - select - </option>\n";
		elseif($comp=='1')
			$str .= "<option value='0' selected> - main category - </option>\n";
		elseif($comp=='2')
			$str .= "<option value='0' selected>MM</option>\n";
		elseif($comp=='-1')
			$str .= "<option value=''>- Select TID -</option>\n";
		else
			$str .= "";
	}
	
	if($combo_type == "KEY_VALUE")
	{
		foreach($values as $key_val=>$var)
		{
			$select_str = (isset($selected[$key_val]) && $selected[$key_val]==$key_val)? "selected": "";
			$str .= "<option value='$key_val' $select_str> $var</option>";
		}
	}
	elseif($combo_type == "KEY_IS_VALUE")
	{
		foreach($values as $var)
		{
			$select_str = (isset($selected[$var]) && $selected[$var]==$var)? "selected": "";
			$str .= "<option value='$var' $select_str> $var</option>";
		}
	}
	elseif($combo_type == "SPLIT_FOR_KEY_VALUE")
	{
		foreach($values as $var)
		{
			$v = explode("~", $var);
			$key = $v[0];
			$txt = $v[1];
			
			$select_str = (isset($selected[$key]) && $selected[$key]==$key)? "selected": "";
			$str .= "<option value='$key' $select_str> $txt</option>";
		}
	}

	$str .= "</select>";
	return $str;
}

function SuggestCode()
{
	$arr = array();
	
	$len = rand(10, 12);	
	
	// atleast 1 uppercase char
	$a_len = rand(1, $len-3);
	// echo 'a_len: '.$a_len.'<br>';
	
	for($i=0; $i<$a_len; $i++)
		$arr[$i] = chr(rand(65, 90));

	$ctr = $i;

	// atleast 1 lowercase char
	$b_len = rand(1, $len-2-$a_len);
	// echo 'b_len: '.$b_len.'<br>';

	for(;$i<($ctr+$b_len); $i++)
		$arr[$i] = chr(rand(97, 122));

	$ctr = $i;

	// atleast 1 number
	$c_len = rand(1, $len-1-$a_len-$b_len);
	// echo 'c_len: '.$c_len.'<br>';
	
	for(;$i<($ctr+$c_len); $i++)
		$arr[$i] = rand(0, 9);
	
	// DFA($arr);
	shuffle($arr);
	// DFA($arr);
	
	$str = '';	
	foreach($arr as $a)
		$str .= $a;
	
	return $str;
}

function chop_words($str, $words = 20, $limit = 0, $suffix = ' ...')
{
    //string  $str --The input string
    //$words  The number of words to return, default 20, 0 to skip
    //$limit  Maximum length of the returned string 
     //string  $suffix  The string to append to the input if shortened.

    if($limit) $limit -= strlen($suffix);
       
    for ($i = 0, $ix = 0; $i < $words; $i++)
        if (($is = strpos($str, ' ', $ix)) !== false)
        {
            if ($limit && $is + 1 > $limit)
                break;

            $ix = $is + 1;        
        }
        else
            return $str;

    return substr($str, 0, $ix) . $suffix;
}

function FillRadios2($selected, $ctrl, $value_arr, $fn_str='')
{
	$str = '';

	foreach($value_arr as $key=>$txt)
	{
		$ctrl_id = $ctrl.'_'.strtolower($key);
		$chk_str = ($key === $selected)? 'checked': '';
		
		$str .= '<div class="md-radio">';
		$str .= '<input type="radio" name="'.$ctrl.'" id="'.$ctrl_id.'" value="'.$key.'" class="md-radiobtn" '.$chk_str.' '.$fn_str.' /><label for="'.$ctrl_id.'"> <span></span> <span class="check"></span> <span class="box"></span>'.$txt.'</label>';
		$str .= '</div>';
	}

	return $str;
}

function GetAccessCountry()
{
	$str = '';
	
	$ip = $_SERVER['REMOTE_ADDR']; // the IP address to query
	$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
	if($query && $query['status'] == 'success')
	{
		$str = $query['countryCode'];
		if(isset($query['country']))
			$str .= '~'.$query['country'];
		if(isset($query['city']))
			$str .= '~'.$query['city'];
		if(isset($query['regionName']))
			$str .= '~'.$query['regionName'];
	}
	
	return $str;
}

function getBrowser()
{
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$bname = 'Unknown';
	$platform = 'Unknown';
	$version= "";

	//First get the platform?
	if (preg_match('/linux/i', $u_agent)) {
		$platform = 'linux';
	}
	elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		$platform = 'mac';
	}
	elseif (preg_match('/windows|win32/i', $u_agent)) {
		$platform = 'windows';
	}

	// Next get the name of the useragent yes separately and for good reason.
	if (preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
	{
		$bname = 'Internet Explorer';
		$ub = "MSIE";
	}
	elseif (preg_match('/Firefox/i',$u_agent))
	{
		$bname = 'Mozilla Firefox';
		$ub = "Firefox";
	}
	elseif (preg_match('/Chrome/i',$u_agent))
	{
		$bname = 'Google Chrome';
		$ub = "Chrome";
	}
	elseif (preg_match('/Safari/i',$u_agent))
	{
		$bname = 'Apple Safari';
		$ub = "Safari";
	}
	elseif (preg_match('/Opera/i',$u_agent))
	{
		$bname = 'Opera';
		$ub = "Opera";
	}
	elseif (preg_match('/Netscape/i',$u_agent))
	{
		$bname = 'Netscape';
		$ub = "Netscape";
	}
	else
		$ub = '';

	// Finally get the correct version number.
	$known = array('Version', $ub, 'other');
	$pattern = '#(?<browser>' . join('|', $known) .
	')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $u_agent, $matches)) {
		// we have no matching number just continue
	}

	// See how many we have.
	$i = count($matches['browser']);
	if ($i != 1) {
		//we will have two since we are not using 'other' argument yet
		//see if version is before or after the name
		if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
			$version= $matches['version'][0];
		}
		else {
			$version= $matches['version'][1];
		}
	}
	else {
		$version= $matches['version'][0];
	}

	// Check if we have a number.
	if ($version==null || $version=="") {$version="?";}

	return array(
		'userAgent' => $u_agent,
		'name'      => $bname,
		'version'   => $version,
		'platform'  => $platform,
		'pattern'    => $pattern
	);
}

function GetUniqueIDs($arr)
{
	$x = array();
	
	if(count($arr))
		foreach($arr as $a)
			if(is_array($a))
				$x = $x + $a;
	
	$x[0] = 0;
	
	return array_unique($x);
}

function GetTaxBreakUpForProduct($prod_amount,$tax_perc='12',$tax_region='L')
{
	$str = '';
	
	$basePrice = (100/(100 + $tax_perc)) * $prod_amount;
	$taxAMT = ($basePrice * $tax_perc)/100;
	
	$sgst = $cgst = $igst = '0';
	if($tax_region=='L')
	{
		$halfTAXPERC = ($tax_perc/2);
		$halfTAXAMT = ($taxAMT/2);
		
		$sgst = $cgst = $halfTAXAMT;
	}
	else
		$igst = $taxAMT;
	
	$str = $basePrice.'~'.$sgst.'~'.$cgst.'~'.$igst;
		
	return $str;
}

function GetTaxForProduct($prod_amount,$tax_perc='12',$tax_region='L')
{
	$str = '';
	
	$taxAMT = ($prod_amount * $tax_perc)/100;
	
	$sgst = $cgst = $igst = '0';
	if($tax_region=='L')
	{
		$halfTAXPERC = ($tax_perc/2);
		$halfTAXAMT = ($taxAMT/2);
		
		$sgst = $cgst = $halfTAXAMT;
	}
	else
		$igst = $taxAMT;
	
	$str = $prod_amount.'~'.$sgst.'~'.$cgst.'~'.$igst;
		
	return $str;
}

function GetCESSTaxCalculation($prod_amount,$tax_perc,$type='I')
{
	if($type=='I')
	{
		$basePrice = (100/(100 + $tax_perc)) * $prod_amount;
		$taxAMT = ($basePrice * $tax_perc)/100;
	}
	else
	{
		$basePrice = $prod_amount;
		$taxAMT = ($prod_amount * $tax_perc)/100;
	}
		
	$str = $basePrice.'~'.$taxAMT;
			
	return $str;
}

function GetLatLong($address)
{
    $address = str_replace(" ", "+", $address);

    //$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$long;
}

function LogAdminUpdates($user_id,$mode,$table,$id)
{
	global $sess_user_level;
	$now = NOW;

	$q = "insert into log_adminsignin values ('$user_id', '$sess_user_level', '$now', '$mode', '$table', '$id')";
	$r = sql_query($q, 'LAU.216');
}

function TrimData($arr)
{
	foreach($arr as $d_key=>$d_val)
		$arr[$d_key] = trim($d_val);

	return $arr;
}

function LockTable($tbl,$mode='WRITE')
{
	$q = 'LOCK TABLE '.$tbl.' '.$mode;
	$r = sql_query($q);
}

function UnlockTable()
{
	$q = 'UNLOCK TABLES';
	$r = sql_query($q);
}

function FillRadios($selected, $ctrl, $value_arr, $fn_str='')
{
	$str = '';

	$str .= '<div class="kt-radio-inline">';
	foreach($value_arr as $key=>$txt)
	{
		$ctrl_id = $ctrl.'_'.strtolower($key);
		$chk_str = ($key === $selected)? 'checked': '';

		$str .= '<label class="kt-radio kt-radio--solid" for="'.$ctrl_id.'"><input type="radio" name="'.$ctrl.'" id="'.$ctrl_id.'" value="'.$key.'" '.$chk_str.' '.$fn_str.' /> '.$txt.'<span></span></label> ';
	}
	
	$str .= '</div>';

	return $str;
}

function FormatAmount($number)
{
	$str = '';
	
	$a = array('1'=>'10000000','2'=>'100000','3'=>'1000');
	$b = array('1'=>'Cr','2'=>'L','3'=>'K');
	
	$j = 0;
	foreach($a as $key=>$value)
	{
		if($number>=$value)
		{
			$str = $number/$value;
			$str .= $b[$key];
			
			$j++;
			break;
		}
	}
	
	if($j==0)
		$str = $number;

	return $str;		
}

function Get6MonthArr()
{
	$result = array();

	$Month_From = date("m", strtotime("-6 month"));
	$Year_From = date("Y", strtotime("-6 month"));
	$Month_To = date("m");
	$Year_To = date("Y");
	
	$tMonth = $Month_From;
	$tYear = $Year_From;
	
	while($tYear <= $Year_To)
	{
		while(($tMonth <= 12 && $tYear < $Year_To ) || ( $tMonth <= $Month_To && $tYear == $Year_To ) ) 
		{
			$result[] = FormatDate($tYear.'-'.str_pad($tMonth,2,0,STR_PAD_LEFT).'-01','18');
			/*$result[] = array(
				"month" => $tMonth,
				"year" => $tYear,
			);*/

			$tMonth++;
		}
	
		$tMonth = 1;
		$tYear++;
	}
	
	return $result;
}
function GetLinkedURLS($id)
{
	$URLS = array();
	$_uq = "select vUrl from menu_dat where cStatus='A' and iMenuID=".$id;
	$_ur = sql_query($_uq,'');
	if(sql_num_rows($_ur))
	{
		while(list($URL) = sql_fetch_row($_ur))
			array_push($URLS,$URL);
	}
	
	return $URLS;
}

function GetActiveLink($currentFILE,$ARR)
{
	$str = '';
	
	if(!empty($ARR) && count($ARR))
	{
		if($ARR['HREF']==$currentFILE || in_array($currentFILE,$ARR['URLS']))
			$str = ' class="mm-active" id="scrollSideMenu"';
		else
		{
			if($ARR['IS_SUB']=='Y' && !empty($ARR['MENU']) && count($ARR['MENU']))
			{
				foreach($ARR['MENU'] as $sKEY2=>$sVALUE2)
				{
					if($sVALUE2['HREF']==$currentFILE || in_array($currentFILE,$sVALUE2['URLS']))
						$str = ' class="mm-active" id="scrollSideMenu"';
				}	
			}
		}
	}
	
	return $str;
}

function MultiDimensionalArraySort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
 
function SendWebPushrPushNotifications($title,$message,$target_url,$PIC,$sender_id)
{
	$end_point = 'https://api.webpushr.com/v1/notification/send/sid';
	$http_header = array( 
		"Content-Type: Application/Json", 
		"webpushrKey: c7f99b30703b86d0c9dd79685e2e69ea", 
		"webpushrAuthToken: 21423"
	);
	
	/*$req_data = array(
		'title' 			=> "Notification title", //required
		'message' 		=> "Notification message", //required
		'target_url'	=> 'https://www.webpushr.com', //required
		'sid'		=> '36252' //required
	);*/

	$req_data = array(
		'title' 			=> $title, //required
		'message' 		=> $message, //required
		'target_url'	=> $target_url, //required
		'sid'		=> $sender_id, //required
		'icon'		=> 'https://pwa.thatlifestylecoach.com/assets/img/icon/192x192.png', //required
		'image'			=> $PIC,
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
	curl_setopt($ch, CURLOPT_URL, $end_point );
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data) );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	//echo $response;
}

function SendWebPushrPushNotificationsToAll($title,$message,$target_url,$PIC)
{
	$end_point = 'https://api.webpushr.com/v1/notification/send/all';
	$http_header = array( 
		"Content-Type: Application/Json", 
		"webpushrKey: c7f99b30703b86d0c9dd79685e2e69ea", 
		"webpushrAuthToken: 21423"
	);
	$req_data = array(
		'title' 		=> $title, //required
		'message' 		=> $message, //required
		'target_url'	=> $target_url, //required
		//'name'			=> 'Test campain',
		'icon'			=> 'https://pwa.thatlifestylecoach.com/assets/img/icon/192x192.png',
		'image'			=> $PIC,
		'auto_hide'		=> 1,
		//'expire_push'	=> '5m',
		//'send_at'		=> '2019-10-10 19:31 +5:30',
		/*'action_buttons'=> array(	
			array('title'=> 'Demo', 'url' => 'https://www.webpushr.com/demo'),
			array('title'=> 'Rates', 'url' => 'https://www.webpushr.com/pricing')
		)*/
	);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
	curl_setopt($ch, CURLOPT_URL, $end_point );
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data) );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	//echo $response;
}

function SendMail($from='',$from_name='',$to='',$cc='',$bcc='',$reply_to='',$subject='',$content='',$template='N',$link='')
{
  	$from_name = 'Goa Institute of Management';
	$mail_body = '';
	if($template=='Y') $mail_body = file_get_contents(SITE_ADDRESS.'mail_body.php');
	if(!empty($mail_body)) $mail_body = str_replace('<LINK>',$LINK,$mail_body);
	else
		$mail_body = $content;
  
	$SUBJECT = $subject;
	/*require("../mail/sendgrid-php.php");
	$email = new \SendGrid\Mail\Mail();
	$email->setFrom($from, $from_name);
	$email->setSubject($SUBJECT);
	$email->addTo($to);
	//$email->addCc('cmd@e-vents.in');
	//$email->addCc('ceo@e-vents.in');
	$email->addBcc('contactus@teaminertia.com');
	$email->addBcc('admission@gim.ac.in');
	$email->addContent("text/html", $mail_body);
	
	//$sendgrid = new \SendGrid('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');
  	$sendgrid = new \SendGrid('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');
	try {
		$response = $sendgrid->send($email);
		//DFA($response->statusCode());
		//DFA($response->headers());
		//DFA($response->body());
      	//echo '<br />heyyy<br />';
	} catch (Exception $e) {
      	//echo '<br />hii<br />';
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
	}*/
}

function SendMailFront($from='',$from_name='',$to='',$cc='',$bcc='',$reply_to='',$subject='',$content='',$template='N',$link='')
{
  	$from_name = 'Goa Institute of Management';
	$mail_body = '';
	if($template=='Y') $mail_body = file_get_contents(SITE_ADDRESS.'mail_body.php');
	if(!empty($mail_body)) $mail_body = str_replace('<LINK>',$LINK,$mail_body);
	else
		$mail_body = $content;
  
	$SUBJECT = $subject;
	/*require("mail/sendgrid-php.php");
	$email = new \SendGrid\Mail\Mail();
	$email->setFrom($from, $from_name);
	$email->setSubject($SUBJECT);
	$email->addTo($to);
	//$email->addCc('cmd@e-vents.in');
	//$email->addCc('ceo@e-vents.in');
	$email->addBcc('contactus@teaminertia.com');
  	$email->addBcc('admission@gim.ac.in');
	//$email->addBcc('admissions@gim.ac.in');
	$email->addContent("text/html", $mail_body);
	
	//$sendgrid = new \SendGrid('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');
  	$sendgrid = new \SendGrid('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');
	try {
		$response = $sendgrid->send($email);
		//DFA($response->statusCode());
		//DFA($response->headers());
		//DFA($response->body());
      	//echo '<br />heyyy<br />';
	} catch (Exception $e) {
      	//echo '<br />hii<br />';
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
	}*/
}

function SendMailFront2($from='',$from_name='',$to='',$cc='',$bcc='',$reply_to='',$subject='',$content='',$template='N',$link='')
{
  	$from_name = 'Goa Institute of Management';
	$mail_body = '';
	if($template=='Y') $mail_body = file_get_contents(SITE_ADDRESS.'mail_body.php');
	if(!empty($mail_body)) $mail_body = str_replace('<LINK>',$LINK,$mail_body);
	else
		$mail_body = $content;
  
	$SUBJECT = $subject;
	/*require("../mail/sendgrid-php.php");
	$email = new \SendGrid\Mail\Mail();
	$email->setFrom($from, $from_name);
	$email->setSubject($SUBJECT);
	$email->addTo($to);
	//$email->addCc('cmd@e-vents.in');
	//$email->addCc('ceo@e-vents.in');
	$email->addBcc('contactus@teaminertia.com');
  	$email->addBcc('admission@gim.ac.in');
	//$email->addBcc('admissions@gim.ac.in');
	$email->addContent("text/html", $mail_body);
	
	//$sendgrid = new \SendGrid('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');
  	$sendgrid = new \SendGrid('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');
	try {
		$response = $sendgrid->send($email);
		//DFA($response->statusCode());
		//DFA($response->headers());
		//DFA($response->body());
      	//echo '<br />heyyy<br />';
	} catch (Exception $e) {
      	//echo '<br />hii<br />';
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
	}*/
}

function SendSMS($referer, $contact, $sms_content, $url='http://164.52.195.161/API/SendMsg.aspx')
{
	$contact = (strlen($contact)=='10')?'91'.$contact:$contact;
	
	$username = '20210130';
	$password = '69s9YPDE';
	$sender_id = 'GIMGOA';
	
	$url2 ='http://164.52.195.161/API/SendMsg.aspx?uname='.$username.'&pass='.$password.'&send='.$sender_id.'&dest='.$contact.'&msg='.urlencode($sms_content);
	
	$status = file_get_contents($url2);

}

function SendShudhSMS($contact, $sms_content, $content_id, $page_url='')
{
	$data = array(
	    "username"=>"gim",
	    "password"=>"123456",
	    "sender"=>"GIMGOA",
	    "mobile"=>$contact,
	    "message"=>$sms_content,
	    "route"=>"T",
	    "entity_id"=>"1201159159424556882",
	    "content_id"=>$content_id   
	);

	list($header, $content) = PostRequest("http://shudhsms.in/sendsms.php", $page_url, $data);

	return $content;
}

function PostRequest($url, $referer, $_data) 
{
    // convert variables array to string:
    $data = array(); while(list($n,$v) =
    each($_data)) {
        $data[] = "$n=$v";
    }

    $data = implode('&', $data);
    
    $url = parse_url($url);
    if ($url['scheme'] != 'http') {
        die('Only HTTP request are supported !');
    }
    // extract host and path:
    $host = $url['host'];
    $path = $url['path'];

    // open a socket connection on port 80
    $fp = fsockopen($host, 80);
    
    // send the request headers:
    fputs($fp, "POST $path HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp, "Referer: $referer\r\n");
    fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
    fputs($fp, "Content-length: ". strlen($data) ."\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $data);
    
    $result = '';
    
    while(!feof($fp)) {
        // receive the results of the request
        $result .= fgets($fp, 128);
    }
    
    // close the socket connection:
    fclose($fp);
    
    // split the result header from the content
    $result = explode("\r\n\r\n", $result, 2);
    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';
    
    // return as array:
    return array($header, $content);
}

function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function SendMailReply($from='',$from_name='',$to='',$cc='',$bcc='',$reply_to='', $subject='',$content='', $subject_user= "", $reply_str='', $template='N',$image='', $file="")
{
	require_once("class.phpmailer.php");

	$mail_body = '';
	if($template=='Y') $mail_body = url_get_contents(SITE_ADDRESS.'mail_body.php');
	
	if(!empty($mail_body))
	{
		$mail_body = str_replace('<IMAGE>',$image,$mail_body);
		$mail_body = str_replace('<CONTENT>',$content,$mail_body);
	}
	else
		$mail_body = $content;

	$Mail = new PHPMailer();
	$Mail->From = $from;
	$Mail->FromName = $from_name;
	$Mail->AddAddress($to);
	if(!empty($cc)) $Mail->AddCC($cc);
	if(!empty($bcc)) $Mail->AddBCC($bcc);
	if(!empty($reply_to)) $Mail->AddReplyTo($reply_to);
		
	$Mail->WordWrap = 50; // set word wrap
	$Mail->IsHTML(true);
	$Mail->MsgHTML($mail_body);
	$Mail->Subject = $subject;
	// $Mail->Send();

	/*if(isset($FILES['myfiles'])) 
	{
		$Mail->AddAttachment($FILES['myfiles']['tmp_name'],$FILES['myfiles']['name']);
	}		*/

	if(!empty($reply_str))
	{
		$reply_content = "";
		if($template=='Y')
		{
			$reply_content = url_get_contents(SITE_ADDRESS.'mail_body.php');
			$reply_content = str_replace('<IMAGE>',$image,$reply_content);
			$reply_content = str_replace('<CONTENT>',$reply_str,$reply_content);
		}
		else
			$reply_content = $reply_str;

		$AutoMail = new PHPMailer();
		$AutoMail->From = $from;
		$AutoMail->FromName = $from_name;
		$AutoMail->AddAddress($reply_to);
		$AutoMail->AddReplyTo($to);
		$AutoMail->WordWrap = 50; 
		$AutoMail->IsHTML(true);
		$AutoMail->Subject = $subject_user;
		$AutoMail->MsgHTML($reply_content);
		$AutoMail->Send();
	}
			
	if($Mail->Send()) {
		return 'OK';
	}
	else {
		return 'Mail Sending Failed';
	}
}

function GenerateRandomCode($len,$fld,$tbl)
{
	$str = '';
	
	$arr = array();
	for($i=0; $i<$len; $i++)
		$arr[$i] = rand(0, 9);

	shuffle($arr);
	$str = '';	
	foreach($arr as $a)
		$str .= $a;
		
	if(!empty($fld) && !empty($tbl))
	{
		$eXIST = GetXFromYID('select count(*) from '.$tbl.' where '.$fld.'="'.$str.'"');
		if(!empty($eXIST) && $eXIST!='-1')
			$str = GenerateRandomCode($len,$fld,$tbl);
	}
	
	return $str;
}

function GetNextAvailableTime($id,$fld,$disp_fld)
{
	$str = '';
	
	$q = 'select tFrom, tTo, iTimeInMinutes from adm_panel where iPanelID='.$id;
	$r = sql_query($q,'');
	if(sql_num_rows($r))
	{
		list($tFROM,$tTO,$tTimeInMinutes) = sql_fetch_row($r);
		
		$TIME_ARR = array();
		$TIME = $tFROM;
		$x = 0;
		do {
			$TIME = DateTimeAdd($TIME, 0, 0, 0, 0, $x, 0, "H:i:s");
			if($TIME==$tTO) continue;
			$TIME_ARR[$TIME] = $TIME;
			
			$x = (!empty($tTimeInMinutes))?$tTimeInMinutes:15;
		} while ($TIME < $tTO);
		
		$TIME_ARR2 = array();
		$_q = 'select '.$disp_fld.' from adm_appointment where cStatus="A" and '.$fld.'='.$id;
		$_r = sql_query($_q,'');
		if(sql_num_rows($_r))
		{
			while(list($time) = sql_fetch_row($_r))
			{
				$TIME_ARR2[$time] = $time;
			}
		}
		
		foreach($TIME_ARR as $tKEY=>$tVALUE)
		{
			if(!empty($TIME_ARR2) && count($TIME_ARR2))
			{
				if(!isset($TIME_ARR2[$tKEY]))
				{
					$str = $tKEY;
					break;
				}
			}
			else
			{
				$str = $tKEY;
				break;
			}
		}
	}

	return $str;
}

function GetNextAvailableTime2($id,$acyr,$round)
{
	$str = '';
	
	$ids = explode('~',$id);
	$CAPACITY_ARR = GetXArrFromYID('select iPanelID, iCapacity from adm_panel where iPanelID IN ('.implode(',',$ids).')','3');
	$FILLED_ARR = GetXArrFromYID('select iPanelID, count(*) from adm_appointment where cStatus="A" and iPanelID IN ('.implode(',',$ids).') and iAYrID='.$acyr.' and iRoundID='.$round.' group by iPanelID','3');

	$PANEL_ARR = array();
	if(!empty($CAPACITY_ARR) && count($CAPACITY_ARR))
	{
		foreach($CAPACITY_ARR as $pKEY=>$pVALUE)
		{
			$CAPACITY = $pVALUE;
			$FILLED = 0;
			if(isset($FILLED_ARR[$pKEY]))
				$FILLED = $FILLED_ARR[$pKEY];
				
			$REMAINING = $CAPACITY - $FILLED;
			$PANEL_ARR[$pKEY] = $REMAINING;
		}
	}
	
	arsort($PANEL_ARR);
	
	$PANEL_ID = 0;
	$TIME = ''; 
	foreach($PANEL_ARR as $pKEY=>$pVALUE)
	{
		$q = 'select iPanelID, tFrom, tTo from adm_panel where iPanelID='.$pKEY;
		$r = sql_query($q,'');
		if(sql_num_rows($r))
		{
			list($iPanelID,$tFROM,$tTO) = sql_fetch_row($r);
			
			$PANEL_ID = $iPanelID;
			$TIME = DateTimeAdd($tFROM, 0, 0, 0, 0, 0, 0, "H:i:s");
			break;
		}
	}
	
	$str = $PANEL_ID.'~~**~~'.$TIME;

	return $str;
}


function GetNextAvailableTime3($id,$acyr,$round)
{
	$str = '';
	
	$ids = explode('~',$id);
	$CAPACITY_ARR = GetXArrFromYID('select iPanelID, iCapacity from adm_panel where iPanelID IN ('.implode(',',$ids).')','3');
	$FILLED_ARR = GetXArrFromYID('select iPanelID, count(*) from adm_appointment where cStatus="A" and iPanelID IN ('.implode(',',$ids).') and iAYrID='.$acyr.' and iRoundID='.$round.' group by iPanelID','3');

	$PANEL_ARR = array();
	if(!empty($CAPACITY_ARR) && count($CAPACITY_ARR))
	{
		foreach($CAPACITY_ARR as $pKEY=>$pVALUE)
		{
			$CAPACITY = $pVALUE;
			$FILLED = 0;
			if(isset($FILLED_ARR[$pKEY]))
				$FILLED = $FILLED_ARR[$pKEY];
				
			$REMAINING = $CAPACITY - $FILLED;
			$PANEL_ARR[$pKEY] = $REMAINING;
		}
	}
  
	arsort($PANEL_ARR);
	
	$PANEL_ID = 0;
	$TIME = '';
	$P = '0'; 
	foreach($PANEL_ARR as $pKEY=>$pVALUE)
	{
		if(!empty($P))
			break;
	
		$q = 'select iPanelID, tFrom, tTo, iTimeInMinutes from adm_panel where iPanelID='.$pKEY;
		$r = sql_query($q,'');
		if(sql_num_rows($r))
		{
			list($iPanelID,$tFROM,$tTO,$tTimeInMinutes) = sql_fetch_row($r);
			
			$PANEL_ID = $iPanelID;
			$TIME_ARR = array();
			$TIME = $tFROM;
			$x = 0;
			do {
				$TIME = DateTimeAdd($TIME, 0, 0, 0, 0, $x, 0, "H:i:s");
				if($TIME==$tTO) continue;
				$TIME_ARR[$TIME] = $TIME;
				
				$x = (!empty($tTimeInMinutes))?$tTimeInMinutes:15;
			} while ($TIME < $tTO);

			$TIME_ARR2 = array();
			$_q = 'select tTime from adm_appointment where cStatus="A" and iPanelID='.$iPanelID.' and iAYrID='.$acyr.' and iRoundID='.$round;
			$_r = sql_query($_q,'');
			if(sql_num_rows($_r))
			{
				while(list($time) = sql_fetch_row($_r))
				{
					$TIME_ARR2[$time] = $time;
				}
			}
			
			foreach($TIME_ARR as $tKEY=>$tVALUE)
			{
				if(!empty($TIME_ARR2) && count($TIME_ARR2))
				{
					if(!isset($TIME_ARR2[$tKEY]))
					{
						$TIME = $tKEY;
						break;
					}
				}
				else
				{
					$TIME = $tKEY;
					break;
				}
			}

			$P++;
		}
	}
  
	$str = $PANEL_ID.'~~**~~'.$TIME;

	return $str;
}

function SendScheduleMail($candidate_id, $type, $templateType='S')
{
	$INTERVIEW_ARR = GetXArrFromYID('select iInterviewTypeID, vTitle from adm_interviewtype where cType="'.$type.'" and cStatus="A" order by iRank','3');
	$txtacademic_yr = GetXFromYID('select iAYrID from adm_candidate where iCandidateID='.$candidate_id);
	$txtround = GetXFromYID('select iRoundID from adm_candidate where iCandidateID='.$candidate_id);
	$_aq = 'select * from adm_appointment where cType="'.$type.'" and cStatus="A" and iCandidateID='.$candidate_id.' and iAYrID='.$txtacademic_yr.' and iRoundID='.$txtround.' order by FIELD(iInterviewTypeID,'.implode(',',array_keys($INTERVIEW_ARR)).')';
	$_ar = sql_query($_aq,'');
	$_ar2 = sql_query($_aq,'');
	if(!sql_num_rows($_ar))
	{
		header('location:'.SITE_ADDRESS.'home.php');
		exit;
	}
		
	$pSTR = '';
	while($a = sql_fetch_assoc($_ar))
	{
		if(!empty($a['iPanelID'])) $pSTR .= $a['iPanelID'].',';
	}
	
	if(!empty($pSTR)) $pSTR = substr($pSTR,0,'-1');
	else $pSTR = 0;
	
	$PANEL_ARR = array();
	$_pq = 'select iPanelID, dDate, tFrom, tTo, vLink from adm_panel where cStatus="A" and iPanelID IN ('.$pSTR.')';
	$_pr = sql_query($_pq,'');
	if(sql_num_rows($_pr))
	{
		while(list($panel_id,$panel_date,$panel_timefrom,$panel_timeto,$panel_link) = sql_fetch_row($_pr))
			$PANEL_ARR[$panel_id] = array('DATE'=>$panel_date, 'FROM'=>$panel_timefrom, 'TO'=>$panel_timeto, 'LINK'=>$panel_link);
	}
	
	$str = '';
	while($a = sql_fetch_assoc($_ar2))
	{
		if(!empty($a['iInterviewTypeID']))
		{
			$str .= $INTERVIEW_ARR[$a['iInterviewTypeID']].' Slot: '.FormatDate($PANEL_ARR[$a['iPanelID']]['DATE'],'26').', '.FormatDate($PANEL_ARR[$a['iPanelID']]['FROM'],'25').' to '.FormatDate($PANEL_ARR[$a['iPanelID']]['TO'],'25').' | Tentative Time: '.FormatDate($a['tTime'],'4');
          	if(!empty($PANEL_ARR[$a['iPanelID']]['LINK']))
              	$str .= ' | Link: '.$PANEL_ARR[$a['iPanelID']]['LINK'];
          	$str .= '<br /><br />';
		}
	}
	
	if(!empty($str))
	{
		$str = substr($str,0,'-12');
		
		$TEMPLATE_ARR = array();
		$_sq = 'select iTemplateID, iAYrID, iRoundID, vSubject, vContent from adm_template where cStatus="A" and cType="'.$type.'" and cType2="'.$templateType.'" order by iAYrID, iRoundID';
		$_sr = sql_query($_sq,'');
		if(sql_num_rows($_sr))
		{
			while(list($iTemplateID, $iAYrID, $iRoundID, $vSubject, $vContent) = sql_fetch_row($_sr))
			{
				$TEMPLATE_ARR[$iAYrID.'~'.$iRoundID] = array('MAILER_SUBJECT'=>htmlspecialchars_decode($vSubject), 'MAILER_CONTENT'=>htmlspecialchars_decode($vContent));
			}
		}
		
		$CANDIATE_COURSES = array();
		$_ccq = 'select cc.iCandidateID, cc.iCourseID, cc.iPreference, c.vName from adm_candidate_course as cc join adm_course as c on cc.iCourseID=c.iCourseID where cc.cStatus="A" and c.cStatus="A" and iCandidateID='.$candidate_id.' order by cc.iPreference';
		$_ccr = sql_query($_ccq,'');
		if(sql_num_rows($_ccr))
		{
			while(list($CC_CANDIDATEID,$CC_COURSEID,$CC_PREFERENCE,$CC_NAME) = sql_fetch_row($_ccr))
			{
				$COURSE_APPLIED = htmlspecialchars_decode($CC_PREFERENCE.'. '.$CC_NAME);
			
				if(!isset($CANDIATE_COURSES[$CC_CANDIDATEID])) $CANDIATE_COURSES[$CC_CANDIDATEID] = array();
				array_push($CANDIATE_COURSES[$CC_CANDIDATEID],$COURSE_APPLIED);
			}
		}

		$template = 'Y';
		$q = 'select iCandidateID, iAYrID, iRoundID, iGIMID, vName, vPhone, vEmail, vWebPushrID from adm_candidate where cStatus="A" and iCandidateID='.$candidate_id;
		$r = sql_query($q,'');
		if(sql_num_rows($r))
		{
			while(list($c_id,$c_acyr,$c_round,$c_gimid,$c_name,$c_phone,$c_email,$c_webpushr) = sql_fetch_row($r))
			{
				if(!isset($cSTR_ARR[$c_id]))
				{
					$SMS_CONTENT = '';
				
					$MAIL_SUBJECT = htmlspecialchars_decode($TEMPLATE_ARR[$c_acyr.'~'.$c_round]['MAILER_SUBJECT']);
					$MAIL_CONTENT = htmlspecialchars_decode($TEMPLATE_ARR[$c_acyr.'~'.$c_round]['MAILER_CONTENT']);
		
					$MAIL_CONTENT = str_replace('<CANDIDATE_NAME>',$c_name,$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;CANDIDATE_NAME&gt;',$c_name,$MAIL_CONTENT);
					
					$MAIL_CONTENT = str_replace('<CANDIDATE_GIMID>',$c_gimid,$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;CANDIDATE_GIMID&gt;',$c_gimid,$MAIL_CONTENT);

					$MAIL_CONTENT = str_replace('<TIME_SLOT_BOOKED>',$str,$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;TIME_SLOT_BOOKED&gt;',$str,$MAIL_CONTENT);
		
					$MAIL_CONTENT = str_replace('<CURRENT_DATE>',FormatDate(TODAY,'B'),$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;CURRENT_DATE&gt;',FormatDate(TODAY,'B'),$MAIL_CONTENT);
					
					$COURSES_INTERVIEWED_FOR = '';
					if(isset($CANDIATE_COURSES[$c_id]) && !empty($CANDIATE_COURSES[$c_id]) && count($CANDIATE_COURSES[$c_id]))
						$COURSES_INTERVIEWED_FOR = implode(', ',$CANDIATE_COURSES[$c_id]);
					
					$MAIL_CONTENT = str_replace('<INTERVIEW_FOR>',$COURSES_INTERVIEWED_FOR,$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;INTERVIEW_FOR&gt;',$COURSES_INTERVIEWED_FOR,$MAIL_CONTENT);
					
					$LINK = '';

					$MAIL_BODY = '';
					if($template=='Y')
					{
						$MAIL_BODY = file_get_contents(SITE_ADDRESS.'mail_body.php');
						$MAIL_BODY = str_replace('<CONTENT>',$MAIL_CONTENT,$MAIL_BODY);
						$MAIL_BODY = str_replace('<LINK>',$LINK,$MAIL_BODY);
						$MAIL_BODY = str_replace('<EMAIL>',$c_email,$MAIL_BODY);
					}
					else
						$MAIL_BODY = $MAIL_CONTENT;

					if(!empty($c_email))
					{
						$str = SendMailFront(OFFICIAL_EMAILID,OFFICIAL_SITE,$c_email,'','',OFFICIAL_EMAILID,$MAIL_SUBJECT,$MAIL_BODY,'N',$LINK);
					}
				}
			}
		}
	}
}

function SendScheduleMail2($candidate_id, $type, $templateType='S')
{
	$INTERVIEW_ARR = GetXArrFromYID('select iInterviewTypeID, vTitle from adm_interviewtype where cType="'.$type.'" and cStatus="A" order by iRank','3');
	$txtacademic_yr = GetXFromYID('select iAYrID from adm_candidate where iCandidateID='.$candidate_id);
	$txtround = GetXFromYID('select iRoundID from adm_candidate where iCandidateID='.$candidate_id);
	$_aq = 'select * from adm_appointment where cType="'.$type.'" and cStatus="A" and iCandidateID='.$candidate_id.' and iAYrID='.$txtacademic_yr.' and iRoundID='.$txtround.' order by FIELD(iInterviewTypeID,'.implode(',',array_keys($INTERVIEW_ARR)).')';
	$_ar = sql_query($_aq,'');
	$_ar2 = sql_query($_aq,'');
	if(!sql_num_rows($_ar))
	{
		header('location:'.SITE_ADDRESS.'home.php');
		exit;
	}
		
	$pSTR = '';
	while($a = sql_fetch_assoc($_ar))
	{
		if(!empty($a['iPanelID'])) $pSTR .= $a['iPanelID'].',';
	}
	
	if(!empty($pSTR)) $pSTR = substr($pSTR,0,'-1');
	else $pSTR = 0;
	
	$PANEL_ARR = array();
	$_pq = 'select iPanelID, dDate, tFrom, tTo, vLink from adm_panel where cStatus="A" and iPanelID IN ('.$pSTR.')';
	$_pr = sql_query($_pq,'');
	if(sql_num_rows($_pr))
	{
		while(list($panel_id,$panel_date,$panel_timefrom,$panel_timeto,$panel_link) = sql_fetch_row($_pr))
			$PANEL_ARR[$panel_id] = array('DATE'=>$panel_date, 'FROM'=>$panel_timefrom, 'TO'=>$panel_timeto, 'LINK'=>$panel_link);
	}
	
	$str = '';
	while($a = sql_fetch_assoc($_ar2))
	{
		if(!empty($a['iInterviewTypeID']))
		{
			$str .= $INTERVIEW_ARR[$a['iInterviewTypeID']].' Slot: '.FormatDate($PANEL_ARR[$a['iPanelID']]['DATE'],'26').', '.FormatDate($PANEL_ARR[$a['iPanelID']]['FROM'],'25').' to '.FormatDate($PANEL_ARR[$a['iPanelID']]['TO'],'25').' | Tentative Time: '.FormatDate($a['tTime'],'4');
          	if(!empty($PANEL_ARR[$a['iPanelID']]['LINK']))
              	$str .= ' | Link: '.$PANEL_ARR[$a['iPanelID']]['LINK'];
          	$str .= '<br /><br />';
		}
	}
	
	if(!empty($str))
	{
		$str = substr($str,0,'-12');
		
		$TEMPLATE_ARR = array();
		$_sq = 'select iTemplateID, iAYrID, iRoundID, vSubject, vContent from adm_template where cStatus="A" and cType="'.$type.'" and cType2="'.$templateType.'" order by iAYrID, iRoundID';
		$_sr = sql_query($_sq,'');
		if(sql_num_rows($_sr))
		{
			while(list($iTemplateID, $iAYrID, $iRoundID, $vSubject, $vContent) = sql_fetch_row($_sr))
			{
				$TEMPLATE_ARR[$iAYrID.'~'.$iRoundID] = array('MAILER_SUBJECT'=>htmlspecialchars_decode($vSubject), 'MAILER_CONTENT'=>htmlspecialchars_decode($vContent));
			}
		}
		
		$CANDIATE_COURSES = array();
		$_ccq = 'select cc.iCandidateID, cc.iCourseID, cc.iPreference, c.vName from adm_candidate_course as cc join adm_course as c on cc.iCourseID=c.iCourseID where cc.cStatus="A" and c.cStatus="A" and iCandidateID='.$candidate_id.' order by cc.iPreference';
		$_ccr = sql_query($_ccq,'');
		if(sql_num_rows($_ccr))
		{
			while(list($CC_CANDIDATEID,$CC_COURSEID,$CC_PREFERENCE,$CC_NAME) = sql_fetch_row($_ccr))
			{
				$COURSE_APPLIED = htmlspecialchars_decode($CC_PREFERENCE.'. '.$CC_NAME);
			
				if(!isset($CANDIATE_COURSES[$CC_CANDIDATEID])) $CANDIATE_COURSES[$CC_CANDIDATEID] = array();
				array_push($CANDIATE_COURSES[$CC_CANDIDATEID],$COURSE_APPLIED);
			}
		}

		$template = 'Y';
		$q = 'select iCandidateID, iAYrID, iRoundID, iGIMID, vName, vPhone, vEmail, vWebPushrID from adm_candidate where cStatus="A" and iCandidateID='.$candidate_id;
		$r = sql_query($q,'');
		if(sql_num_rows($r))
		{
			while(list($c_id,$c_acyr,$c_round,$c_gimid,$c_name,$c_phone,$c_email,$c_webpushr) = sql_fetch_row($r))
			{
				if(!isset($cSTR_ARR[$c_id]))
				{
					$SMS_CONTENT = '';
				
					$MAIL_SUBJECT = htmlspecialchars_decode($TEMPLATE_ARR[$c_acyr.'~'.$c_round]['MAILER_SUBJECT']);
					$MAIL_CONTENT = htmlspecialchars_decode($TEMPLATE_ARR[$c_acyr.'~'.$c_round]['MAILER_CONTENT']);
		
					$MAIL_CONTENT = str_replace('<CANDIDATE_NAME>',$c_name,$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;CANDIDATE_NAME&gt;',$c_name,$MAIL_CONTENT);
					
					$MAIL_CONTENT = str_replace('<CANDIDATE_GIMID>',$c_gimid,$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;CANDIDATE_GIMID&gt;',$c_gimid,$MAIL_CONTENT);

					$MAIL_CONTENT = str_replace('<TIME_SLOT_BOOKED>',$str,$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;TIME_SLOT_BOOKED&gt;',$str,$MAIL_CONTENT);
		
					$MAIL_CONTENT = str_replace('<CURRENT_DATE>',FormatDate(TODAY,'B'),$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;CURRENT_DATE&gt;',FormatDate(TODAY,'B'),$MAIL_CONTENT);
					
					$COURSES_INTERVIEWED_FOR = '';
					if(isset($CANDIATE_COURSES[$c_id]) && !empty($CANDIATE_COURSES[$c_id]) && count($CANDIATE_COURSES[$c_id]))
						$COURSES_INTERVIEWED_FOR = implode(', ',$CANDIATE_COURSES[$c_id]);
					
					$MAIL_CONTENT = str_replace('<INTERVIEW_FOR>',$COURSES_INTERVIEWED_FOR,$MAIL_CONTENT);
					$MAIL_CONTENT = str_replace('&lt;INTERVIEW_FOR&gt;',$COURSES_INTERVIEWED_FOR,$MAIL_CONTENT);
					
					$LINK = '';

					$MAIL_BODY = '';
					if($template=='Y')
					{
						$MAIL_BODY = file_get_contents(SITE_ADDRESS.'mail_body.php');
						$MAIL_BODY = str_replace('<CONTENT>',$MAIL_CONTENT,$MAIL_BODY);
						$MAIL_BODY = str_replace('<LINK>',$LINK,$MAIL_BODY);
						$MAIL_BODY = str_replace('<EMAIL>',$c_email,$MAIL_BODY);
					}
					else
						$MAIL_BODY = $MAIL_CONTENT;

					if(!empty($c_email))
					{
						$str = SendMailFront2(OFFICIAL_EMAILID,OFFICIAL_SITE,$c_email,'','',OFFICIAL_EMAILID,$MAIL_SUBJECT,$MAIL_BODY,'N',$LINK);
					}
				}
			}
		}
	}
}

function FillCombo2022($name, $selected, $dataArr, $sel_name, $class="form-control", $change="" , $readonly=''){
	$str = '';
	$str .= '<select name="'.$name.'" id="'.$name.'" class="'.$class.'" onchange="'.$change.'" '.$readonly.'>';
	$str .= '<option value="0">-Select '.$sel_name.'-</option>';
	foreach($dataArr as $id => $name){
		$sel = '';
		if($id == $selected){
			$sel = 'selected';
		} 
		$str .= '<option value="'.$id.'" '.$sel.' >'.$name.'</option>';
	}
	$str .= '</select>';

	return $str;
}
?>