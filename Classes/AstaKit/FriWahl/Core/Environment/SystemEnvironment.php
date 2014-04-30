<?php
namespace AstaKit\FriWahl\Core\Environment;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;


/**
 * The system environment. This is used to abstract e.g. the current date and time to be able to simulate a different
 * date in tests.
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 *
 * @Flow\Scope("singleton")
 */
class SystemEnvironment {

	protected $currentDate;

	public function __construct() {
		$this->currentDate = new \DateTime();
	}

	/**
	 * Returns the current date and time.
	 *
	 * @return \DateTime
	 */
	public function getCurrentDate() {
		return $this->currentDate;
	}
}
