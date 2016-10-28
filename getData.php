<?php 
	include './getDeviceInfo.php';
    //此文件为非直接运行的demo,需要根据自己的项目进行整合

	$mi = new miBase();
	//添加米聊号
	$message = $mi->addMinum();
	//获取设备名称
	$deviceInfo = $mi->getMiSensorName();
    /**
      处理数据的逻辑
    **/
	echo "添加小米米聊号返回数据：<br/>";
	print_r($message);
	echo "<br/>查询小米传感器的名称:<br/>";
	print_r($deviceInfo);
	


?>