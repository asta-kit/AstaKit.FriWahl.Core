<?php
namespace AstaKit\FriWahl\Core\Tests\Unit\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AstaKit.FriWahl.Core".  *
 *                                                                        *
 *                                                                        */

use AstaKit\FriWahl\Core\Domain\Model\Election;
use AstaKit\FriWahl\Core\Domain\Model\EligibleVoter;
use TYPO3\Flow\Tests\UnitTestCase;


/**
 * Test case for the eligible voters class
 *
 * @author Andreas Wolf <andreas.wolf@usta.de>
 */
class EligibileVoterTest extends UnitTestCase {

	/**
	 * @return Election
	 */
	protected function getMockedElection() {
		return $this->getMock('AstaKit\FriWahl\Core\Domain\Model\Election', array(), array(), '', FALSE);
	}

	/**
	 * @return EligibleVoter
	 */
	protected function createVoterFixture() {
		return new EligibleVoter($this->getMockedElection(), 'John', 'Doe');
	}

	/**
	 * @test
	 */
	public function addDiscriminatorAddsDiscriminatorToList() {
		$voter = $this->createVoterFixture();
		$voter->addDiscriminator('foo', 'bar');

		$this->assertCount(1, $voter->getDiscriminators());
	}

	/**
	 * @test
	 */
	public function discriminatorCanBeFetchedByIdentifier() {
		$voter = $this->createVoterFixture();
		$voter->addDiscriminator('foo', 'bar');

		$this->assertNotNull($voter->getDiscriminator('foo'));
	}

	/**
	 * @test
	 */
	public function hasDiscriminatorReturnsFalseIfNoDiscriminatorHasBeenAdded() {
		$voter = $this->createVoterFixture();

		$this->assertFalse($voter->hasDiscriminator('foo'));
	}

	/**
	 * @test
	 */
	public function hasDiscriminatorReturnsTrueAfterDiscriminatorHasBeenAdded() {
		$voter = $this->createVoterFixture();
		$voter->addDiscriminator('foo', 'bar');

		$this->assertTrue($voter->hasDiscriminator('foo'));
	}

	/**
	 * @test
	 */
	public function hasDiscriminatorReturnsFalseForOtherIdentifiersAfterDiscriminatorHasBeenAdded() {
		$voter = $this->createVoterFixture();
		$voter->addDiscriminator('foo', 'bar');

		$this->assertFalse($voter->hasDiscriminator('baz'));
	}
}
