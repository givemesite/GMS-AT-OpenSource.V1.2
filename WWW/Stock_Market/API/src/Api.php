<?php
//phpinfo();
namespace Andrewbo\Robinhood;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
 

abstract class Api {


  
  //
  // Magic function to catch all static calls.
  //
  public static function __callStatic($name, $args)
  {
    return call_user_func_array([ static::instance(), $name ], $args);
  }


	const API_HOST = 'https://api.robinhood.com';

	const ENDPOINTS = [
		self::ENDPOINT_AUTH                  => '/api-token-auth/',
		self::ENDPOINT_ACCOUNTS              => '/accounts/',
		self::ENDPOINT_ACH_DEPOSIT_SCHEDULES => '/ach/deposit_schedules/',
		self::ENDPOINT_ACH_IAV_AUTH          => '/ach/iav/auth/',
		self::ENDPOINT_ACH_QUEUED_DEPOSIT    => '/ach/queued_deposit/',
		self::ENDPOINT_ACH_RELATIONSHIPS     => '/ach/relationships/',
		self::ENDPOINT_ACH_TRANSFERS         => '/ach/transfers/',
		self::ENDPOINT_APPLICATIONS          => '/applications/',
		self::ENDPOINT_DIVIDENDS             => '/dividends/',
		self::ENDPOINT_DOCUMENT_REQUESTS     => '/upload/document_requests/',
		self::ENDPOINT_EDOCUMENTS            => '/documents/',
		self::ENDPOINT_ID_DOCUMENTS          => '/upload/photo_ids/',
		self::ENDPOINT_INSTRUMENTS           => '/instruments/',
		self::ENDPOINT_INVESTMENT_PROFILE    => '/user/investment_profile/',
		self::ENDPOINT_MARGIN_UPGRADES       => '/margin/upgrades/',
		self::ENDPOINT_MARKETS               => '/markets/',
		self::ENDPOINT_NOTIFICATION_SETTINGS => '/settings/notifications/',
		self::ENDPOINT_NOTIFICATIONS         => '/notifications/',
		self::ENDPOINT_ORDERS                => '/orders/',
		self::ENDPOINT_PASSWORD_CHANGE       => '/password_change/',
		self::ENDPOINT_PASSWORD_RESET        => '/password_reset/request/',
		self::ENDPOINT_PORTFOLIOS            => '/portfolios/',
		self::ENDPOINT_POSITIONS             => '/positions/',
		self::ENDPOINT_QUOTES                => '/quotes/',
		self::ENDPOINT_SUBSCRIPTIONS         => '/subscription/subscriptions/',
		self::ENDPOINT_USER                  => '/user/',
		self::ENDPOINT_WATCHLISTS            => '/watchlists/',
		self::ENDPOINT_WIRE_RELATIONSHIPS    => '/wire/relationships/',
		self::ENDPOINT_WIRE_TRANSFERS        => '/wire/transfers/',
	];

	const ENDPOINT_AUTH = 'login';
	const ENDPOINT_ACCOUNTS = 'accounts';
	const ENDPOINT_ACH_DEPOSIT_SCHEDULES = 'ach_deposit_schedules';
	const ENDPOINT_ACH_IAV_AUTH = 'ach_iav_auth';
	const ENDPOINT_ACH_QUEUED_DEPOSIT = 'ach_queued_deposit';
	const ENDPOINT_ACH_RELATIONSHIPS = 'ach_relationships';
	const ENDPOINT_ACH_TRANSFERS = 'ach_transfers';
	const ENDPOINT_APPLICATIONS = 'applications';
	const ENDPOINT_DIVIDENDS = 'dividends';
	const ENDPOINT_DOCUMENT_REQUESTS = 'document_requests';
	const ENDPOINT_EDOCUMENTS = 'edocuments';
	const ENDPOINT_ID_DOCUMENTS = 'id_documents';
	const ENDPOINT_INSTRUMENTS = 'instruments';
	const ENDPOINT_INVESTMENT_PROFILE = 'investment_profile';
	const ENDPOINT_MARGIN_UPGRADES = 'margin_upgrades';
	const ENDPOINT_MARKETS = 'markets';
	const ENDPOINT_NOTIFICATION_SETTINGS = 'notification_settings';
	const ENDPOINT_NOTIFICATIONS = 'notifications';
	const ENDPOINT_ORDERS = 'orders';
	const ENDPOINT_PASSWORD_CHANGE = 'password_change';
	const ENDPOINT_PASSWORD_RESET = 'password_reset';
	const ENDPOINT_PORTFOLIOS = 'portfolios';
	const ENDPOINT_POSITIONS = 'positions';
	const ENDPOINT_QUOTES = 'quotes';
	const ENDPOINT_SUBSCRIPTIONS = 'subscriptions';
	const ENDPOINT_USER = 'user';
	const ENDPOINT_WATCHLISTS = 'watchlists';
	const ENDPOINT_WIRE_RELATIONSHIPS = 'wire_relationships';
	const ENDPOINT_WIRE_TRANSFERS = 'wire_transfers';

	const AUTH_PARAM_USERNAME = 'username';
	const AUTH_PARAM_PASSWORD = 'password';

	const REQUEST_METHOD_POST = 'POST';
	const REQUEST_METHOD_GET  = 'GET';

	const RESPONSE_CODE_SUCCESS = 200;



	/**
	 * @var null|Client
	 */
	protected $guzzleClient = null;

	/**
	 * @var string
	 */
	protected $token = '';

	/**
	 * @var array[string]
	 */
	protected $errors = [];



	/**
	 * Api constructor
	 */
	public function __construct() {
		$this->guzzleClient = new Client();
	}

	/**
	 * @param string $uri URI or ENDPOINT (see constants)
	 * @param array $formParams
	 *
	 * @return array|bool
	 */
	protected function makeRequest($uri, $formParams = []) {

		$uri = empty($this->getEndpointUriBySlug($uri)) ? $uri : $this->getEndpointUriBySlug($uri);

		$requestMethod = self::REQUEST_METHOD_GET;
		$isAuthRequest = isset($formParams[self::AUTH_PARAM_USERNAME], $formParams[self::AUTH_PARAM_PASSWORD]);

		if ( ! $isAuthRequest && empty($this->token)) {
			$this->addError('Can\'t work with API without token. Log in first.');
			return false;
		}

		$requestData =  [
			'headers' => [ 'Authorization' => 'Token ' . $this->token ],
		];

		if ($isAuthRequest) {
			$requestMethod = self::REQUEST_METHOD_POST;
			$requestData =  [
				'form_params' => $formParams,
			];
		}

		try {
			$guzzleResponse = $this->guzzleClient->request($requestMethod, $uri, $requestData);
		} catch (ClientException $e) {
			$this->addError($e->getMessage());
			return false;
		}

		if (self::RESPONSE_CODE_SUCCESS !== $guzzleResponse->getStatusCode()) {
			$this->addError('Failed to make a request to ' . $uri . '. ' . $this->getDetailedGuzzleErrorMessage($guzzleResponse));
			return false;
		}

		$guzzleData = json_decode($guzzleResponse->getBody(), true);

		if ($isAuthRequest) {
			if ( ! isset($guzzleData['token']) || empty($guzzleData['token'])) {
				$this->addError('Failed to find a token.');
				return false;
			}
			$this->token = (string) $guzzleData['token'];
			return true;
		}

		return isset($guzzleData['results']) ? (array) $guzzleData['results'] : $guzzleData;
	}

	/**
	 * @param string $slug
	 *
	 * @return string
	 */
	protected function getEndpointUriBySlug($slug) {
		$uri = '';
		if (is_string($slug) && key_exists($slug, self::ENDPOINTS)) {
			$uri = self::API_HOST . self::ENDPOINTS[$slug];
		}
		return $uri;
	}

	/**
	 * @param ResponseInterface $response
	 *
	 * @return string
	 */
	protected function getDetailedGuzzleErrorMessage(ResponseInterface $response) {
		return sprintf('Status code: %s. Reason: %s.', $response->getStatusCode(), $response->getReasonPhrase());
	}

	/**
	 * @param string $message
	 */
	protected function addError($message) {
		$this->errors[] = (string) $message;
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return (array) $this->errors;
	}

}




/* End File */



