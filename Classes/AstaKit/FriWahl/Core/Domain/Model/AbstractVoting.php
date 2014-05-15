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
abstract class AbstractVoting implements Voting {
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
	 * @param Election $election
	 * @param string $name
	 */
	public function __construct(Election $election, $name) {
		$this->election = $election;
		$this->name = $name;

		$this->election->addVoting($this);
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

}
