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

The **enclose="div"** attribute will wrap those long code lines.

Using table in wiki template
----------------------------

The effecient way to use table in a wiki template is using wiki
markups.
Here is an example to set a table floating right and with width 30%::

  {| class="wikitable" style="float: {{{float|right}}}; width: 30%"
  |- style="background: blue"
  ! {{{caption|Most Recent Changes}}}
  |- style="background: red"
  | {{#tag:DynamicPageList|
  category = {{{category|My Category}}}
  count = {{{count|8}}}
  ordermethod = lastedit}}
  |}<noinclude>


.. _SyntaxHighlight GeSHi Extension: https://www.mediawiki.org/wiki/Extension:SyntaxHighlight_GeSHi
