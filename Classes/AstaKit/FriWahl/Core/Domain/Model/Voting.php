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
	 * @var VotingAccessManager
	 * @Flow\Inject
	 */
	protected $votingAccessManager;


	/**
	 * @param Election $election
	 * @param string $name
	 */
	public function __construct(Election $election, $name) {
		$this->election = $election;
		$this->name = $name;

		$this->election->addVoting($this);
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

}
