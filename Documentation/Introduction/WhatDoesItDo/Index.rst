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

This extension provides an API for using Plupload within your own extensions in order to upload even big files.
When using the :ref:`chunked upload feature <chunked-upload-feature>` even uploads bigger than your PHP limits are possible!

Basically I've implemented an eID / middleware to handle file uploads managed by simple configuration records.
You are able to implement whatever is possible with Plupload by using TypoScript and template files.

The extension additionally provides a simple FE plugin to upload files with an nice jQuery widget which uses the best
technology available on client side.

An API example to send big files by mail is available in TER, search for EXT:mailfiles.
There is an integration with EXT:powermail too, search for EXT:pluploadfe_powermail.


What is Plupload?
"""""""""""""""""

Cite from `http://www.plupload.com/ <http://www.plupload.com/>`_ :

“Plupload allows you to upload files using HTML5 Silverlight, Flash or normal forms,
providing some unique features such as upload progress, image resizing and chunked uploads.

The developers of `TinyMCE <http://tinymce.moxiecode.com/>`_ brings you Plupload,
a highly usable upload handler for your Content Management Systems or similar.

Plupload is currently separated into a `Core API <http://www.plupload.com/plupload/docs/api/index.html>`_ and a
`jQuery upload queue widget <http://www.plupload.com/example_queuewidget.php>`_ this enables you to either use it out of the box
or write your own `custom implementation <http://www.plupload.com/example_custom.php>`_ .”


What others say
"""""""""""""""

Installation guide by Jochen Weiland can be found here:
https://jweiland.net/typo3-cms/showcase/pluploadfe.html and https://www.youtube.com/watch?v=VfVNMp7km70

Wolfgang Wagner did an introduction of this extension in his Twitch channel, take a look here:
https://www.twitch.tv/videos/1997781074 or https://youtu.be/uzh8jgCqI5g?si=NS1JgluKexX3Fpxi&t=873
