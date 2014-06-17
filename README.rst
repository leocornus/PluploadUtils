PluploadUtils
=============

PluploadUtils is a MediaWiki_ extention, which will
provide all kinds of utilities for using 
plupload_ in MediaWiki sites.

**Installation**

PluploadUtils could be installed as a regular MediaWiki_ extension.

- copy the PluploadUtils folder to **extensions** folder.
- add the following line to your **LocalSettions.php** file ::

    require_once( "$IP/extensions/PluploadUtils/PluploadUtils.php" );

Features
========

**SpecialPlupload**

**SpecialPlupload** is a MediaWiki_ Special Page to handle request
from plupload_ client on a MediaWiki_ site.
It will save the files uploaded from plupload_ Uploader as
MediaWiki_ Files.
Developers could set up the File description and comment through
the Uploader option **multipart_params**.
Here is an example::

  multipart_params : {
    action : "plupload",
    desc : "This will become description of the uploaded File",
    comment : "This is the comment"
  }

Check more details by visit the spcial page itself ::

  http://you.mediawik.site.com/wiki/Special:SpecialPlupload

License
=======

GNU General Public License Version 2

.. _plupload https://github.com/moxiecode/plupload
.. _MediaWiki http://www.mediawiki.org/
