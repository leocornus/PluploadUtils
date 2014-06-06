<?php
# Alert the user that this is not a valid access point to MediaWiki 
# if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
    echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/PluploadUtils/PluploadUtils.php" );
EOT;
    exit( 1 );
}
 
$wgExtensionCredits[ 'specialpage' ][] = array(
    'path' => __FILE__,
    'name' => 'PluploadUtils',
    'author' => 'Sean Chen',
    'url' => 'https://github.com/leocornus/PluploadUtils',
    'descriptionmsg' => 'utilities for using Plupload in MediaWiki sites',
    'version' => '0.1.0',
);

# create the special plupload upload call back page. 
# Location of the SpecialMyExtension class (Tell MediaWiki to load this file)
$wgAutoloadClasses[ 'SpecialPlupload' ] = 
    __DIR__ . '/SpecialPlupload.php'; 
# Tell MediaWiki about the new special page and its class name
$wgSpecialPages[ 'SpecialPlupload' ] = 'SpecialPlupload';
# set the group to other for the special page.
$wgSpecialPageGroups[ 'PluploadUtils' ] = 'other';


# Location of a messages file (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles[ 'PluploadUtils' ] = 
    __DIR__ . '/PluploadUtils.i18n.php'; 
# Location of an aliases file (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles[ 'PluploadUtilsAlias' ] = 
    __DIR__ . '/PluploadUtils.alias.php'; 
