<?php
namespace AstaKit\FriWahl\Core\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use AstaKit\FriWahl\Core\Security\Voting\VotingAccessManager;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;


/**
 * Abstract base class for votings.
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 *
 * @Flow\Entity
 * @ORM\Table(name="astakit_friwahl_core_domain_model_voting")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class Voting {

	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * @var Election
	 * @ORM\ManyToOne(inversedBy="votings")
	 */
	protected $election;

	/**
	 * The discriminator used to determine if a voter may participate in this voting.
	 *
	 * @var string
	 */
	protected $discriminator = '';

	/**
	 * The values used to allow/deny voting based on the configured discrimination mode.
	 *
	 * @var array
	 */
	protected $discriminatorValues = array();

	/**
	 * If participation in this voting should be allowed or denied based on the discriminator values.
	 *
	 * @var integer
	 */
	protected $discriminationMode = self::DISCRIMINATION_MODE_ALLOW;

	const DISCRIMINATION_MODE_ALLOW = 1;
	const DISCRIMINATION_MODE_DENY = 2;

	/**
	 * The group this voting belongs to.
	 *
	 * If this is set, $election must be NULL (the relation to the election is implicitly defined via the group then).
	 *
	 * @var VotingGroup
	 * @ORM\ManyToOne(inversedBy="votings")
	 * @ORM\Column(name="votinggroup")
	 * NOTE: This field should be named $group, but currently Doctrine/Flow do not support naming a relation column
	 * different than the field (and "group" is a reserved SQL keyword).
	 */
	protected $votingGroup;

	/**
	 * @var VotingAccessManager
	 * @Flow\Inject
	 */
	protected $votingAccessManager;


	/**
	 * @param VotingsContainer $container The container (Election or VotingGroup) this voting belongs to
	 * @param string $name
	 */
	public function __construct(VotingsContainer $container, $name) {
		if ($container instanceof VotingGroup) {
			$this->votingGroup = $container;
		} else {
			$this->election = $container;
		}
		$this->name = $name;

		$this->election->addVoting($this);
	}

	/**
	 * @return \AstaKit\FriWahl\Core\Domain\Model\Election
	 */
	public function getElection() {
		return $this->election;
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
	 * Checks if the given voter may participate (vote) in this voting. The check is deferred to the voting access
	 * manager, which holds instances of all defined voters.
	 *
	 * @param EligibleVoter $voter
	 * @return bool
	 */
	public function isAllowedToParticipate(EligibleVoter $voter) {
		return $this->votingAccessManager->mayParticipate($voter, $this);
	}

	/**
	 * @param string $discriminator
	 */
	public function setDiscriminator($discriminator) {
		$this->discriminator = $discriminator;
	}

	/**
	 * @return string
	 */
	public function getDiscriminator() {
		return $this->discriminator;
	}

	/**
	 * @param array $discriminatorValues
	 */
	public function setDiscriminatorValues($discriminatorValues) {
		$this->discriminatorValues = $discriminatorValues;
	}

	/**
	 * @return array
	 */
	public function getDiscriminatorValues() {
		return $this->discriminatorValues;
	}

	/**
	 * @param int $discriminationMode
	 */
	public function setDiscriminationMode($discriminationMode) {
		$this->discriminationMode = $discriminationMode;
	}

	/**
	 * @return int
	 */
	public function getDiscriminationMode() {
		return $this->discriminationMode;
	}

	/**
	 * @param \AstaKit\FriWahl\Core\Domain\Model\VotingGroup $group
	 */
	public function setGroup($group) {
		$this->votingGroup = $group;
	}

	/**
	 * @return \AstaKit\FriWahl\Core\Domain\Model\VotingGroup
	 */
	public function getGroup() {
		return $this->votingGroup;
	}

}
