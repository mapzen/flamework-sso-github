<?php

	loadlib("http");

	#################################################################

	$GLOBALS['github_api_endpoint'] = '';
	$GLOBALS['github_oauth_endpoint'] = 'https://dev.github.com/oauth/';

	#################################################################

	function github_api_get_auth_url(){

		$callback = $GLOBALS['cfg']['abs_root_url'] . $GLOBALS['cfg']['github_oauth_callback'];

		$oauth_key = $GLOBALS['cfg']['github_oauth_key'];
        	$oauth_redir = urlencode($callback);

		$url = "{$GLOBALS['github_oauth_endpoint']}authenticate?client_id={$oauth_key}&response_type=code&redirect_uri=$oauth_redir";
		return $url;
	}

	#################################################################

	function github_api_get_auth_token($code){

		$callback = $GLOBALS['cfg']['abs_root_url'] . $GLOBALS['cfg']['github_oauth_callback'];

		$args = array(
			'client_id' => $GLOBALS['cfg']['github_oauth_key'],
			'client_secret' => $GLOBALS['cfg']['github_oauth_secret'],
			'grant_type' => 'authorization_code',
			'redirect_uri' => $callback,
			'code' => $code,
		);

		$query = http_build_query($args);

		$url = "{$GLOBALS['github_oauth_endpoint']}access_token?{$query}";
		$rsp = http_get($url);

		if (! $rsp['ok']){
			return $rsp;
		}

		$data = json_decode($rsp['body'], 'as hash');

		if ((! $data) || (! $data['access_token'])){
			return not_okay("failed to parse response");
		}

		return okay(array(
			'oauth_token' => $data['access_token']
		));
	}

	#################################################################

?>
