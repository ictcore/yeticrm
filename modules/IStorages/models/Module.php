<?php

/**
 * Module Class for IStorages
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class IStorages_Module_Model extends Vtiger_Module_Model
{

	public static $modulesToCalculate = ['add' => ['IGRN', 'IIDN', 'ISTRN', 'IGRNC'], 'remove' => ['IGDN', 'IGIN', 'IPreOrder', 'ISTDN', 'IGDNC']];

	public static function getOperator($moduleName, $action)
	{
		if (in_array($moduleName, self::$modulesToCalculate['add'])) {
			if ('add' == $action) {
				return '+';
			}
			return '-';
		}
		if (in_array($moduleName, self::$modulesToCalculate['remove'])) {
			if ('add' == $action) {
				return '-';
			}
			return '+';
		}
	}

	public static function RecalculateStock($moduleName = false, $data = false, $storageId = false, $action = false)
	{
		if ($moduleName === false) {
			self::setQtyInStocks(self::getAllQtyInStocks());
		} else {
			self::setQtyInStock($moduleName, $data, $storageId, $action);
		}
	}

	public static function setQtyInStock($moduleName, $data, $storageId, $action)
	{
		$db = PearDatabase::getInstance();
		$adb = App\Db::getInstance();
		$productRecords = [];
		foreach ($data as $product) {
			if ($product['qtyparam'] == '1') {
				// If product was added with diffrent units (pcs not packs)
				// it will calculate it to packs
				if (isset($productRecords[$product['name']]) === false) {
					$productRecords[$product['name']] = Vtiger_Record_Model::getCleanInstance('Products');
					$productRecords[$product['name']] = Vtiger_Record_Model::getInstanceById($product['name']);
				}
				$qtyPerUnit = $productRecords[$product['name']]->get('qty_per_unit');
				$productQty = $product['qty'] / $qtyPerUnit;
				$productQty = round($productQty, 3, PHP_ROUND_HALF_UP);
			} else {
				$productQty = $product['qty'];
			}
			$qtyInStock[$product['name']] += $productQty;
		}
		$operator = self::getOperator($moduleName, $action);
		$qty = '(qtyinstock ' . $operator . ' ?)';

		// Update qtyinstock in Products
		$params = [];
		$query = 'UPDATE vtiger_products SET qtyinstock = CASE ';
		foreach ($qtyInStock as $ID => $value) {
			$query .= ' WHEN productid = ? THEN ' . $qty;
			array_push($params, $ID, $value);
		}
		$query .= ' END WHERE productid IN (' . $db->generateQuestionMarks(array_keys($qtyInStock)) . ')';
		$db->pquery($query, array_merge($params, array_keys($qtyInStock)));

		// Saving the amount of product in stock.
		$referenceInfo = Vtiger_Relation_Model::getReferenceTableInfo('Products', 'IStorages');
		$query = 'SELECT %s,qtyinstock FROM %s  WHERE %s = ? AND %s IN (%s);';
		$query = sprintf($query, $referenceInfo['rel'], $referenceInfo['table'], $referenceInfo['base'], $referenceInfo['rel'], $db->generateQuestionMarks(array_keys($qtyInStock)));
		$result = $db->pquery($query, array_merge([$storageId], array_keys($qtyInStock)));
		$relData = $result->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_COLUMN);
		foreach ($qtyInStock as $ID => $value) {
			if (array_key_exists($ID, $relData)) {
				$adb->createCommand()->update($referenceInfo['table'], [
					'qtyinstock' => new yii\db\Expression('qtyinstock ' . $operator . ' ' . $value)
					], [$referenceInfo['base'] => $storageId, $referenceInfo['rel'] => $ID])->execute();
			} else {
				$adb->createCommand()->insert($referenceInfo['table'], [
					$referenceInfo['base'] => $storageId,
					$referenceInfo['rel'] => $ID,
					'qtyinstock' => $operator == '+' ? $value : $operator . $value
				])->execute();
			}
		}
	}

	public static function getAllQtyInStocks()
	{
		$db = PearDatabase::getInstance();
		$sumProduct = [];
		$sumProductInStorage = [];
		foreach (self::$modulesToCalculate as $type => $modules) {
			$sql = [];
			foreach ($modules as $moduleName) {
				if (\App\Module::isModuleActive($moduleName) === false) {
					continue;
				}
				$inventoryTableName = Vtiger_InventoryField_Model::getInstance($moduleName)->getTableName();
				$focus = CRMEntity::getInstance($moduleName);
				$sql[] = sprintf('SELECT %s.name AS productid, %s.storageid AS storageid,  SUM( DISTINCT %s.qty) AS p_sum FROM  %s LEFT JOIN (%s LEFT JOIN vtiger_crmentity AS cr ON cr.crmid = %s.name) ON %s.%s = %s.id LEFT JOIN vtiger_crmentity ON %s.%s = vtiger_crmentity.`crmid` WHERE vtiger_crmentity.`deleted` = 0 && cr.`deleted` = 0 && %s.%s_status = "PLL_ACCEPTED" GROUP BY productid, storageid', $inventoryTableName, $focus->table_name, $inventoryTableName, $focus->table_name, $inventoryTableName, $inventoryTableName, $focus->table_name, $focus->table_index, $inventoryTableName, $focus->table_name, $focus->table_index, $focus->table_name, strtolower($moduleName));
			}
			if (!empty($sql)) {
				$result = $db->query(implode(' UNION ALL ', $sql));
				if ($type == 'add') {
					while ($row = $db->getRow($result)) {
						$sumProduct[$row['productid']] += $row['p_sum'];
						$sumProductInStorage[$row['storageid']][$row['productid']] += $row['p_sum'];
					}
				} else {
					while ($row = $db->getRow($result)) {
						$sumProduct[$row['productid']] -= $row['p_sum'];
						$sumProductInStorage[$row['storageid']][$row['productid']] -= $row['p_sum'];
					}
				}
			}
		}
		return [$sumProduct, $sumProductInStorage];
	}

	public static function setQtyInStocks($stock)
	{
		$db = PearDatabase::getInstance();
		list($sumProduct, $sumProductInStorage) = $stock;
		if (empty($sumProduct)) {
			$db->update('vtiger_products', ['qtyinstock' => 0]);
		} else {
			$query = 'UPDATE vtiger_products SET qtyinstock = CASE ';
			$params = [];
			foreach ($sumProduct as $ID => $value) {
				$query .= ' WHEN `productid` = ? THEN ?';
				array_push($params, $ID, $value);
			}
			$query .= ' END WHERE `productid` IN (' . $db->generateQuestionMarks(array_keys($sumProduct)) . ')';
			$db->pquery($query, array_merge($params, array_keys($sumProduct)));
		}
		$referenceInfo = Vtiger_Relation_Model::getReferenceTableInfo('Products', 'IStorages');
		$db->delete($referenceInfo['table']);
		if (!empty($sumProductInStorage)) {
			foreach ($sumProductInStorage as $ID => $values) {
				foreach ($values as $productId => $value) {
					$db->insert($referenceInfo['table'], ['crmid' => $ID, 'relcrmid' => $productId, 'qtyinstock' => $value]);
				}
			}
		}
	}
}
