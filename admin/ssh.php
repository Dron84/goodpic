<?php
/**
* 
*/
class SSH
{
	
	function __construct()
	{
		$connection = ssh2_connect('dronmedia.tk', 22);
		ssh2_auth_password($connection, 'KaterinaG', 'And3rd242258');
	}
	public function SendFile ($LocalFile, $RemoteFile, $premission = 0744){
		ssh2_scp_send($connection, $LocalFile, $RemoteFile, $premission);
		echo "file send";
	}
}



?>