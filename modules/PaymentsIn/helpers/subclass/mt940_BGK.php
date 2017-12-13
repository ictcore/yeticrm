<?php
/**
 * mt940 BGK class
 * @package YetiForce.Helper
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
Vtiger_Loader::includeOnce('~~modules/PaymentsIn/helpers/mt940.php');

class mt940_BGK extends mt940
{

	public function parse()
	{
		$tab = $this->prepareFile();
		foreach ($tab as $line)
			$this->parseLine($line);
	}

	protected function parseLine($line)
	{
		$tag = substr($line, 1, strpos($line, ':', 1) - 1);
		$value = trim(substr($line, strpos($line, ':', 1) + 1));
		switch ($tag) {
			case '20':
				$this->refNumber = $value;
				break;
			case '25':
				$this->accountNumber = $value;
				break;
			case '28C':
				$this->extractNumber = $value;
				break;
			case 'NS':
				$code = substr($value, 0, 2);
				if ($code == '22')
					$this->ownerName = substr($value, 2);
				else if ($code == '23')
					$this->accountName = substr($value, 2);
				break;
			case '60F':
				$this->openBalance = $this->parseBalance($value);
				break;
			case '62F':
				$this->closeBalance = $this->parseBalance($value);
				break;
			case '64':
				$this->availableBalance = $this->parseBalance($value);
				break;
			case '61':
				self::parseOperation($value);
				break;
			case '86':
				//	if ($this->_lastTag == '61')
				$this->parseTransaction($value);
				break;
			default:
				break;
		}
		if ($tag)
			$this->_lastTag = $tag;
	}

	protected function parseTransaction($value)
	{
		$transaction = array(
			'code' => substr($value, 0, 3),
			'typeCode' => '',
			'number' => '',
			'title' => '',
			'contName' => '',
			'contAccount' => ''
		);
		$transaction['contName'] .= $value;

		$this->operations[count($this->operations) - 1]['details'] = $transaction;
	}

	protected function parseOperation($value)
	{
		$this->operations[] = array(
			'date' => substr($value, 0, 2) . '-' . substr($value, 2, 2) . '-' . substr($value, 4, 2),
			//'accountDate'	=> substr($value, 6, 2) . '-' .substr($value, 8, 2),
			'indicator' => substr($value, 6, 1),
			//'third_letter_currency_code' => substr($value, 11, 1),
			'amount' => substr($value, 7, strpos($value, ',') - 4)
		);
	}
}
