<?PHP

function getAdminInfo($adminID) {
	global $_SESSION;
	$adminArr = unserialize($adminArr);
		
	if($adminArr['adminID']) {
		return $adminArr;
	} else {
		$result = dbQuery('SELECT * FROM admins WHERE adminID = ' . dbClean($adminID) . ' LIMIT 1');
		$adminArr = mysql_fetch_assoc($result);
		
		if(!$adminArr) {
			lethalError('Invalid admin ID');
		}
		
		$_SESSION['adminArr'] = serialize($adminArr);
		return $adminArr;
	}
}
?>