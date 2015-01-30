TemplateData Story

TemplateData_ extension for MediaWiki_ is try to save a 
template information in JSON format so
VisualEditor_ could easily retrive them and present them
while editor is using this template in a page.

Dependences
-----------

- TemplateData extension
- TemplateDataEditor_ GUI?
- `TemplateData Generator`_

Questions
---------

- What is the editor GUI?
- How to install and set up the TemplateData Editor?

Some Samples
------------

here is a quick JSON to define on parameter ticket_id::

  <templatedata>
  {
      "description": "ticket reference template",
      "params" : {
          "ticket_id": {
              "label" : "Ticket ID",
              "type" : "number",
              "required" : true,
              "description" : "Please specify the ticket ID"
          }
      }
  }
  </templatedata>

.. _TemplateData: https://www.mediawiki.org/wiki/Extension:TemplateData
.. _TemplateData Generator: http://tools.wikimedia.pl/~mlazowik/templatedata/
.. _TemplateDataEditor: http://en.wikipedia.org/wiki/User:NicoV/TemplateDataEditor 
