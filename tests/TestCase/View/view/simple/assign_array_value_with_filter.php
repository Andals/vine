<?php
foreach ($userList as $user) {
	echo "{$user['name']}";
	if (isset($user['pet_list']) && !empty($user['pet_list'])) {
		echo $user['pet_list'][0]['name'];
	}
}
?>