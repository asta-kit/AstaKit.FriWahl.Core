<?php
namespace AstaKit\FriWahl\Core\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * A group of votings that is made available to voters based on a discriminator. Each voter can access at maximum
 * one voting.
 *
 * This can be used to e.g. implement a voting based on departments with different lists for each department.
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 *
 * @Flow\Entity
 */
class VotingGroup extends Voting {

	/**
	 * The votings that are part of this group.
	 *
	 * @var Collection<Voting>
	 *
	 * This is mapped as many-to-many though it is a one-to-many relation in fact (each voting may only be part of
	 * one voting group) because Doctrine currently only supports using an MM-table when having many-to-many relations.
	 * We need the MM table because we do not want to explicitly store the group in the voting (making this effectively
	 * a unidirectional relation).
	 * The additional unique constraint makes sure that a voting is only part of one group at a time.
	 * @ORM\ManyToMany
	 * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
	 */
	protected $votings;

	/**
	 * Returns the type of this record.
	 *
	 * @return string
	 */
	public function getType() {
		return 'VotingGroup';
	}

}
