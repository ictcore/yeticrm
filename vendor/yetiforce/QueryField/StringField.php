<?php
namespace App\QueryField;

/**
 * String Query Field Class
 * @package YetiForce.App
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class StringField extends BaseField
{

	/**
	 * Starts with operator
	 * @return array
	 */
	public function operatorS()
	{
		$values = $this->getValue();
		if (is_array($values)) { // Used only to filter the first letter of the name 
			$condition = ['or'];
			foreach ($values as $value) {
				$condition [] = ['like', $this->getColumnName(), $value . '%', false];
			}
			return $condition;
		}
		return ['like', $this->getColumnName(), $this->getValue() . '%', false];
	}

	/**
	 * Ends with operator
	 * @return array
	 */
	public function operatorEw()
	{
		return ['like', $this->getColumnName(), '%' . $this->getValue(), false];
	}
}
