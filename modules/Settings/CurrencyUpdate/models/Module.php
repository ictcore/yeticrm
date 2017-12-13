<?php

/**
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Maciej Stencel <m.stencel@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_CurrencyUpdate_Module_Model extends \App\Base
{
	/*
	 * Returns objects instance
	 */

	public static function getCleanInstance()
	{
		$instance = new self();
		return $instance;
	}
	/*
	 * Returns CRMS active currency name by currency code
	 * @return string - currency name
	 */

	public static function getCRMCurrencyName($code)
	{
		return (new \App\Db\Query())
				->select('currency_name')
				->from('vtiger_currencies')
				->where(['currency_code' => $code])
				->limit(1)->scalar();
	}
	/*
	 * Returns list of active currencies in CRM
	 * @return <Integer> - number of currencies
	 */

	public function getCurrencyNum()
	{
		return count(vtlib\Functions::getAllCurrency(true));
	}
	/*
	 * Returns currency exchange rates for systems active currencies from bank
	 * @param <Date> $date - date for which to fetch exchange rates
	 * @param boolean $cron - true if fired by server, and so updates systems currency conversion rates
	 * @return boolean - true if fetched new exchange rates, false otherwise
	 */

	public function fetchCurrencyRates($dateCur, $cron = false)
	{

		$notifyNewRates = false;
		$dataReader = (new \App\Db\Query())->select(['id', 'currency_code'])
				->from('vtiger_currency_info')
				->where(['currency_status' => 'Active', 'deleted' => 0])
				->andWhere(['!=', 'defaultid', -11])->createCommand()->query();
		$numToConvert = $dataReader->count();
		if ($numToConvert >= 1) {
			$selectBankId = $this->getActiveBankId();
			$activeBankName = 'Settings_CurrencyUpdate_models_' . $this->getActiveBankName() . '_BankModel';
			$currIds = [];
			$otherCurrencyCode = [];
			while ($row = $dataReader->read()) {
				$id = $row['id'];
				$code = $row['currency_code'];
				$currIds[] = $id;
				$otherCurrencyCode[$code] = $id;
			}
			$currNum = (new \App\Db\Query())->from('yetiforce_currencyupdate')
				->where(['exchange_date' => $dateCur, 'currency_id' => $currIds, 'bank_id' => $selectBankId])
				->count(1);
			// download only if its not in archives
			if ($currNum != $numToConvert && class_exists($activeBankName)) {
				$bank = new $activeBankName();
				$bank->getRates($otherCurrencyCode, $dateCur, false);
				$notifyNewRates = true;
			}
		}

		return $notifyNewRates;
	}
	/*
	 * Synchronises database banks list with the bank classes existing on ftp
	 */

	public function refreshBanks()
	{
		$db = App\Db::getInstance();
		$dataReader = (new \App\Db\Query())->select(['id', 'bank_name'])
				->from('yetiforce_currencyupdate_banks')
				->createCommand()->query();
		while ($row = $dataReader->read()) {
			$id = $row['id'];
			$bankName = $row['bank_name'];
			$bankPath = __DIR__ . '/bankmodels/' . $bankName . '.php';
			if (!file_exists($bankPath)) { // delete bank from database
				$db->createCommand()->delete('yetiforce_currencyupdate_banks', ['id' => $id])->execute();
			}
		}
		foreach (new DirectoryIterator(__DIR__ . '/bankmodels/') as $fileInfo) {
			$fileName = $fileInfo->getFilename();
			$extension = end(explode('.', $fileName));
			$bankClassName = basename($fileName, '.' . $extension);
			if ($fileInfo->isDot() || $extension !== 'php') {
				continue;
			}
			$isExists = (new \App\Db\Query())->from('yetiforce_currencyupdate_banks')
				->where(['bank_name' => $bankClassName])
				->exists();
			if (!$isExists) {
				$db->createCommand()->insert('yetiforce_currencyupdate_banks', ['bank_name' => $bankClassName, 'active' => 0])->execute();
			}
		}
		if (!$this->getActiveBankId()) {
			$db->createCommand()->update('yetiforce_currencyupdate_banks', ['active' => 1], ['bank_name' => 'NBP'])->execute();
		}
	}
	/*
	 * Update currency rate in archives
	 * @param <Integer> $id - exchange rate id
	 * @param <Float> $exchange - exchange rate
	 */

	public function updateCurrencyRate($id, $exchange)
	{
		\App\Db::getInstance()->createCommand()
			->update('yetiforce_currencyupdate', ['exchange' => $exchange], ['id' => $id])
			->execute();
	}
	/*
	 * Adds currency exchange rate to archive
	 * @param <Integer> $currId - currency id
	 * @param <Date> $exchangeDate - exchange date
	 * @param <Float> $exchange - exchange rate
	 * @param <Integer> $bankId - bank id
	 */

	public function addCurrencyRate($currId, $exchangeDate, $exchange, $bankId)
	{

		\App\Db::getInstance()->createCommand()->insert('yetiforce_currencyupdate', [
			'currency_id' => $currId,
			'fetch_date' => date('Y-m-d'),
			'exchange_date' => $exchangeDate,
			'exchange' => $exchange,
			'bank_id' => $bankId,
		])->execute();
	}
	/*
	 * Returns currency exchange rate id
	 * @param <Integer> $currencyId - systems currency id
	 * @param <Date> $exchangeDate - date of exchange rate
	 * @param <Integer> $bankId - id of bank
	 * @return <Integer> - currency rate id
	 */

	public function getCurrencyRateId($currencyId, $exchangeDate, $bankId)
	{
		return (new \App\Db\Query())->select('id')
				->from('yetiforce_currencyupdate')
				->where(['exchange_date' => $exchangeDate, 'currency_id' => $currencyId, 'bank_id' => $bankId])
				->limit(1)->scalar();
	}
	/*
	 * Returns currency rates from archive
	 * @param <Integer> $bankId - bank id
	 * @param <Date> $dateCur - date, if empty show this months history
	 * @return <Array> - array containing currency rates
	 */

	public function getRatesHistory($bankId, $dateCur, $request)
	{
		$query = new App\Db\Query();
		$query->select(['exchange', 'currency_name', 'currency_code', 'currency_symbol', 'fetch_date', 'exchange_date'])
			->from('yetiforce_currencyupdate')
			->innerJoin('vtiger_currency_info', 'vtiger_currency_info.id = yetiforce_currencyupdate.currency_id')
			->innerJoin('yetiforce_currencyupdate_banks', 'yetiforce_currencyupdate_banks.id = yetiforce_currencyupdate.bank_id')
			->where(['yetiforce_currencyupdate.bank_id' => $bankId]);
		// filter by date - if not exists then display this months history
		$filter = $request->get('duedate');
		if ($filter == '' && $dateCur) {
			$query->andWhere(['between', 'exchange_date', date('Y-m-01'), date('Y-m-t')]);
		} else {
			$query->andWhere(['exchange_date' => $dateCur]);
		}
		$query->orderBy(['exchange_date' => SORT_DESC, 'currency_code' => SORT_ASC]);
		$dataReader = $query->createCommand()->query();
		$history = $dataReader->readAll();
		return $history;
	}
	/*
	 * Returns list of supported currencies by active bank
	 * @param string $bankName - bank name
	 * @return <Array> - array of supported currencies
	 */

	public function getSupportedCurrencies($bankName = null)
	{
		if (!$bankName) {
			$bankName = 'Settings_CurrencyUpdate_models_' . $this->getActiveBankName() . '_BankModel';
		}
		$bank = new $bankName();

		return $bank->getSupportedCurrencies();
	}
	/*
	 * Returns list of unsupported currencies by active bank
	 * @param string $bankName - bank name
	 * @return <Array> - array of unsupported currencies
	 */

	public function getUnSupportedCurrencies($bankName = null)
	{
		if (!$bankName) {
			$bankName = 'Settings_CurrencyUpdate_models_' . $this->getActiveBankName() . '_BankModel';
		}
		$bank = new $bankName();
		$supported = $bank->getSupportedCurrencies($bankName);
		$dataReader = (new \App\Db\Query())->select(['currency_name', 'currency_code'])
				->from('vtiger_currency_info')
				->where(['currency_status' => 'Active', 'deleted' => 0])
				->createCommand()->query();
		while ($row = $dataReader->read()) {
			$name = $row['currency_name'];
			$code = $row['currency_code'];
			$unsupported[$name] = $code;
		}
		return array_diff($unsupported, $supported);
	}
	/*
	 * Sets systems exchange rate for chosen currency
	 * @param string $currency - currency code
	 * @param <Float> $exchange - exchange rate
	 */

	public function setCRMConversionRate($currency, $exchange)
	{
		$rate = (float) $exchange;
		\App\Db::getInstance()->createCommand()
			->update('vtiger_currency_info', ['conversion_rate' => $rate], ['currency_code' => $currency])
			->execute();
	}
	/*
	 * Function that retrieves conversion rate from and to specified currency
	 * @param string $from - currency code or id (converted to code)
	 * @param string $to - currency code or id (converted to code)
	 * @param <Date> $date - date of the exchange rate
	 * @return <Float> - conversion rate
	 */

	public function getCRMConversionRate($from, $to, $date = '')
	{
		$mainCurrencyCode = vtlib\Functions::getDefaultCurrencyInfo()['currency_code'];
		$activeBankId = self::getActiveBankId();
		$exchange = false;
		if (is_numeric($from)) {
			$from = vtlib\Functions::getAllCurrency(true)[$from]['currency_code'];
		}
		if (is_numeric($to)) {
			$to = vtlib\Functions::getAllCurrency(true)[$to]['currency_code'];
		}
		// get present conversion rate from crm
		if (empty($date)) {
			$query = new App\Db\Query();
			$query->select('conversion_rate')
				->from('vtiger_currency_info')
				->where(['currency_code' => $to])
				->limit(1);
			$exchange = floatval($query->scalar());
			if ($from != $mainCurrencyCode) {
				$convertToMainCurrency = 1 / $exchange;
				$query = new App\Db\Query();
				$query->select('conversion_rate')
					->from('vtiger_currency_info')
					->where(['currency_code' => $from])
					->limit(1);
				$fromExchange = floatval($query->scalar());
				$exchange = 1 / ($fromExchange * $convertToMainCurrency);
			}
		}
		// get conversion rate from archive
		else {
			$query = new App\Db\Query();
			$query->from('yetiforce_currencyupdate')
				->innerJoin('vtiger_currency_info', 'vtiger_currency_info.id = yetiforce_currencyupdate.currency_id AND deleted = :del', [':del' => 0])
				->where(['yetiforce_currencyupdate.exchange_date' => $date,
					'yetiforce_currencyupdate.bank_id' => $activeBankId,
					'vtiger_currency_info.currency_code' => $to])
				->limit(1);
			$num = floatval($query->count());
			// no exchange rate in archive, fetch new rates
			if ($num == 0) {
				self::fetchCurrencyRates($date);
			}
			$query = new App\Db\Query();
			$query->select('yetiforce_currencyupdate.exchange')
				->from('yetiforce_currencyupdate')
				->innerJoin('vtiger_currency_info', 'vtiger_currency_info.id = yetiforce_currencyupdate.currency_id AND deleted = :del', [':del' => 0])
				->where(['yetiforce_currencyupdate.exchange_date' => $date,
					'yetiforce_currencyupdate.bank_id' => $activeBankId,
					'vtiger_currency_info.currency_code' => $to])
				->limit(1);
			$exchange = floatval($query->scalar());
			if ($exchange > 0) {
				$exchange = 1 / $exchange;
			}

			if ($from != $mainCurrencyCode) {
				$convertToMainCurrency = $exchange == 0 ? 1 : 1 / $exchange;
				$query = new App\Db\Query();
				$query->select('yetiforce_currencyupdate.exchange')
					->from('yetiforce_currencyupdate')
					->innerJoin('vtiger_currency_info', 'vtiger_currency_info.id = yetiforce_currencyupdate.currency_id AND deleted = :del', [':del' => 0])
					->where(['yetiforce_currencyupdate.exchange_date' => $date,
						'yetiforce_currencyupdate.bank_id' => $activeBankId,
						'vtiger_currency_info.currency_code' => $from])
					->limit(1);
				$fromExchange = floatval($query->scalar());
				if ($from != $mainCurrencyCode && $to != $mainCurrencyCode) {
					$exchange = $fromExchange / $convertToMainCurrency;
				} else {
					$exchange = $fromExchange * $convertToMainCurrency;
				}
			}
		}

		return $exchange = round($exchange, 5);
	}
	/*
	 * Convert given amount in one currency to another
	 * @param <Float> $amount - number to convert
	 * @param string $from - currency code
	 * @param string $to - currency code
	 * @param <Date> $date - date of the exchange rate
	 * @return <Float> - floating point number
	 */

	public function convertFromTo($amount, $from, $to, $date = false)
	{
		return round($amount * $this->getCRMConversionRate($from, $to, $date), 5);
	}
	/*
	 * Returns id of active bank
	 * @return <Integer> - bank id
	 */

	public function getActiveBankId()
	{
		return (new \App\Db\Query())->select('id')->from('yetiforce_currencyupdate_banks')->where(['active' => 1])->limit(1)->scalar();
	}
	/*
	 * Saves new active bank by id
	 * @param <Integer> $bankId - bank id
	 * @return boolean - true on success or false
	 */

	public function setActiveBankById($bankId)
	{
		$db = \App\Db::getInstance();
		$db->createCommand()->update('yetiforce_currencyupdate_banks', ['active' => 0])->execute();
		$result = $db->createCommand()->update('yetiforce_currencyupdate_banks', ['active' => 1], ['id' => $bankId])->execute();
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
	/*
	 * Returns active banks name
	 * @return string - bank name
	 */

	public function getActiveBankName()
	{
		return (new \App\Db\Query())->select('bank_name')->from('yetiforce_currencyupdate_banks')->where(['active' => 1])->limit(1)->scalar();
	}
}
