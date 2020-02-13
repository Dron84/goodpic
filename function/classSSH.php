<?php
/**
*
*/
class SSH
{
	$string = file_get_contents(ROOT."/admin/config.json");
	$json_a = json_decode($string, true);
	function __construct()
	{
		$connection = ssh2_connect($json_a['ssh_server'], $json_a['ssh_server_port']);
		ssh2_auth_password($connection, $json_a['ssh_user'], $json_a['ssh_pass']);
	}
	public function SendFile ($LocalFile, $RemoteFile, $premission = 0744){
		ssh2_scp_send($connection, $LocalFile, $RemoteFile, $premission);
		echo "file send";
	}
}



?>
