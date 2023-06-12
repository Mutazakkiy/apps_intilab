<?php
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class LoginModel {

	public function checkLogin($data)
	{
		if(file_exists('file/user.json')){
			$file = file_get_contents('file/user.json');
			if($file){
				$value = json_decode($file, true);
				$query = $value['uname'];
				if($_POST['username'] == $query['identity'] && $_POST['password'] == $query['password']){
					if($value['session']['expired_at'] == date('Y-m-d H:i:s')){
						$client = new Client();
						$guzzle = $client->request('POST', 'https://apps.intilab.com/eng/backend/public/default/api/gettoken',
						[
							'headers' => [ 'Content-Type' => 'application/json' ],
							'body' => json_encode([
								'identity' => $_POST['username'],
								'password' => $_POST['password'],
							]),
							'http_errors' => false
						]
						);
						if ($guzzle->getStatusCode() != 200) {
							$response['session'] = NULL;
							$response['message'] = 'Login Gagal';
							return $response;
						} else {
							$return = $guzzle->getBody()->getContents();
							$res = (array)json_decode($return);
							$uname = ['identity' => $_POST['username'],'password' => $_POST['password']];
							$array = [
								'uname' => $uname, 
								'session' => $res
							];
							if($res['status'] == 200){
								$file = file_put_contents('file/user.json', json_encode($array));
								$response['session'] = $res;
								$response['message'] = 'Login Success';
								return $response;
							}else {
								$response['session'] = NULL;
								$response['message'] = 'Login Gagal';
								return $response;
							}
						}
					}else {
						$response['session'] = $value['session'];
						$response['message'] = 'Login Success';
						return $response;
					}
				} else {
					$client = new Client();
						$guzzle = $client->request('POST', 'https://apps.intilab.com/eng/backend/public/default/api/gettoken',
						[
							'headers' => [ 'Content-Type' => 'application/json' ],
							'body' => json_encode([
								'identity' => $_POST['username'],
								'password' => $_POST['password'],
							]),
							'http_errors' => false
						]);
						if ($guzzle->getStatusCode() != 200) {
							$response['session'] = NULL;
							$response['message'] = 'Login Gagal';
							return $response;
						} else {
							$return = $guzzle->getBody()->getContents();
							$res = (array)json_decode($return);
							$uname = ['identity' => $_POST['username'],'password' => $_POST['password']];
							$array = [
								'uname' => $uname, 
								'session' => $res
							];
							if($res['status'] == 200){
								$file = file_put_contents('file/user.json', json_encode($array));
								$response['session'] = $res;
								$response['message'] = 'Login Success';
								return $response;
							}else {
								$response['session'] = NULL;
								$response['message'] = 'Login Gagal';
								return $response;
							}
						}
				}
				// else if($_POST['username'] != $query['identity'] && $_POST['password'] == $query['password']){
				// 	$response['session'] = NULL;
				// 	$response['message'] = 'Username Tidak Ditemukan';
				// 	return $response;
				// } else if($_POST['username'] == $query['identity'] && $_POST['password'] != $query['password']){
				// 	$response['session'] = NULL;
				// 	$response['message'] = 'Password Salah';
				// 	return $response;
				// } else {
				// 	$response['session'] = NULL;
				// 	$response['message'] = 'Login Gagal';
				// 	return $response;
				// }
				// // return (array)$value;
			}else {
				$response['session'] = NULL;
				$response['message'] = 'Login Gagal';
				return $response;
			}
		}else {

			$client = new Client();
			$guzzle = $client->request('POST', 'https://apps.intilab.com/eng/backend/public/default/api/gettoken',
			[
				'headers' => [ 'Content-Type' => 'application/json' ],
				'body' => json_encode([
					'identity' => $_POST['username'],
					'password' => $_POST['password'],
				]),
				'http_errors' => false
			]);
			$return = $guzzle->getBody()->getContents();
			$res = (array)json_decode($return);
			$uname = ['identity' => $_POST['username'],'password' => $_POST['password']];
			$array = [
				'uname' => $uname, 
				'session' => $res
			];
			if($res['status'] == 200){
				$file = file_put_contents('file/user.json', json_encode($array));
				$response['session'] = $res;
				$response['message'] = 'Login Success';
				return $response;
			}else {
				$response['session'] = NULL;
				$response['message'] = 'Login Gagal';
				return $response;
			}
		}
	}

}