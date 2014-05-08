<?php
namespace AstaKit\FriWahl\Core\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A person who is able to vote in an election. The right to vote might be limited to certain votings, or a person
 * might be excluded from a voting for several reasons.
 *
 * In addition to the name, several configurable discriminators can be stored with a voter. These can be used to record
 * e.g. the group of voters a person belongs to, the matriculation number, the department where they can vote, or
 * their sex or nationality (to realize sex/nationality based votings for minority representations).
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 *
 * @Flow\Entity
 */
class EligibleVoter {

	/**
	 * The voter's given name.
	 *
	 * @var string
	 * @ORM\Column(length=40)
	 */
	protected $givenName;

	/**
	 * The voter's family name.
	 *
	 * @var string
	 * @ORM\Column(length=40)
	 */
	protected $familyName;

	/**
	 * Special properties of this user, e.g. the matriculation number, sex, nationality, field of study or department.
	 *
	 * @var Collection<\AstaKit\FriWahl\Core\Domain\Model\VoterDiscriminator>
	 * @ORM\OneToMany(mappedBy="voter", indexBy="identifier", cascade={"persist", "remove"})
	 */
	protected $discriminators;


	/**
	 * @param string $givenName
	 * @param string $familyName
	 */
	public function __construct($givenName, $familyName) {
		$this->givenName = $givenName;
		$this->familyName = $familyName;

		$this->discriminators = new ArrayCollection();
	}

	/**
	 * @return string
	 */
	public function getGivenName() {
		return $this->givenName;
	}

	/**
	 * @return string
	 */
	public function getFamilyName() {
		return $this->familyName;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->givenName . ' ' . $this->familyName;
	}

	/**
	 * Adds a discriminator for this voter.
	 *
	 * @param string $identifier
	 * @param string $value
	 */
	public function addDiscriminator($identifier, $value) {
		$discriminator = new VoterDiscriminator($this, $identifier, $value);

		$this->discriminators->set($identifier, $discriminator);
	}

	/**
	 * Returns the discriminator with the given identifier, if present.
	 *
	 * @param string $identifier
	 * @return VoterDiscriminator|null
	 */
	public function getDiscriminator($identifier) {
		/**
		 * We use the Doctrine feature of using a property of the object as the key for the collection (indexBy column
		 * property).
		 * However, this currently (2014-05) is not supported natively by Flow and requires a custom patch. See
		 * http://forge.typo3.org/issues/44740 for its current status.
		 *
		 * See the test getDiscriminatorReturnsCorrectObjectAfterVoterHasBeenPersistedAndRestored()
		 */
		return $this->discriminators->get($identifier);
	}

	/**
	 * Checks if this voter has a discriminator with the given identifier.
	 *
	 * @param string $identifier
	 * @return bool
	 */
	public function hasDiscriminator($identifier) {
		return $this->getDiscriminator($identifier) !== NULL;
	}

	/**
	 * The discriminators for this voter.
	 *
	 * @return \Doctrine\Common\Collections\Collection<Discriminator>
	 */
	public function getDiscriminators() {
		return $this->discriminators;
	}

}
