<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function get_details($cStatus) {
    $que1 = 'select dDoc, vTitle, cApprove, vPic from seating_plan where seating_plan.cStatus="'.$cStatus.'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    if(sql_num_rows($que1_result)) {
        foreach($que1_result as $que1_result_single) {
            RETURN $que1_result_single;
        }
    }
    RETURN FALSE;
}

function get_selectPlanMasterDetails($seatingPlanId) {
    $queryPlan = 'select * from seating_plan_date where iSeatingPlanDateID="'.$seatingPlanId.'"';
    $queryPlan_result = sql_query($queryPlan, 'AUTH.61');
    if(sql_num_rows($queryPlan_result)) {
        foreach($queryPlan_result as $queryPlan_result_single) {
            RETURN $queryPlan_result_single;
        }
    }
    RETURN FALSE;
}

function get_selectPlanDetails($where) {
    $que1 = 'select * from seating_plan where ' . $where;
    $que1_result = sql_query($que1, 'AUTH.61');
    if(sql_num_rows($que1_result)) {
        RETURN $que1_result;
    }
}

function plan_list($iAssemblyID,$cStatus,$seatingPlanId) {
    $que3 = 'select
        seating.iSeatID,
        trim(seating.vSeatNO) as vSeatNO,

        seating.iSeatID,
        seating.vStyle,

        seating_plan.iMemID,

        member.iMemID,
        concat_ws(" ",member.vPre,member.vFname,member.vMname,member.vLname) as `name`,
        party.iPID,
        party.vName as partyname,
        party.vShortName as partysname,
        party.vColor

        from seating
        left outer join seating_plan on seating_plan.iSeatID=seating.iSeatID and seating_plan.iSeatingPlanDateID="'. $seatingPlanId .'" and seating_plan.cStatus="'.$cStatus.'"

        left outer join member on member.iMemID=seating_plan.iMemID and member.cStatus="A"
        left outer join member_assoc on member_assoc.iMemID=member.iMemID and member_assoc.cStatus="A" and member_assoc.iAssemblyID="'.$iAssemblyID.'"
        left outer join party on party.iPID=member_assoc.iPID and party.cStatus="A"

        where seating.cStatus="A"
        order by CAST(seating.vSeatNO AS SIGNED)';
    $que3_result = sql_query($que3, 'AUTH.61');
    if(sql_num_rows($que3_result) > 0) {
        //foreach($que3_result as $que3_result_single) {
            RETURN $que3_result;
        //}
    }
    RETURN FALSE;
}

function addDetails($vTitle,$dDoc,$vPic,$seatid,$mlaid,$seatingPlanMasterId) {
    if( $seatid>0 && $mlaid>0 ) {
        $iSeatingID = nextidseating('iSeatingID','seating_plan');
        $que1 = 'insert into seating_plan
            (iSeatingID,
            iMemID,
            iSeatID,
            vTitle,
            dDoc,
            vPic,
            cApprove,
            cStatus,
            iSeatingPlanDateID)
            values(
            "'.$iSeatingID.'",
            "'.$mlaid.'",
            "'.$seatid.'",
            "'.$vTitle.'",
            "'.$dDoc.'",
            "'.$vPic.'",
            "N",
            "A",
            "'.$seatingPlanMasterId.'")
        ';
        $que1_result = sql_query($que1, 'AUTH.61');
    }
}

function addSeatingPlanMaster($vTitle, $dDoc, $vPic, $sess_user_id) {
    $que1 = 'insert into seating_plan_date
            (dtCreated,
            vTitle,
            dDate,
            dtUpdated,
            cStatus,
            vPic,
            iCreated_UserID,
            iUpdated_UserID)
            values(
            "'.$dDoc.'",
            "'.$vTitle.'",
            "'.$dDoc.'",
            "'.$dDoc.'",
            "N",
            "'.$vPic.'",
            "'.$sess_user_id.'",
            "'.$sess_user_id.'")
        ';
        $que1_result = sql_query($que1, 'AUTH.61');
}

function nextidseating($fieldname,$tablename){
    $que1 = 'select max('.$fieldname.') as maxid from '.$tablename;
    $que1_result = sql_query($que1, 'AUTH.61');
    if(sql_num_rows($que1_result)) {
        foreach($que1_result as $que1_result_single) {
            RETURN $que1_result_single['maxid']+1;
        }
    }
    RETURN 1;
}

function delete($cStatus) {
    $que1 = 'delete from seating_plan where cStatus="'.$cStatus.'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_affected_rows();
}

function change_status($cStatus,$where_cStatus) {
    $que1 = 'update seating_plan set cStatus="'.$cStatus.'" where cStatus="'.$where_cStatus.'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_affected_rows();
}

function party_list(){
    $que1='select
        party.iPID,
        party.vName,
        party.vShortName,
        party.vColor
        from party
        where party.cStatus="A"
        order by party.iRank';
    $que1_result = sql_query($que1, 'AUTH.61');
    if( sql_num_rows($que1_result) ) {
        RETURN $que1_result;
    }
    RETURN FALSE;
}

function approve() {
    $que1 = 'update seating_plan set cStatus="A", cApprove="A"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_affected_rows();
}

function approve_seating_plan($seatingPlanMasterId) {
    $que1 = 'update seating_plan set cStatus="A", cApprove="A" where iSeatingPlanDateID="'. $seatingPlanMasterId .'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_affected_rows();
}

function approve_seating_plan_date($seatingPlanMasterId) {
    $que1 = 'update seating_plan_date set cStatus="A" where iSeatingPlanDateID="'. $seatingPlanMasterId .'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_affected_rows();
}

function delete_seating_plan($seatingPlanMasterId) {
    $que1 = 'delete from seating_plan where iSeatingPlanDateID="'. $seatingPlanMasterId .'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_affected_rows();
}
function delete_seating_plan_date($seatingPlanMasterId) {
    $que1 = 'delete from seating_plan_date where iSeatingPlanDateID="'. $seatingPlanMasterId .'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_affected_rows();
}

function update_seating_plan_date_title($seatingPlanMasterId, $vTitle, $vPic, $dDoc, $sess_user_id) {
    $que1 = 'update seating_plan_date set vTitle="'. $vTitle .'", vPic="'. $vPic .'", dtUpdated="'. $dDoc .'", iUpdated_UserID="'. $sess_user_id .'" where iSeatingPlanDateID="'. $seatingPlanMasterId .'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_affected_rows();
}

function check_seating_image_name_exists($oldvPic) {
    $que1 = 'select vPic from seating_plan where vPic="'.$oldvPic.'"';
    $que1_result = sql_query($que1, 'AUTH.61');
    RETURN sql_num_rows($que1_result);
}