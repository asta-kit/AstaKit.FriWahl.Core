<?php
namespace AstaKit\FriWahl\Core\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use AstaKit\FriWahl\Core\Domain\Repository\BallotBoxRepository;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;


/**
 * A ballot box, used for collecting votes. Each instance of this class belongs to a physical ballot box.
 *
 * What is basically modelled here is a state machine, with different
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 *
 * @Flow\Entity
 */
class BallotBox {

	/**
	 * @var string
	 * @Flow\Identity
	 * @ORM\Id
	 * @ORM\Column(length=40)
	 */
	protected $identifier;

	/**
	 * The name of this ballot box.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * The group this ballot box belongs to.
	 *
	 * @var string
	 * @ORM\Column(name="boxgroup")
	 */
	protected $group = '';

	/**
	 * The election this ballot box belongs to.
	 *
	 * @var \AstaKit\FriWahl\Core\Domain\Model\Election
	 * @ORM\ManyToOne
	 */
	protected $election;

	/**
	 * The status of this ballot box.
	 *
	 * Possible state transitions are:
	 * - 0 -> 1, 10
	 * - 1 -> 2
	 * - 2 -> 3
	 * - 3 -> 2, 4
	 * - 4 -> 5
	 * - 5 -> 6
	 * - 6 -> 7, 8, 9
	 * - 7 -> 6
	 *
	 * Start state is 0
	 * End states are 8, 9, 10
	 *
	 * @var integer
	 */
	protected $status = self::STATUS_NEW;

	/** Box has been created and still is in custody of the election committee */
	const STATUS_NEW = 0;
	/** Box has been handed out */
	const STATUS_EMITTED = 1;
	/** Currently open, new votes are accepted */
	const STATUS_OPENED = 2;
	/** Closed, may be reopened */
	const STATUS_CLOSED = 3;
	/** Ballot box has been returned to election committee */
	const STATUS_RETURNED = 4;
	/** Ballot box is currently being counted */
	const STATUS_COUNTING = 5;
	/** Ballot box was counted, awaiting confirmation of results */
	const STATUS_COUNTED = 6;
	/** Ballot box is being counted again */
	const STATUS_RECOUNTING = 7;
	/** Counted and results are valid */
	const STATUS_VALID = 8;
	/** Counted and results are invalid, i.e. the whole ballot box is void. Results won't be used for final election
	 * results */
	const STATUS_VOID = 9;
	/** Ballot box has not been used */
	const STATUS_UNUSED = 10;

	/**
	 * @var BallotBoxRepository
	 * @Flow\Inject
	 */
	protected $ballotBoxRepository;

	/**
	 * @var string
	 * @ORM\Column(length=1000)
	 */
	protected $sshPublicKey;


	/**
	 * @param string $identifier
	 * @param string $name
	 * @param Election $election
	 */
	public function __construct($identifier, $name, Election $election) {
		$this->identifier = $identifier;
		$this->name     = $name;
		$this->election = $election;
		$this->election->addBallotBox($this);
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {
		return $this->identifier;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getGroup() {
		return $this->group;
	}

	/**
	 * @param string $group
	 * @return void
	 */
	public function setGroup($group) {
		$this->group = $group;
	}

	/**
	 * @return \AstaKit\FriWahl\Core\Domain\Model\Election
	 */
	public function getElection() {
		return $this->election;
	}

	/**
	 * Returns the status of this ballot box. See STATUS_* constants for possible values.
	 *
	 * @return int
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return Vote[]
	 */
	public function getQueuedVotes() {
		$pendingVotes = $this->ballotBoxRepository->findQueuedVotesForBallotBox($this);

		return $pendingVotes;
	}

	/**
	 * @param string $sshPublicKey
	 */
	public function setSshPublicKey($sshPublicKey) {
		$this->sshPublicKey = $sshPublicKey;
	}

	/**
	 * @return string
	 */
	public function getSshPublicKey() {
		return $this->sshPublicKey;
	}

}
