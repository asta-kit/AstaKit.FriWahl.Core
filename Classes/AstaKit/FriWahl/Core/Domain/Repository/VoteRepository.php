<?php
namespace AstaKit\FriWahl\Core\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use AstaKit\FriWahl\Core\Domain\Model\BallotBox;
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

	protected function countVotesByFieldAndStatus($field, $fieldValue, $status) {
		$query = $this->createQuery();

		return $query->matching(
			$query->logicalAnd(
				$query->equals($field, $fieldValue),
				$query->equals('status', $status)
			)
		)->count();
	}

	/**
	 * Counts the queued votes for a given voting.
	 *
	 * @param Voting $voting
	 * @return int
	 */
	public function countQueuedByVoting(Voting $voting) {
		return $this->countVotesByFieldAndStatus('voting', $voting, Vote::STATUS_QUEUED);
	}

	/**
	 * Counts the committed votes for a given voting.
	 *
	 * @param Voting $voting
	 * @return int
	 */
	public function countCommittedByVoting(Voting $voting) {
		return $this->countVotesByFieldAndStatus('voting', $voting, Vote::STATUS_COMMITTED);
	}

	/**
	 * Counts the queued votes for a given voting.
	 *
	 * @param BallotBox $ballotBox
	 * @return int
	 */
	public function countQueuedByBallotBox(BallotBox $ballotBox) {
		return $this->countVotesByFieldAndStatus('ballotBox', $ballotBox, Vote::STATUS_QUEUED);
	}

	/**
	 * Counts the committed votes for a given ballot box.
	 *
	 * @param BallotBox $ballotBox
	 * @return int
	 */
	public function countCommittedByBallotBox(BallotBox $ballotBox) {
		return $this->countVotesByFieldAndStatus('ballotBox', $ballotBox, Vote::STATUS_COMMITTED);
	}

}
