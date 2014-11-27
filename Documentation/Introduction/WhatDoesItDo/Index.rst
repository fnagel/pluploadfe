

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


What does it do?
^^^^^^^^^^^^^^^^

This extension provides an API for using Plupload within your own
extensions. Basically I've implemented an eID to handle file uploads
managed by simple configuration records. You are able to implement
whatever is possible with Plupload by using TypoScript and template
files.

The extension additionally provides a simple FE plugin to upload files
with an nice jQuery UI widget which uses the best technology available
on clientside.

An API example to send big files by mail is available in TER, search
for EXT:mailfiles.


What is Plupload?
"""""""""""""""""

“Plupload allows you to upload files using HTML5 Silverlight, Flash or
normal forms, providing some unique features such as upload progress,
image resizing and chunked uploads.

The developers of `TinyMCE <http://tinymce.moxiecode.com/>`_ brings
you Plupload, a highly usable upload handler for your Content
Management Systems or similar. Plupload is currently separated into a
`Core API <http://www.plupload.com/plupload/docs/api/index.html>`_ and
a `jQuery upload queue widget
<http://www.plupload.com/example_queuewidget.php>`_ this enables you
to either use it out of the box or write your own `custom
implementation <http://www.plupload.com/example_custom.php>`_ .”

Cite from `http://www.plupload.com/ <http://www.plupload.com/>`_ .

