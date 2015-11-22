<?php
// Basic Class definition for Building Process menu

class ProcessMenu
{
    Public $MenuOptions=array();
    Public $ProcessGroups=array();

    Public function buildMenu($User_Id, $Restaurant_Id, $User_Type, $User_SubType,$ShowInTheList=false, $UserDept_Code='', $UserDept_Role='')
    {
        $this->MenuOptions=array();
        $this->Process_Group=array();
		
		$ShowInTheList_str = '';
        
        if($ShowInTheList == 'Y')
        {	$ShowInTheList_str = " AND A.ShowInTheList='Y' ";	}
 
       
        $menu_qrystmt=mysqli_query("SELECT A.* FROM processmenu_v A WHERE  User_Type='{$User_Type}' AND User_SubType IN ('', '{$User_SubType}') AND User_Deptcode IN ('', '{$UserDept_Code}') AND User_DeptRole IN ('', '{$UserDept_Role}') ".$ShowInTheList_str." ORDER BY A.ProcessGroup_DisplaySeq, A.Display_Seq");
		
        while ($row=mysqli_fetch_array($menu_qrystmt))
        {
            $this->Process_Group[$row["ProcessGroup_Id"]]=$row["ProcessGroup_Name"];
			
            $this->MenuOptions[$row["ProcessGroup_Id"]][$row["Process_Id"]]=array("Process_Name"  => $row["Process_Name"], 
															"Page_URL"      => $row["Page_URL"], "Page_Id"=> $row["Page_Id"]);
        }
    }
    	    
}
?>