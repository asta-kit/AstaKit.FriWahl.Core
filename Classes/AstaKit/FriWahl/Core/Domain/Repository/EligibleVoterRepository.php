<?php
namespace AstaKit\FriWahl\Core\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;


/**
 * Repository for eligible voters.
 *
 * This only exists because otherwise Flow would not recognize the corresponding entity as an aggregate root
 * and automatically remove it if objects with a relation to it are removed.
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 *
 * @Flow\Scope("singleton")
 */
class EligibleVoterRepository extends Repository {
}