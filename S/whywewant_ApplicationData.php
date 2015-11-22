<?php

$Yes='Y';
$No='N';

// User and Org control variables
$Customer_Id=0;
$User_Id=0;
$Page_Id=0;

$WfFlag='';
$Wf_Id=0;
$WfTx_Id=0;
$WfStep_Id=0;
$WfTx_Key='';
$WfTx_Status='';
$WfError='';

$DB_Error=0;


// General Status Flags
$Active='A';
$Inactive='I';

$Pending='P';
$Probation='R';
$Confirmed='C';

$Started='S';
$Approved='A';
$Rejected='R';
$SendBack='B';
$Canceled='C';

// Org Status
$Setup='S';

// Transaction variables
$Action='';
$Modify='M';
$Add='A';
$Delete='D';
$View='V';
$Review='R';
$Button_Lable='';
$First_Seq=1;


// List Page variables
$FirstPage=1;
$TotalRows=0;
$DefaultRowsPerPage=10;
$RowsPerPage=0;
$TotalPages=0;
$CurrentPage=0;
$NextPage=0; 
$ListPage=array();
$FirstRow=0;
$RowsInTheLastPage=0;
$RowsPerPage=0;


// arrays in the page

$Errors=array();
$FormVars=array();
$Page=array();
$PageErrors=array();

$error='';
$errno=0;
$Tx_Seq=0;


// Misc.
$Currency='INR';

?>