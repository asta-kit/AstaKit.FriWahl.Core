<?php
namespace AstaKit\FriWahl\Core\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use AstaKit\FriWahl\Core\Environment\SystemEnvironment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;


/**
 * Model for an election.
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 *
 * @Flow\Entity
 */
class Election {

	/**
	 * The name of this election.
	 *
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * The date this election was created.
	 *
	 * @var \DateTime
	 */
	protected $created;

	/**
	 * The periods during which this election is active, i.e. voting is possible.
	 *
	 * @var Collection<ElectionPeriod>
	 * @ORM\OneToMany(mappedBy="election", cascade={"remove", "persist"})
	 */
	protected $periods = array();

	/**
	 * The voters allowed to vote in this election.
	 *
	 * @var Collection<EligibleVoter>
	 * @ORM\OneToMany(mappedBy="election")
	 * @Flow\Lazy
	 */
	protected $voters;

	/**
	 * @var Collection<BallotBox>
	 * @ORM\OneToMany(mappedBy="election")
	 */
	protected $ballotBoxes = array();

	/**
	 * If this is set, this election is treated as a test vote and can be used for the automated system tests.
	 * Otherwise most tests will
	 *
	 * @var bool
	 */
	protected $test = FALSE;

	/**
	 * The votings in this election.
	 *
	 * @var Collection<AbstractVoting>
	 * @ORM\OneToMany(mappedBy="election")
	 */
	protected $votings;

	/**
	 * @var SystemEnvironment
	 * @Flow\Inject
	 */
	protected $systemEnvironment;


	/**
	 * @param string $name The name of this election.
	 */
	public function __construct($name) {
		$this->name    = $name;
		$this->created = new \DateTime();

		$this->periods     = new ArrayCollection();
		$this->ballotBoxes = new ArrayCollection();
		$this->votings     = new ArrayCollection();
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param array $periods
	 */
	public function setPeriods($periods) {
		$this->periods = $periods;
	}

	/**
	 * Adds a period to this election.
	 *
	 * @param ElectionPeriod $period
	 */
	public function addPeriod(ElectionPeriod $period) {
		$this->periods->add($period);
	}

	/**
	 * @return array
	 */
	public function getPeriods() {
		return $this->periods;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $ballotBoxes
	 */
	public function setBallotBoxes($ballotBoxes) {
		$this->ballotBoxes = $ballotBoxes;
	}

	/**
	 * Adds a ballot box to this election.
	 *
	 * @param BallotBox $ballotBox
	 */
	public function addBallotBox(BallotBox $ballotBox) {
		$this->ballotBoxes->add($ballotBox);
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getBallotBoxes() {
		return $this->ballotBoxes;
	}

	/**
	 * @param boolean $test
	 */
	public function setTest($test) {
		$this->test = $test;
	}

	/**
	 * Returns TRUE if this election can be used as a test election, e.g. for manual or automated system tests.
	 *
	 * @return boolean
	 */
	public function isTest() {
		return $this->test;
	}

	/**
	 * @return boolean
	 */
	public function isActive() {
		$currentDate = $this->systemEnvironment->getCurrentDate();

		/** @var ElectionPeriod $period */
		foreach ($this->periods as $period) {
			if ($period->includes($currentDate)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Adds a voter to this election. Do not call this directly, create a new voter instead. The EligibleVoter
	 * constructor will then call this method with the newly created object.
	 *
	 * @param EligibleVoter $voter
	 */
	public function addVoter(EligibleVoter $voter) {
		$this->voters->add($voter);
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getVoters() {
		return $this->voters;
	}

	/**
	 * Adds a voting to this election.
	 *
	 * @param Voting $voting
	 */
	public function addVoting(Voting $voting) {
		$this->votings->add($voting);
	}

	/**
	 * Returns all votings for this election.
	 *
	 * @return Collection<Voting>
	 */
	public function getVotings() {
		return $this->votings;
	}

}
