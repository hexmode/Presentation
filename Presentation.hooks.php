<?php
/**
 * Hooks for BoilerPlate extension
 *
 * @file
 * @ingroup Extensions
 */

class PresentationHooks {
	static function initialize() {
		global $wgParser;
		$wgParser->setHook( "presentation", "PresentationHooks::launchPresentation" );
	}

	static function launchPresentation( $paramstring, $params = array() ){
		global $wgTitle, $wgParser;

		$wgParser->disableCache();
                // FIXME: Need to handle this better
                if ( !$wgTitle ) {
                    error_log( "FIXME: No tittle object." );
                    return "<br><font color=red><b><em>FIXME:</em> No title object.</b></font>\n<hr>";
                }
		$title = $wgTitle->getText(); //only returns the title, not the namespace

		$slideNumber = 0;
		$notoc = "";
		$delimiter = ",";

		if ( !$paramstring || !trim($paramstring) ) {
			return "<br><font color=red><b>Please define at least one page to use this extention.</b></font>\n<hr>";
		}

		// set default then check for user supplied name...
		$name = "Wiki Presentation";
		if ( isset( $params['name'] ) ) {
			$name = $params['name'];
		}

		//disable toc per tag params
		if( isset( $params['notoc'] ) ) {
			$notoc = "__NOTOC__";
		}

		if( isset( $params['delimiter'] ) ){
			$delimiter = $params['delimiter'];
			//$delimiter = str_replace("\n",chr(13),$delimiter);
		}

		// clean up the string; replace whitespace with a single space
		$paramstring = trim( preg_replace( '@\s+@', " ", $paramstring ) );
		$slides = explode( $delimiter, $paramstring );

		// remove any blank array values
		foreach( $slides as $slide ){
			if( trim( $slide ) ) {
				$arr[] = trim( $slide );
			}
		}

		// cookie is set via back or forward arrows
		$cookie_name = str_replace( " ", "_" , "wiki_presentation_$title" );
		if( isset( $_COOKIE[$cookie_name] ) ){
			$slideNumber = $_COOKIE[$cookie_name];
		}

		// generate the Presentation class
		$cPresentation = new Presentation( $arr, $slideNumber, $name, $notoc );

		// dislay the presentation
		return $cPresentation->getHTML();
	}

}
