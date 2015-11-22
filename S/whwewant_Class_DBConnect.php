<?php
Class ConnObject
{
	public $con=array();
	function getConnObject()
	{
		$this->con=array();
		//$con = mysqli_connect("localhost","root","passw0rd","ourstore") or die("Could not connect: ". mysqli_error($con));
		$con = mysqli_connect("localhost","admin","password","ourstore") or die("Could not connect: ". mysqli_error($con));
		
		return $this->con=$con;
	}
}
?>
