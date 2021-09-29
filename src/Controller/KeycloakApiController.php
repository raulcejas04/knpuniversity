<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\KeycloakClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\DependencyInjection\ContainerInterface;
// use Symfony\Component\HttpFoundation\Request;

use GuzzleHttp;

class KeycloakApiController extends AbstractController
{
	private $client;
	protected $container;
	protected $refreshToken;
	protected $Token;
	
	public function __construct(ContainerInterface $container, ClientRegistry $clientRegistry ){
		$this->container = $container;
		$this->client = new GuzzleHttp\Client();
		
		//$client=$clientRegistry->getClient('keycloak');
		//$this->Token = $client->getAccessToken();
		//dd($accessToken);
		//$this->refreshToken = $accessToken->getRefreshToken;
		//dd($refresToken);
	}
	/**
	 * POST /admin/realms/{realm}/users/{id}/logout
	 */
	public function logout($usuario_id ){
		
		
		//$token = $this->getTokenAdmin();
		$base_uri_keycloak = $this->getParameter('KEYCLOAK_APP_URL');
		$realm = $this->getParameter('KEYCLOAK_REALM');
		$uri = $base_uri_keycloak.'/admin/realms/{realm}/users/{id}/logout';
		$uri = str_replace("{realm}", $realm, $uri);
		$uri = str_replace("{id}", $usuario_id, $uri);
		
		$params = ['headers' => ['Authorization' => "Bearer ".$token->access_token]];
		
		$res = $this->client->post($uri, $params);
		$data = json_decode($res->getBody());
	}
	
	public function getTokenAdmin(){
		$base_uri_keycloak = $this->getParameter('auth_server_url');
		$uri = $base_uri_keycloak.'/realms/master/protocol/openid-connect/token';
		$parametros = [
				'form_params' => [
						'username' => $this->getParameter('KEYCLAOK_ADMIN_USERNAME'),
						'password' => $this->getParameter('KEYCLOAK_ADMIN_PASSWORD'),
						'grant_type' => $this->getParameter('KEYCLOAK_GRANT_TYPE'),
						'client_id' => $this->getParameter('KEYCLOAK_ADMIN_CLIENT_ID')
				]
		];

		$res = $this->client->post($uri, $parametros);
		$data = json_decode($res->getBody());
		return $data;
	}
}
?>
