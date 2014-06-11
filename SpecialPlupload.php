<?php

class SpecialPlupload extends SpecialPage {

    function __construct() {
        parent::__construct('SpecialPlupload');
    }

    /**
     *
     * Theck this page about how to take over output in a Special page.
     * http://www.mediawiki.org/wiki/Taking_over_output_in_your_special_page
     */
    function execute( $par ) {

        $request = $this->getRequest();
        $action = $request->getText('action');
        if($action != 'plupload') {
            $this->printHelp();
            return;
        }

        global $wgOut;
        $wgOut->disable();

        $mUpload = UploadBase::createFromRequest($request);
        $mLocalFile = $mUpload->getLocalFile();
        $status = $mUpload->performUpload(
          "testing upload",
          "[[Category:OPSpedia Development]] [[Category:Screenshot]]",
          true, $this->getUser()
        );
        //$file = wfFindFile($mLocalFile->getName());

        $result = array(
          "jsonrpc" => "2.0",
          "desc" => $request->getText('desc'),
          "comment" => $request->getText('comment'),
          "request" => $request,
          "result" => $status,
          "name" => $mLocalFile->getName(),
          "source" => $mUpload->getSourceType(),
          "Title" => $mLocalFile->getTitle()
        );

        die(json_encode($result));
    }

    function printHelp() {

        $this->setHeaders();
        $this->outputHeader();

        $output = $this->getOutput();

        # provide the brief explain how to use this special page.
        $wikitext = <<<EOT
This is a special page to provide a simple way for PLupload 
client to save files as MediaWiki Files.

<source lang="javascript">
    multipart_params = {
        action : "plupload",
        desc : "testing upload from plupload",
        commment : "here is some comments"
    }
</source>
EOT;
        $output->addWikiText( $wikitext );
    }
}
