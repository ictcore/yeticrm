<?php

/**
 * Action to get markers
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
class OpenStreetMap_GetRoute_Action extends Vtiger_BasicAjax_Action
{

	public function process(\App\Request $request)
	{
		$flon = $request->get('flon');
		$flat = $request->get('flat');
		$tlon = $request->get('tlon');
		$tlat = $request->get('tlat');
		$ilon = $request->get('ilon');
		$ilat = $request->get('ilat');

		$track = [];
		$startLat = $flat;
		$startLon = $flon;
		if (!empty($ilon)) {
			foreach ($ilon as $key => $tempLon) {
				if (!empty($tempLon)) {
					$endLon = $ilon[$key];
					$endLat = $ilat[$key];
					$tracks [] = [
						'startLat' => $startLat,
						'startLon' => $startLon,
						'endLat' => $endLat,
						'endLon' => $endLon
					];
					$startLat = $endLat;
					$startLon = $endLon;
				}
			}
		}
		$tracks [] = [
			'startLat' => $startLat,
			'startLon' => $startLon,
			'endLat' => $tlat,
			'endLon' => $tlon
		];
		$language = vglobal('default_language');
		$coordinates = [];
		$travel = 0;
		$description = '';
		$urlToRoute = AppConfig::module('OpenStreetMap', 'ADDRESS_TO_ROUTE');
		foreach ($tracks as $track) {
			$url = $urlToRoute . '?format=geojson&flat=' . $track['startLat'] . '&flon=' . $track['startLon'] . '&tlat=' . $track['endLat'] . '&tlon=' . $track['endLon'] . '&lang=' . $language . '&instructions=1';
			$response = Requests::get($url);
			$json = \App\Json::decode($response->body);
			$coordinates = array_merge($coordinates, $json['coordinates']);
			$description .= $json['properties']['description'];
			$travel = $travel + $json['properties']['traveltime'];
			$distance = $distance + $json['properties']['distance'];
		}
		$result = [
			'type' => 'LineString',
			'coordinates' => $coordinates,
			'properties' => [
				'description' => $description,
				'traveltime' => $travel,
				'distance' => $distance
			]
		];
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
}
