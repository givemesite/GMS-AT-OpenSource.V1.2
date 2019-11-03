<?php

namespace Andrewbo\Robinhood\Entities;

class Account {

	const PARAM_ACCOUNT_NUMBER = 'account_number';
	const PARAM_BUYING_POWER = 'buying_power';
	const PARAM_CASH = 'cash';
	const PARAM_CASH_AVAILABLE_FOR_WITHDRAWAL = 'cash_available_for_withdrawal';
	const PARAM_CASH_HELD_FOR_ORDERS = 'cash_held_for_orders';
	const PARAM_CREATED_AT = 'created_at';
	const PARAM_DEACTIVATED = 'deactivated';
	const PARAM_DEPOSIT_HALTED = 'deposit_halted';
	const PARAM_MARGIN_BALANCES = 'margin_balances';
	const PARAM_MAX_ACH_EARLY_ACCESS_AMOUNT = 'max_ach_early_access_amount';
	const PARAM_ONLY_POSITION_CLOSING_TRADES = 'only_position_closing_trades';
	const PARAM_PORTFOLIO = 'portfolio';
	const PARAM_POSITIONS = 'positions';
	const PARAM_SMA = 'sma';
	const PARAM_SMA_HELD_FOR_ORDERS = 'sma_held_for_orders';
	const PARAM_SWEEP_ENABLED = 'sweep_enabled';
	const PARAM_TYPE = 'type';
	const PARAM_UNCLEARED_DEPOSITS = 'uncleared_deposits';
	const PARAM_UNSETTLED_FUNDS = 'unsettled_funds';
	const PARAM_UPDATED_AT = 'updated_at';
	const PARAM_URL = 'url';
	const PARAM_USER = 'user';
	const PARAM_WITHDRAWAL_HALTED = 'withdrawal_halted';

	const PARAMS = [
		self::PARAM_ACCOUNT_NUMBER,
		self::PARAM_BUYING_POWER,
		self::PARAM_CASH,
		self::PARAM_CASH_AVAILABLE_FOR_WITHDRAWAL,
		self::PARAM_CASH_HELD_FOR_ORDERS,
		self::PARAM_CREATED_AT,
		self::PARAM_DEACTIVATED,
		self::PARAM_DEPOSIT_HALTED,
		self::PARAM_MARGIN_BALANCES,
		self::PARAM_MAX_ACH_EARLY_ACCESS_AMOUNT,
		self::PARAM_ONLY_POSITION_CLOSING_TRADES,
		self::PARAM_PORTFOLIO,
		self::PARAM_POSITIONS,
		self::PARAM_SMA,
		self::PARAM_SMA_HELD_FOR_ORDERS,
		self::PARAM_SWEEP_ENABLED,
		self::PARAM_TYPE,
		self::PARAM_UNCLEARED_DEPOSITS,
		self::PARAM_UNSETTLED_FUNDS,
		self::PARAM_UPDATED_AT,
		self::PARAM_URL,
		self::PARAM_USER,
		self::PARAM_WITHDRAWAL_HALTED,
	];

	/**
	 * @var string
	 */
	protected $account_number;

	/**
	 * @var float
	 */
	protected $buying_power;

	/**
	 * @var float
	 */
	protected $cash;

	/**
	 * @var float
	 */
	protected $cash_available_for_withdrawal;

	/**
	 * @var float
	 */
	protected $cash_held_for_orders;

	/**
	 * @var \DateTime
	 */
	protected $created_at;

	/**
	 * @var bool
	 */
	protected $deactivated;

	/**
	 * @var bool
	 */
	protected $deposit_halted;

	/**
	 * @var null
	 */
	protected $margin_balances;

	/**
	 * @var float
	 */
	protected $max_ach_early_access_amount;

	/**
	 * @var bool
	 */
	protected $only_position_closing_trades;

	/**
	 * @format https://api.robinhood.com/accounts/{account_number}/portfolio/
	 * @var string
	 */
	protected $portfolio;

	/**
	 * @format https://api.robinhood.com/accounts/{account_number}/positions/
	 * @var string
	 */
	protected $positions;

	/**
	 * @var null
	 */
	protected $sma;

	/**
	 * @var null
	 */
	protected $sma_held_for_orders;

	/**
	 * @var bool
	 */
	protected $sweep_enabled;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var float
	 */
	protected $uncleared_deposits;

	/**
	 * @var float
	 */
	protected $unsettled_funds;

	/**
	 * @var \DateTime
	 */
	protected $updated_at;

	/**
	 * @format https://api.robinhood.com/accounts/{account_number}/
	 * @var string
	 */
	protected $url;

	/**
	 * @format https://api.robinhood.com/user/
	 * @var string
	 */
	protected $user;

	/**
	 * @var bool
	 */
	protected $withdrawal_halted;


	/**
	 * Account constructor
	 *
	 * @param array $accountData
	 */
	public function __construct($accountData) {
		$this->loadData($accountData);
	}

	/**
	 * @param array $data
	 */
	protected function loadData($data) {
		foreach (self::PARAMS as $paramName) {
			if (isset($data[$paramName])) {

				// check for DateTime fields
				if (in_array($paramName, array(self::PARAM_CREATED_AT, self::PARAM_UPDATED_AT))) {
					$this->$paramName = new \DateTime($data[$paramName]);
					continue;
				}

				$this->$paramName = $data[$paramName];
			}
		}
	}

	/**
	 * @param $name
	 *
	 * @return null|string|bool|\DateTime
	 */
	public function __get($name) {
		if (in_array($name, self::PARAMS)) {
			return $this->$name;
		}
		return null;
	}

}