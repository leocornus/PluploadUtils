<?php

class SpecialPlupload extends SpecialPage {

    function __construct() {

        parent::__construct('SpecialPlupload');
    }
    
    function execute( $par ) {

        $this->setHeaders();
        $this->outputHeader();

        $request = $this->getRequest();
        $output = $this->getOutput();

        # Get request data from, e.g.
        $param = $request->getText( 'param' );

        # Do stuff
        # ...
        $wikitext = 'Hello world!';
        $output->addWikiText( $wikitext );
        $output->addWikiText($this->getUser()->getEmail());
    }
}
