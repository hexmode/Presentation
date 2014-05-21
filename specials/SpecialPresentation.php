<?php
/**
 * Presentation SpecialPage
 *
 * @file
 * @ingroup Extensions
 */

class SpecialPresentation extends SpecialPage {
	public function __construct() {
		parent::__construct( 'Presetation' );
	}

	/**
	 * Shows the page to the user.
	 * @param string $sub: The subpage string argument (if any).
	 */
	public function execute( $sub ) {
		$out = $this->getOutput();

		$out->setPageTitle( $this->msg( 'presentation-title' ) );

		$out->addWikiMsg( 'presentation-intro' );
	}
}
