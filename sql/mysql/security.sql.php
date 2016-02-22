<?php


// used for authenticate login process
$sql['select_user_where_user_password']="
	SELECT a.user_id,a.sgid,b.name as real_name,b.coid,
	c.name as coname,c.short_name as short_coname,a.pid
	FROM sys_users a
	INNER JOIN person b ON a.pid=b.id
	INNER JOIN company c ON b.coid=c.id
	WHERE a.user_id='%s'
	AND a.user_passwd='%s';
";
 
?>
