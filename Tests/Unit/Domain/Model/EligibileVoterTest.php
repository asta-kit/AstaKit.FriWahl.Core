<?php
namespace AstaKit\FriWahl\Core\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */
use AstaKit\FriWahl\Core\Domain\Model\EligibleVoter;
use TYPO3\Flow\Tests\UnitTestCase;


/**
 * Test case for the eligible voters class
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 */
class EligibileVoterTest extends UnitTestCase {

	/**
	 * @test
	 */
	public function addDiscriminatorAddsDiscriminatorToList() {
		$voter = new EligibleVoter('John', 'Doe');
		$voter->addDiscriminator('foo', 'bar');

		$this->assertCount(1, $voter->getDiscriminators());
	}

	/**
	 * @test
	 */
	public function discriminatorCanBeFetchedByIdentifier() {
		$voter = new EligibleVoter('John', 'Doe');
		$voter->addDiscriminator('foo', 'bar');

		$this->assertNotNull($voter->getDiscriminator('foo'));
	}

	/**
	 * @test
	 */
	public function hasDiscriminatorReturnsFalseIfNoDiscriminatorHasBeenAdded() {
		$voter = new EligibleVoter('John', 'Doe');

		$this->assertFalse($voter->hasDiscriminator('foo'));
	}

	/**
	 * @test
	 */
	public function hasDiscriminatorReturnsTrueAfterDiscriminatorHasBeenAdded() {
		$voter = new EligibleVoter('John', 'Doe');
		$voter->addDiscriminator('foo', 'bar');

		$this->assertTrue($voter->hasDiscriminator('foo'));
	}

	/**
	 * @test
	 */
	public function hasDiscriminatorReturnsFalseForOtherIdentifiersAfterDiscriminatorHasBeenAdded() {
		$voter = new EligibleVoter('John', 'Doe');
		$voter->addDiscriminator('foo', 'bar');

		$this->assertFalse($voter->hasDiscriminator('baz'));
	}
}
