Ability to Save Base64 Data as Wiki Page

Design
------

- client send Base64_ data to server
-

Code Memo
---------

Here is how MediaWiki import Base64_ encoding data
(from file **includes/Import.php**)::

  /**
   * @param $contents
   * @return string
   */
  private function dumpTemp( $contents ) {
          $filename = tempnam( wfTempDir(), 'importupload' );
          file_put_contents( $filename, $contents );
          return $filename;
  }

