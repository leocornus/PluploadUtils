How to Debug a MediaWiki Site
=============================

MediaWiki_ offers comprehensive degugging and logging machanism.
There are a set of settings regarding debug and logging for
a MediaWiki_ site. The `MediaWiki Manual Configuration Settings`_
has a list of the available options.
Here are some common ways to debug a MediaWiki_ site.

**$wgShowDebug**

display debug data at the button of the main content area.

**$wgDebugLogFile**

This option is working with global function **wfDebug**.
The default value is empty string, which means disable the log file.
Exmple to use this option::

  # in LocalSettings.php
  $wgDebugLogFile = '/tmp/log/mw.log';

  # in your code,
  wfDebug('some logging message');

**$wgDebugLogGroups**

This option will set the log file by groups and is working 
with the global function **wfDebugLog($group, $message, $dest)**.
Example to use this option::

  # in LocalSettings.php
  $wgDebugLogGroup['My Extension'] = '/tmp/log/mw-myext.log';

  # in your extension.
  wfDebugLog('My Extension', 'debugging message');

**?debug=true**

This HTTP request param tell MediaWiki_ to show all js lib and 
stylesheets in separate files.
It will provide a very convenient way to debug a MediaWiki_ skin.

.. _MediaWiki: http://www.mediawiki.org/
.. _MediaWiki Manual Configuration Settings: http://www.mediawiki.org/wiki/Manual:Configuration_settings
