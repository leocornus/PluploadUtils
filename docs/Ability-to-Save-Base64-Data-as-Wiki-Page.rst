`Release 0.1.1 <002-Release-0.1.1.rst>`_ > 
Ability to Save Base64 Data as Wiki Page

Design
------

- client send Base64_ data to server
-

Test Cases
----------

We will use d3js_ to draw some images and use canvas_ to generate
the Base64_ data.
Then jQuery_ post will send Base64_ data to server side.
The wiki special page will perform as the AJAX call back function,
which will save the Base64_ data as wiki file page.

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

.. _Base64: http://en.wikipedia.org/wiki/Base64
.. _canvas: http://www.w3schools.com/tags/ref_canvas.asp
