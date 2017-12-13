<?php

/**
 * Reservations calendar model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class Reservations_Calendar_Model extends \App\Base
{

	/**
	 * Function to get records
	 * @return array
	 */
	public function getEntity()
	{
		$db = App\Db::getInstance();
		$module = 'Reservations';
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$query = (new \App\Db\Query())->from('vtiger_reservations')
			->innerJoin('vtiger_crmentity', 'vtiger_crmentity.crmid = vtiger_reservations.reservationsid')
			->innerJoin('vtiger_reservationscf', 'vtiger_reservationscf.reservationsid = vtiger_reservations.reservationsid')
			->where(['vtiger_crmentity.deleted' => 0]);

		if ($this->get('start') && $this->get('end')) {
			$dbStartDateOject = DateTimeField::convertToDBTimeZone($this->get('start'), $currentUser, false);
			$dbStartDateTime = $dbStartDateOject->format('Y-m-d H:i:s');
			$dbStartDate = $dbStartDateOject->format('Y-m-d');
			$dbEndDateObject = DateTimeField::convertToDBTimeZone($this->get('end'), $currentUser, false);
			$dbEndDateTime = $dbEndDateObject->format('Y-m-d H:i:s');
			$dbEndDate = $dbEndDateObject->format('Y-m-d');
			$query->andWhere([
				'and',
				['or',
					['and',
						['>=', new \yii\db\Expression('CONCAT(vtiger_reservations.date_start, ' . $db->quoteValue(' ') . ', vtiger_reservations.time_start)'), $dbStartDateTime],
						['<=', new \yii\db\Expression('CONCAT(vtiger_reservations.date_start, ' . $db->quoteValue(' ') . ', vtiger_reservations.time_start)'), $dbEndDateTime],
					],
					['and',
						['>=', new \yii\db\Expression('CONCAT(vtiger_reservations.due_date, ' . $db->quoteValue(' ') . ', vtiger_reservations.time_end)'), $dbStartDateTime],
						['<=', new \yii\db\Expression('CONCAT(vtiger_reservations.due_date, ' . $db->quoteValue(' ') . ', vtiger_reservations.time_end)'), $dbEndDateTime],
					],
					['and',
						['<', 'vtiger_reservations.date_start', $dbStartDate],
						['>', 'vtiger_reservations.due_date', $dbEndDate],
					],
				]
			]);
		}
		if ($this->get('types')) {
			$query->andWhere(['vtiger_reservations.type' => $this->get('types')]);
		}
		if (!empty($this->get('user'))) {
			$owners = $this->get('user');
			if (!is_array($owners)) {
				$owners = (int) $owners;
			}
			$query->andWhere(['vtiger_crmentity.smownerid' => $owners]);
		}
		\App\PrivilegeQuery::getConditions($query, $module);
		$query->orderBy(['date_start' => SORT_ASC, 'time_start' => SORT_ASC]);
		$dataReader = $query->createCommand()->query();
		$result = [];
		while ($record = $dataReader->read()) {
			$crmid = $record['reservationsid'];
			$item['id'] = $crmid;
			$item['title'] = $record['title'];
			$item['url'] = 'index.php?module=Reservations&view=Detail&record=' . $crmid;
			$dateTimeFieldInstance = new DateTimeField($record['date_start'] . ' ' . $record['time_start']);
			$userDateTimeString = $dateTimeFieldInstance->getDisplayDateTimeValue($currentUser);
			$dateTimeComponents = explode(' ', $userDateTimeString);
			$dateComponent = $dateTimeComponents[0];
			//Conveting the date format in to Y-m-d . since full calendar expects in the same format
			$dataBaseDateFormatedString = DateTimeField::__convertToDBFormat($dateComponent, $currentUser->get('date_format'));
			$item['start'] = $dataBaseDateFormatedString . ' ' . $dateTimeComponents[1];
			$dateTimeFieldInstance = new DateTimeField($record['due_date'] . ' ' . $record['time_end']);
			$userDateTimeString = $dateTimeFieldInstance->getDisplayDateTimeValue($currentUser);
			$dateTimeComponents = explode(' ', $userDateTimeString);
			$dateComponent = $dateTimeComponents[0];
			//Conveting the date format in to Y-m-d . since full calendar expects in the same format
			$dataBaseDateFormatedString = DateTimeField::__convertToDBFormat($dateComponent, $currentUser->get('date_format'));
			$item['end'] = $dataBaseDateFormatedString . ' ' . $dateTimeComponents[1];
			$item['className'] = ' userCol_' . $record['smownerid'] . ' calCol_' . $record['type'];
			$result[] = $item;
		}
		return $result;
	}

	/**
	 * Static Function to get the instance of Vtiger Module Model for the given id or name
	 */
	public static function getInstance()
	{
		$instance = Vtiger_Cache::get('reservationsModels', 'Calendar');
		if ($instance === false) {
			$instance = new self();
			Vtiger_Cache::set('reservationsModels', 'Calendar', clone $instance);
			return $instance;
		} else {
			return clone $instance;
		}
	}

	/**
	 * Function to get calendar types
	 * @return string[]
	 */
	public static function getCalendarTypes()
	{
		$templateId = Vtiger_Field_Model::getInstance('type', Vtiger_Module_Model::getInstance('Reservations'))->getFieldParams();
		return (new App\Db\Query())->select(['tree', 'label'])->from('vtiger_trees_templates_data')
				->where(['templateid' => $templateId])
				->createCommand()->queryAllByGroup(0);
	}
}
