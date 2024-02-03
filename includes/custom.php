<?php

function GetDataFromID($table, $pk_field, $pk_id, $cond="")
{
    $q = "select * from ".$table." where ".$pk_field." = '".$pk_id."' ".$cond;
    $r = sql_query($q,"CUSTOM.05");

    if(sql_num_rows($r))
    {
        while($row = sql_fetch_object($r))
        {
            $arr[] = $row;
        }

        return $arr;
    }
}

function GetDataFromCOND($table, $cond="")
{
    $q = "select * from ".$table." where 1 ".$cond;
    $r = sql_query($q,"CUSTOM.21");

    if(sql_num_rows($r))
    {
        while($row = sql_fetch_object($r))
        {
            $arr[] = $row;
        }

        return $arr;
    }
}

function InsertData($table,$values)
{
	$str ='';

	if(!empty($values))
	{
		$q = "insert into $table values(".$values.")";
		$r = sql_query($q, "CUSTOM.37");
	}

	//$str = $q.'<br />'; 
    $str = $r; 

	return $str;
}

function UpdataData($table,$values,$cond)
{
	$str ='';

	if(!empty($values))
	{
		$q = "update $table set $values where $cond";
		$r = sql_query($q, "CUSTOM.56");
	}

	$str = $q; 

	return $str;
}

function UpdateData($table,$values,$cond)
{
    $str ='';

    if(!empty($values))
    {
        $q = "update $table set $values where $cond";
        $r = sql_query($q, "CUSTOM.56");
    }

    $str = $q; 

    return $str;
}

function DeleteData($table, $field, $pk, $cond="")
{
    $str ='';

    $q = "delete from $table where $field=$pk and 1 $cond";
    $r = sql_query($q, "CUSTOM.56");

    $str = $q;

    return $str;
}

function UpdateField($table, $field, $field_val, $cond)
{
    $q = "update $table set $field='".$field_val."' where 1 and $cond";
    $r = sql_query($q,'CUSTOM.351');
    $count = sql_affected_rows($r);

    return $count;
}

function HelpIcon($mesg)
{
    $str = '<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="'.$mesg.'"></i>';

    return $str;
}

function GetCountFromTable($table, $cond="")
{
    $count = GetXFromYID ("select count(*) from ".$table." where 1 ".$cond);

    return $count;
}

function GetXArrFromYID2($table, $values, $cond='', $mode="1")
{
    $q  = "select $values from $table where 1 $cond";
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
function GetCounts($table, $cond)
{    
    $q = GetXFromYID("select count(*) from $table where 1 $cond");

    return $q;
}


function GetStatusPills($status="", $status_arr="")
{
    $pill_str = $bd_col = "";
    $text = isset($status_arr[$status])?$status_arr[$status]:'';

    if(!empty($text))
    {
        if($status=='U') $bd_col = 'badge-primary';
        else if($status=='D') $bd_col = 'badge-danger';
        else if($status=='A') $bd_col =  'badge-success';
        
        $pill_str = '<div class="mb-2 mr-2 badge '.$bd_col.'">'.$text.'</div>';
    }

    return $pill_str;
}

######################## CTRL related functions ##########################

/**
 * Rental Categories Dropdown Combo
 */
function rental_cat_combo($selected, $name, $class="form-control", $fn="")
{
	$RENTAL_CATEGORIES_ARR = array();
	$RENTAL_MAIN_CAT_ARR = GetXArrFromYID('select iCatID, vName from rental_categories where iParentID=0 order by iRank','3');
	$rental_cat_data = GetDataFromCOND("rental_categories", " and iParentID != 0 ORDER BY iAncestorID ASC, iRank ASC");
	$rental_cat_grp = array();
	foreach ($rental_cat_data as $cat)
	{
		if(!isset($rental_cat_grp[$cat->iParentID]))
		{
			$id = $cat->iParentID;
			$rental_cat_grp[$id] = $RENTAL_MAIN_CAT_ARR[$id];
			$val = $rental_cat_grp[$id];
			$RENTAL_CATEGORIES_ARR[] = "<option value='$id' disabled class='bg-secondary text-white'>$val</option>";
		}

		$id = $cat->iCatID;
		$val = $cat->vName;
		$sel = ($selected==$cat->iCatID?"selected":"");
		$RENTAL_CATEGORIES_ARR[] = "<option value='$id' $sel >&nbsp;&nbsp;&nbsp;&nbsp;$val</option>";
	}

	$sel = (empty($selected)?"selected":"");
	$OPTIONS = "<option value='' $sel > - Select Rental Categories - </option>\n".implode("\n", $RENTAL_CATEGORIES_ARR);
	return "<select name='$name' id='$name' class='$class' $fn >$OPTIONS</select>";
}

/**
 * Get Location Locality
 */
function GetLocLocality($level, $parentid, $arr, $cond="")
{
	$space = "";
	$level++;
	$q = "select iLocationID, vName, iParentID, cStatus, cPinCode from location where iParentID=$parentid $cond order by iRank";
	$r = sql_query($q, 'locations_disp.67');
	
	if(sql_num_rows($r))
	{
		for($i=1; $i < $level; $i++) $space .= "&nbsp;&nbsp;&nbsp;";

		for($i=1; list($id,$nm,$pid,$stat,$pincode)=sql_fetch_row($r); $i++)
		{
			$sr = (isset($arr[$pid]["SR"]))? $arr[$pid]["SR"]."$i.": "$i.";
			$arr[$id] = array("I"=>$i, "LEVEL"=>$level, "SPACE"=>$space, "ID"=>$id, "NAME"=>$nm, "PARENTID"=>$pid, "STATUS"=>$stat, "PINCODE"=>$pincode, "SR"=>$sr);
			$arr = GetLocLocality($level, $id, $arr, $cond);
		}
	}
	return $arr;
}



/**
 * Get Location Locality
 */
function GetLocLocalityArr($cond="")
{
	$data = GetLocLocality("0", "0", array(), $cond);

	$arr = array();
	if(!empty($data))
	{
		foreach ($data as $row)
		{
			$arr[$row["ID"]] = $row["SPACE"].$row["NAME"];
		}
	}

	return $arr;
}


function GetTotalDistance($from, $to, $source)
{
    $distance1 = GetXFromYID("select fDistanceInKM from location_distance where cStatus='A' and iLocID_From='$to' and iLocID_To='$source' ");
   
    $distance1 = $distance1 * 2;

    $distance2 = GetXFromYID("select fDistanceInKM from location_distance where cStatus='A' and iLocID_From='$from' and iLocID_To='$source' ");

    $distance2 = $distance2 * 2;

    $total1 = $distance1 + $distance2;

    

    $distance3=GetXFromYID("select fDistanceInKM from location_distance where cStatus='A' and iLocID_From='$to' and iLocID_To='$source' ");
    $distance4=GetXFromYID("select fDistanceInKM from location_distance where cStatus='A' and iLocID_From='$from' and iLocID_To='$to' ");
    $distance5=GetXFromYID("select fDistanceInKM from location_distance where cStatus='A' and iLocID_From='$from' and iLocID_To='$source' ");
    

    $total2=$distance3+$distance4+$distance5;


    $final_distance=($total1<$total2)?$total1:$total2;

    return $final_distance;
}

function GetFinalPrice($total_distance, $vehicle_id, $time = "")
{
    $VEHICLE_TARIFF_ARR = GetDataFromID('tariff', 'iVehicleID', $vehicle_id, " and cStatus='A' ");
    $base_distance_KM = $VEHICLE_TARIFF_ARR[0]->fBaseDistanceInKM;
    $base_distance_rate = $VEHICLE_TARIFF_ARR[0]->fBaseFare;
    $Night_charges=0;
    $base_additional_KM = '';
    $time = (empty($time)) ? '10:30 AM' : $time;
    $time_format = date('H', strtotime($time));
    $base_additional_KM = $VEHICLE_TARIFF_ARR[0]->fAdditionalPerKM;
    $a = $total_distance - $base_distance_KM;
    
    $b = $a * $base_additional_KM; //price
    $c = $base_distance_rate; //price
    
    $fprice = $b + $c;
    if ($time_format<18 && $time_format>8) {
    }else{
        $fprice+=$VEHICLE_TARIFF_ARR[0]->fNightCharges;
    }
    
    return $fprice;
}

?>