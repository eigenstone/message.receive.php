<?php 
	include './getDeviceInfo.php';
    //返回数据

	$mi = new miBase();
	$datas = $mi->miSensorData();

	echo $datas;

	


?>