<?php
namespace AstaKit\FriWahl\Core\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */


/**
 * A voting
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 */
interface Voting {

	public function getName();

	public function setName($name);

} 