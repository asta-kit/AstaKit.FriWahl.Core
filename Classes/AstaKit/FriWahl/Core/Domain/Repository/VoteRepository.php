<?php
namespace AstaKit\FriWahl\Core\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use AstaKit\FriWahl\Core\Domain\Model\Vote;
use AstaKit\FriWahl\Core\Domain\Model\Voting;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;


/**
 * Repository for votes.
 *
 * This only exists because otherwise Flow would not recognize the corresponding entity as an aggregate root
 * and automatically remove it if objects with a relation to it are removed.
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 *
 * @Flow\Scope("singleton")
 */
class VoteRepository extends Repository {

	/**
	 * Counts the queued votes for a given voting.
	 *
	 * @param Voting $voting
	 * @return int
	 */
	public function countQueuedByVoting(Voting $voting) {
		$query = $this->createQuery();

		return $query->matching(
			$query->logicalAnd(
				$query->equals('voting', $voting),
				$query->equals('status', Vote::STATUS_QUEUED)
			)
		)->count();
	}

	/**
	 * Counts the committed votes for a given voting.
	 *
	 * @param Voting $voting
	 * @return int
	 */
	public function countCommittedByVoting(Voting $voting) {
		$query = $this->createQuery();

		return $query->matching(
			$query->logicalAnd(
				$query->equals('voting', $voting),
				$query->equals('status', Vote::STATUS_COMMITTED)
			)
		)->count();
	}

}
