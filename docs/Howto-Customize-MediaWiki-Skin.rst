Quick Memo About How to Customize a MediaWiki_ Skin.

The easy way to customize a MediaWiki_ skin create new one based on
the default `Vector Skin`_.
Briefly, we will have the following steps:

#. Copy the whole **vector** skin folder to and new skin: **myskin**.
#. Copy the file **Vector.php** to **myskin** folder, 
   rename it to **MySkin.php**.
#. Update the **MySkin.php** to fix the MediaWiki_ skin class name
   and skin template class name.
#. Create **myskin.less** file in **component** folder, 
   this file will have the custom stylesheets.
#. load the **myskin.less** in file **screen.less**.
#. load the resources for **myskin** in one of the extension file.

`How to become a MediaWiki hacker`_ offers details info about
how to start MediaWiki_ development.

.. _MediaWiki: http://www.mediawiki.org
.. _Vector Skin: http://www.mediawiki.org/wiki/Skin:Vector
.. _How to become a MediaWiki hacker: http://www.mediawiki.org/wiki/How_to_become_a_MediaWiki_hacker
