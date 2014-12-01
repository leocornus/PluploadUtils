<?php

class SpecialPlupload extends SpecialPage {

    function __construct() {
        parent::__construct('SpecialPlupload');
    }

    /**
     *
     * Theck this page about how to take over output 
     * in a Special page.
     * http://www.mediawiki.org/wiki/Taking_over_output_in_your_special_page
     */
    function execute( $par ) {

        $request = $this->getRequest();
        $action = $request->getText('action');
        if($action != 'plupload' && $action != 'base64') {
            // this is not a PLupload request, print out
            // help info and return.
            $this->printHelp();
            return;
        }
        // anonymous user verification.
        // anonymous user as 0 as id, we try to block anonymous user
        // to upload.
        $userId = $this->getUser()->getId();
        if($userId <= 0) {
            // this is anonymous user, check the settings for 
            // anonymous user.
            $result = array(
              "jsonrpc" => "2.0",
              "success" => false,
              "Error" => "You can not upload file to MediaWiki"
            );
            echo(json_encode($result));
            die();
        }

        // get ready wiki text.
        $pageText = $this->getPageText($request);
        $comment = $this->getPageComment($request);
        // watch the page by default.
        $watch = true;
        // get the desired destination file name.
        $fileName = $request->getText("wpDestFile");

        // this is a PLupload request, disable the MediaWiki output.
        global $wgOut;
        $wgOut->disable();

        switch($action) {
        case 'plupload':
            $result = $this->handlePlupload($request, $pageText, 
                                            $comment, $watch, 
                                            $fileName);
            break;
        case 'base64':
            $result = $this->handleBase64($request, $pageText, 
                                          $comment, $watch, 
                                          $fileName);
            break;
        }

        echo(json_encode($result));
        die();
    }

    /**
     * handle plupload request.
     */
    function handlePlupload($request, $pageText, $comment,
                            $watch=true, $fileName) {

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
              "fileName" => $fileName,
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

        return $result;
    }

    /**
     * handle Base64 request.
     */
    function handleBase64($request, $pageText, $comment, 
                          $watch=true, $fileName) {

        // get the base64 data: data:image/png;base64,
        // assume the base64Data has NO encoding prefix.
        $base64Data = $request->getText('base64Data');
        $fileFullPath = $this->dumpTemp(base64_decode($base64Data));
        //$fileFullPath = $this->dumpTemp($base64Data);
        // create local file.
        $file = wfLocalFile($fileName);
        $file->upload($fileFullPath, $comment, $pageText, 0, false,
                      false, $this->getUser());
        // preparing the result.
        $result = array(
          "jsonrpc" => "2.0",
          "success" => true,
          "fileName" => $fileName,
          "fileUrl" => $file->getCanonicalUrl(),
          "pageUrl" => $file->getTitle()->getFullUrl(),
          "mimeType" => $file->getMimeType()
        );

        return $result;
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
     * @param $contents
     * @return string
     */
    private function dumpTemp( $contents ) {

        $filename = tempnam( wfTempDir(), 'specialplupload' );
        file_put_contents( $filename, $contents );
        return $filename;
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

The following is a sample for '''multipart_params''' option 
from PLupload library. 
The '''action''' has to be '''plupload''' to trigger the process 
to save file as MediaWiki File.

<source lang="javascript">
    multipart_params = {
        action : "plupload" or "base64"
        base64Data : "binary file in base64 format"
        desc : "testing upload from plupload [[Testing]]",
        commment : "here is some comments",
        wpDestFile : 'The file name, which will be the page Title'
    }
</source>

Here are the definition for each param:

; action
: Only the action '''plupload''' will trigger the process to save file as the MediaWiki file.
; base64Data
: Only needed for action '''base64''', it will store the binary file in Base64 format.
; desc
: this param will save as the summary text for the MediaWiki file.
; comment
: this will be the comment for MediaWiki file update. 

The response will include the details information about 
each uploaded file and it will be in JSON format.
There is a sample of the response.

<source lang="javascript">
    response = {
        fileName : 'name of the uploaded file',
        fileUrl : 'the URL to the actural file',
        pageUrl : 'the URL to the wiki page associated to the file',
        mineType : 'mime type for the uploaded file'
    }
</source>
EOT;
        $output->addWikiText( $wikitext );
    }
}
