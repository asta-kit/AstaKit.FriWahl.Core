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

	/**
	 * If the voter has one of the discriminator values of this voting, *allow* participation in the voting
	 */
	const DISCRIMINATION_MODE_ALLOW = 1;
	/**
	 * If the voter has one of the discriminator values of this voting, *deny* participation in the voting
	 */
	const DISCRIMINATION_MODE_DENY = 2;

} 