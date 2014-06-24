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
            // this is not a PLupload request, print out
            // help info and return.
            $this->printHelp();
            return;
        }

        // this is a PLupload request, disable the MediaWiki output.
        global $wgOut;
        $wgOut->disable();

        // get ready wiki text.
        $pageText = $this->getPageText($request);
        $comment = $this->getPageComment($request);
        // watch the page by default.
        $watch = true;
        // get the desired destination file name.
        $fileName = $request->getText("wpDestFile");

        $mUpload = UploadBase::createFromRequest($request);

        // user verification! using the UploadBase 
        $permit = $mUpload->verifyTitlePermissions($this->getUser());
        if($permit) {
            // user is allow to upload...

            $mLocalFile = $mUpload->getLocalFile();
            $status = $mUpload->performUpload(
              $comment, $pageText, $watch, $this->getUser());

            // TODO: need pass back the status / errors, so client
            // could handle differently based on the status...

            $result = array(
              "jsonrpc" => "2.0",
              "success" => true,
              "name" => $fileName,
              "fileUrl" => $mLocalFile->getCanonicalUrl(),
              "pageUrl" => $mLocalFile->getTitle()->getFullUrl(),
              "mimeType" => $mLocalFile->getMimeType(),
            );
        } else {
            // user is not allowed to upload! return error message.
            $result = array(
              "jsonrpc" => "2.0",
              "success" => false,
              "Error" => "You can not upload file to MediaWiki"
            );
        }

        die(json_encode($result));
    }

    /**
     * preparing the page text for this uploaded file.
     */
    function getPageText($request) {

        $pageText = $request->getText("desc");

        return $pageText;
    }

    /**
     * preparing the comment for this page change
     */
    function getPageComment($request) {

        $pageText = $request->getText("comment");

        return $pageText;
    }

    /**
     * print out the brief help information for how to use this
     * special page.
     */
    function printHelp() {

        $this->setHeaders();
        $this->outputHeader();

        $output = $this->getOutput();

        # provide the brief explain how to use this special page.
        $wikitext = <<<EOT
This is a special page to provide a simple way for PLupload 
client to save files as MediaWiki Files.

The following is a sample for '''multipart_params''' option from PLupload library. 
The '''action''' has to be '''plupload''' to trigger the process to save file as MediaWiki File.

<source lang="javascript">
    multipart_params = {
        action : "plupload",
        desc : "testing upload from plupload [[Testing]]",
        commment : "here is some comments"
    }
</source>

Here are the definition for each param:

; action
: Only the action '''plupload''' will trigger the process to save file as the MediaWiki file.
; desc
: this param will save as the summary text for the MediaWiki file.
; comment
: this will be the comment for MediaWiki file update. 
EOT;
        $output->addWikiText( $wikitext );
    }
}
