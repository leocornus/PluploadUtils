`Release 0.1.1 <002-Release-0.1.1.rst>`_ > 
Ability to Save Base64 Data as Wiki Page

- `Design`_
- `Test Cases`_
- `Save Text File to Wiki`_
- `Code Memo`_

Design
------

- client need get ready the Base64_ data. JavaScript function
  **btoa()** will creeate a Base64_ string from binary data.
- client send Base64_ data to server
- PHP function **base64_decode** to decode Base64_ data

Test Cases
----------

We will use d3js_ to draw some images and use canvas_ to generate
the Base64_ data.
Then jQuery_ post will send Base64_ data to server side.
The wiki special page will perform as the AJAX call back function,
which will save the Base64_ data as wiki file page.

Save Text File to Wiki
----------------------

Save a text file to wiki is vary easy by using the SpecialPlupload
page. Here is example::

  <input type="button" id="saveText" value="save text"/>
  
  <script type="text/javascript">
  jQuery(document).ready(function($) { 
    $("#saveText").on("click", function() {

      // get ready the text data. we are using JSON format as 
      // example. 
      var data = "{'name':'first name', 'age':'12'}";
      // base64 encoding function.
      var base64Data = btoa(data);
      var serial = Math.floor(Math.random() * 100000 + 1);
      // Here is URL to special page.
      var handler_url = '/wiki/Special:SpecialPlupload';
      var data = {
        'action' : 'base64',
        'desc' : "testing upload text from [[Category:Base64]]",
        'comment' : "from code, plupload",
        'wpDestFile' : 'json'  + serial + '.json',
        'base64Data' : base64Data
      };
      $.post(handler_url, data, function(response) {
  
          //console.log(response);
          var si = response.indexOf("{");
          var ei = response.lastIndexOf("}");
          var res = JSON.parse(response.substring(si, ei + 1));
          //console.log(res);
          if(res.success) {
              // redirect to the file wiki page
              // res.fileUrl has the URL to the file.
              window.location.href = res.pageUrl;
              //alert(res.pageUrl);
          } else {
              alert('You need Log in to save image on Wiki!');
          }
      });
    });
  });

Code Memo
---------

Here is how MediaWiki import Base64_ encoding data
(from file **includes/Import.php**)::

  $fileFullPath = $this->dumpTemp( base64_decode( $contents ) );

  /**
   * @param $contents
   * @return string
   */
  private function dumpTemp( $contents ) {
      $filename = tempnam( wfTempDir(), 'importupload' );
      file_put_contents( $filename, $contents );
      return $filename;
  }

Then we need use the method **upload** in the **LocalFile** class::

  $file = wfLocalFile('desired file name');
  $file->upload($fileFullPath, $comment, $pageText,
                $publishFlags = 0, $props = false, 
                $timestamp = false,
                $user = null);

JavaScript code examples::

  var text = "Some plain text here";
  // base64 encoding...
  var base64text = btoa(text);

.. _Base64: http://en.wikipedia.org/wiki/Base64
.. _canvas: http://www.w3schools.com/tags/ref_canvas.asp
.. _JavaScript Base64 encoding and decoding: https://developer.mozilla.org/en-US/docs/Web/API/WindowBase64/Base64_encoding_and_decoding
