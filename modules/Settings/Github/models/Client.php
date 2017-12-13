<?php

/**
 * Client Model
 * @package YetiForce.Github
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */

/**
 * Class Settings_Github_Client_Model
 */
class Settings_Github_Client_Model
{

	/**
	 * Repository name
	 */
	const repository = 'YetiForceCRM';
	
	/**
	 * Owner repository
	 */
	const ownerRepository = 'YetiForceCompany';
	
	/**
	 * Address url to api
	 */
	const url = 'https://api.github.com';

	/**
	 * Id client
	 * @var string 
	 */
	private $clientId;
	
	/**
	 *
	 * @var type 
	 */
	private $clientToken;
	
	/**
	 * Username
	 * @var string 
	 */
	private $username;

	/**
	 * Function to set username
	 * @param string $name
	 */
	public function setUsername($name)
	{
		$this->username = $name;
	}

	/**
	 * Function to set client id
	 * @param string $id
	 */
	public function setClientId($id)
	{
		$this->clientId = $id;
	}

	/**
	 * Function to set token
	 * @param string $token
	 */
	public function setToken($token)
	{
		$this->clientToken = $token;
	}

	/**
	 * Function to get all issues
	 * @param int $numPage
	 * @param string $state
	 * @param string $author
	 * @return Settings_Github_Issues_Model[]
	 */
	public function getAllIssues($numPage, $state, $author = false)
	{
		$data['page'] = $numPage;
		$data['per_page'] = 20;
		$path = '/search/issues';
		$data['q'] = 'user:' . self::ownerRepository . ' repo:' . self::repository . " is:issue is:$state";
		if ($author) {
			$data['q'] .= " author:$this->username";
		}
		$issues = $this->doRequest($path, 'GET', $data, '200');
		if ($issues === false) {
			return false;
		}
		$issuesModel = [];
		foreach ($issues->items as $issue) {
			$issuesModel[] = Settings_Github_Issues_Model::getInstanceFromArray($issue);
		}
		Settings_Github_Issues_Model::$totalCount = $issues->total_count;
		return $issuesModel;
	}

	/**
	 * Function to create issue
	 * @param string $body
	 * @param string $title
	 * @return boolean|array
	 */
	public function createIssue($body, $title)
	{
		$path = '/repos/' . self::ownerRepository . '/' . self::repository . '/issues';
		$data['title'] = $title;
		$data['body'] = $body;
		$data = json_encode($data);
		return $this->doRequest($path, 'POST', $data, '201 OK');
	}

	/**
	 * Function to check autorization
	 * @return boolean
	 */
	public function isAuthorized()
	{
		if ((empty($this->clientId) || empty($this->clientToken))) {
			return false;
		}
		return true;
	}

	/**
	 * Function to get object
	 * @return \self
	 */
	public static function getInstance()
	{
		$instance = new self();
		$row = (new App\Db\Query())
				->select(['client_id', 'token', 'username'])
				->from('u_#__github')
				->createCommand()->queryOne();
		if (!empty($row)) {
			$instance->setClientId($row['client_id']);
			$instance->setToken(base64_decode($row['token']));
			$instance->setUsername($row['username']);
		}
		return $instance;
	}

	/**
	 * Function to save key
	 * @return int
	 */
	public function saveKeys()
	{
		$clientToken = base64_encode($this->clientToken);
		$params = ['client_id' => $this->clientId,
			'token' => $clientToken,
			'username' => $this->username];
		return App\Db::getInstance()->createCommand()->update('u_#__github', $params)->execute();
	}

	/**
	 * Function to check token
	 * @return boolean
	 */
	public function checkToken()
	{
		$data['access_token'] = $this->clientToken;
		$userInfo = $this->doRequest('/user', 'GET', $data, '200');
		if (!(empty($userInfo->login) || empty($this->username))) {
			if ($userInfo->login == $this->username) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Function to get data from github.com
	 * @param string $url
	 * @param string $method
	 * @param array $data
	 * @param string $status
	 * @return boolean|array
	 */
	private function doRequest($url, $method, $data = [], $status)
	{
		$url = self::url . $url;
		$options = [];
		if ($this->isAuthorized()) {
			$options['auth'] =  [$this->clientId, $this->clientToken];
		}
		switch ($method) {
			case 'GET':
				$url .= '?' . http_build_query($data);
				$content = \Requests::get($url, [], $options);	
				break;

			case 'POST':
				$content = \Requests::post($url, [], $data, $options);
				break;
		}
		$code = $content->status_code;
		if ($code != $status) {
			return false;
		}
		return  App\Json::decode($content->body, App\Json::TYPE_OBJECT);
	}
}
