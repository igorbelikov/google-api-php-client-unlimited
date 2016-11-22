<?php

use Psr\Http\Message\RequestInterface;

/**
 * @author Igor Belikov <ihor.belikov@gmail.com>
 */
class Google_Client_Multi_Exception extends Exception {}

class Google_Service_Multi extends Google_Service
{

}

/**
 * Google Client Wrapper for using multi project keys
 * @author Igor Belikov <ihor.belikov@gmail.com>
 */
class Google_Client_Multi extends Google_Client
{
	/**
	 * @var array
	 */
	private $multiConfig = array();

	/**
	 * @var string
	 */
	private $currentDeveloperKey = '';

	/**
	 * @var int
	 */
	private $currentDeveloperKeyIndex = 0;
	
	/**
	 * @param array $keys
	 * @return $this
	 */
	public function setKeys(array $keys)
	{
		$this->multiConfig['developerKeys'] = $keys;
		return $this;
	}

	/**
	 * @param array $config
	 * @return $this
	 */
	public function setMultiConfig(array $config)
	{
		$this->multiConfig = $config;
		return $this;
	}
	
	/**
	 * @return string
	 */
	private function getDeveloperKey()
	{
		return $this->currentDeveloperKey;
	}

	/**
	 * @return array
	 */
	private function getDeveloperKeys()
	{
		return $this->multiConfig['developerKeys'];
	}

	/**
	 * Set next "Developer Key" from config
	 * @return string
	 * @throws Google_Client_Multi_Exception
	 */
	private function setNextDeveloperKey()
	{
		if($this->currentDeveloperKey) {
			$this->currentDeveloperKeyIndex++;
		}
		$keys = $this->getDeveloperKeys();
		if(isset($keys[$this->currentDeveloperKeyIndex])) {
			$this->currentDeveloperKey = $keys[$this->currentDeveloperKeyIndex];
			$this->setDeveloperKey($this->currentDeveloperKey);
			return $this->currentDeveloperKey;
		} else {
			throw new Google_Client_Multi_Exception("No more keys :|");
		}
	}

	/**
	 * Prepare client
	 * @return $this
	 */
	public function prepareMulti()
	{
		$this->setNextDeveloperKey();
		return $this;
	}

	/**
	 * @override
	 * @param RequestInterface $request
	 * @param null $expectedClass
	 * @return object
	 * @throws Google_Client_Multi_Exception
	 * @throws Google_Service_Exception
	 */
	public function execute($request, $expectedClass = null)
	{
		try {
			$result = parent::execute($request, $expectedClass);
		} catch(Google_Service_Exception $e) {
			$errors = $e->getErrors();
			if($e->getCode() == 403 && isset($errors[0]['reason']) && $errors[0]['reason'] == 'dailyLimitExceeded') {
				$request->setQueryParam('key', $this->setNextDeveloperKey());
				$result = $this->execute($request);
			} else {
				throw $e;
			}
		}
		return $result;
	}
}