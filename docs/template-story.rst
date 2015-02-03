This story is about how to use template in MediaWiki pages.

How to use tag extension in a wiki template
-------------------------------------------

Here is a template to use the **<source>** tag from 
`SyntaxHighlight GeSHi Extension`_::

  {{#tag:source
  |{{{code_snippet}}}
  |lang={{{code_lang}}}
  |line="GESHI_FANCY_LINE_NUMBERS"
  |enclose="div"
  }}<noinclude>
  [[Category:Templates]]
  ==Usage==
  
  The simple way to add source code snippet to your wiki 
  page is using VisualEditor
  </noinclude>

.. _SyntaxHighlight GeSHi Extension: https://www.mediawiki.org/wiki/Extension:SyntaxHighlight_GeSHi
