How to tune up MediaWiki installation...

There are different facts to tune up MediaWiki sites:

- Database
- WebServer
- Cache
- PHP

The `MediaWiki Manual Performance tuning`_ has many details and
references.

here are some banchmarking tools can help evaluate the effects of 
performance tuning.

- PageSpeed_ from Google
- ab_ from Apache
- siege_ an HTTP load testing and benchmarking utility.

The `MediaWiki Manual Cache`_ has all details bout set up 
cache for MediaWiki sites.

Varnish
-------

Varnish_ tuning looks simple and easy to boost performance...
But Varnish_ only helps none-logged in users.
Logged in users requests normally configured by-pass the
Varnish_ cache.

Memcached
---------

Memcached_ suppose help lighten the load on database servers by
caching data and objects in memory. 
Memcached_ has been supported in MediaWiki since v1.1.
It will help all kinds of users: logged in and none-logged in.

Resources
---------

`Ilmari Karonen's Performance Tuning`_ page has some interesting
tricks about tune up MediaWiki performance.
Set the **maxage** for resources load by the MediaWiki resource
loader.
The variable **$wgREsourceLoaderMaxage** will allow you to tweak
the lifetime of those resources.
Here is an example::

  // increase the maxage for un versioned resources.
  $wgResourceLoaderMaxage = array(
    'versioned' => array(
      'server' => 30 * 24 * 60 * 60,
      'client' => 30 * 24 * 60 * 60, // 30 days
    ),
    'unversioned' => array(
      'server' => 30 * 24 * 60 * 60,
      'client' => 30 * 24 * 60 * 60, // 30 days
    )
  );

The better way will be provide the proper version number for all
resources used by your skin.

APC or OPcache
--------------

PHP bytecode caching solutions.

OPcache is include in PHP 5.5.0 and later. It recommended by MediaWiki.

InnoDB tuning
--------------

Here are some questions:

- How to using InnoDB for MediaWiki?
- How to config InnoDB?
- What's the best settings for **innodb_buffer_pool**?

The value of **innodb_buffer_pool_size** seems a very import setting.
The value of **table_cache** is another one we can tweak.

`MariaDB Tuning Story <https://github.com/leocornus/leocornus.buildout.cfgrepo/blob/master/sample/db/mariadb-tuning-story.rst>`_ has more details list of options for InnoDB.

MariaDB
-------

MySQLTuner_ is a very useful tool to check the health status of
your MySQL database server.

- MediaWiki Maintenance file **compressOld.php** will remove
  unnessary tables from database.

Questions
---------

**What does pending mean in Chrome inspector**

Pending in Chrome inspector tells that the file has yet to 
be downloaded from the network, and Chrome is making a request
and trying to download it.

TODO
----

Setup a benchmark tool might be our first step!
Setup a benchmark as a service of WordPress...

.. _MediaWiki Manual Performance tuning: http://www.mediawiki.org/wiki/Manual:Performance_tuning
.. _Ilmari Karonen's Performance Tuning: http://www.mediawiki.org/wiki/User:Ilmari_Karonen/Performance_tuning
.. _MediaWiki Manual Cache: http://www.mediawiki.org/wiki/Manual:Cache
.. _PageSpeed: https://developers.google.com/speed/pagespeed/
.. _ab: https://httpd.apache.org/docs/2.2/programs/ab.html
.. _Varnish: https://www.varnish-cache.org/
.. _Memcached: http://memcached.org/
.. _Manual Memcached: https://www.mediawiki.org/wiki/Memcached
.. _siege: http://www.joedog.org/siege-home/
.. _MySQLTuner: https://github.com/major/MySQLTuner-perl
