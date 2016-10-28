# message.receive.php
绿米设备数据推送服务php代码示例
--------

1.直接把文件解压在服务器访问目录下  
2.在getDeviceInfo.php按照提示修改相应app_secret,appkey和米聊号设备号  
3.pushData.php为返回推送请求的文件  
4.设置Web Sever的请求地址（URL）为http://ip:port/pushData.php 即可接受推送  
5.接到推送消息后具体处理逻辑在getDeviceInfo.php里的miSensorData方法里，其中$decText为返回解密后的内容。可用来处理相应业务。  
6.getData.php里面包含添加米聊号和获取设备ID，具体代码实现自行修改  


