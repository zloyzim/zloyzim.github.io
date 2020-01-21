<?php

    
	
	$start = microtime(true);
	echo "<meta charset=\"utf-8\">";
	$robber = new rob;

	####### настройка скрипта ######
	
	$grups = array ('-64701405', '-51361027', '-43335937', '-29258893'); #Группы откуда будем пиздить записи
	$randomm = rand (0, count($grups)-1); //mt_rand
	$grup = $grups[$randomm]; #Рандом групп
	$robber->SetVar("token", "53681360c803bd87710a019a1d74472a54e239bd98dc850e864056262b89a3e7a6f0826a3e59e7e695e3c"); #токен можно получить тут http://vk.cc/5r10Wb 
	//$robber->SetVar("token", "ab51c50784b108d1a5e2c3a4d1990f9f3e26fe5dae3b08dfb558919d2050d44e7e69ab0cf215b32a57ff0"); #токен можно получить тут http://vk.cc/5r10Wb 
	
	$robber->SetVar("id_group_rob", "$grup"); #не трогать
	$robber->SetVar("id_group", "-25155166"); #ваша группа/обязательно перед id группы должен стоять минус 
	//$robber->SetVar("id_group", "-25403612"); #ваша группа/обязательно перед id группы должен стоять минус  
	$robber->SetVar("max_post", "100"); #Из скольки последних записей парсить ( тут нечего не трогать )
	
	####### конец настройки #####


	$robber->init();
	
	class rob
	{
		function init()
		{
			//https://api.vk.com/method/wall.post?owner_id=-57228988&from_group=1&message=eqwewqe&attachments=eqweqwe&v=5.52&access_token=6637b9859c545703e581db9054fddacbb453043d34bfe81a1e55f247ef4dde8c54286f879a9195726e44d
			//https://api.vk.com/method/wall.get?owner_id=-51078440&count=100&v=5.52&access_token=6637b9859c545703e581db9054fddacbb453043d34bfe81a1e55f247ef4dde8c54286f879a9195726e44d
			$query = $this->curl("https://api.vk.com/method/wall.get?owner_id=".$this->id_group_rob."&count=100&v=5.52&access_token=".$this->token."");
			$array_info = json_decode($query, true);
			$count = rand(0,$this->max_post);
			if(isset($array_info[response][items][$count][attachments]))
			{
				foreach ($array_info[response][items][$count][attachments] as $key => &$value)
				{
					$type = $array_info[response][items][$count][attachments][$key][type];
					$attachments .= $type.$array_info[response][items][$count][attachments][$key][$type][owner_id]."_".$array_info[response][items][$count][attachments][$key][$type][id].",";
				}
				$attachments = substr($attachments, 0, -1);
				$query = $this->curl("https://api.vk.com/method/wall.post?owner_id=".$this->id_group."&from_group=1&message=".urlencode($array_info[response][items][$count][text])."&attachments=".$attachments."&v=5.52&access_token=".$this->token."");
				$array_info = json_decode($query, true);
				print_r($query);
			}
			else
			{
				$query = $this->curl("https://api.vk.com/method/wall.post?owner_id=".$this->id_group."&from_group=1&message=".urlencode($array_info[response][items][$count][text])."&v=5.52&access_token=".$this->token."");	
				print_r($query);
			}
		}
		function SetVar($name_var, $value_var)
		{
			return $this->$name_var = $value_var;
		}
		function curl($url) 
		{
			$ch = curl_init($url);
			curl_setopt ($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt ($ch,CURLOPT_SSL_VERIFYHOST,false);
			curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,false);
			$response = curl_exec($ch);
			curl_close ($ch);
			return $response;
		}
	}
	echo "<br><br>Время выполнения: ".(microtime(true)-$start)." секунд.";
/*
	
	
*/
?>
