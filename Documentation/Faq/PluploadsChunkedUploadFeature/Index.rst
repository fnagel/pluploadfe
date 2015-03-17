

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


Plupload's chunked upload feature
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Since version 1.1.0 the chunked upload feature of plupload is officially supported.

See plupload documentation for more information: http://plupload.com/docs/Chunking

It's recommended not to use too small chunks as each upload operation
is expensive regarding performance (DB request, FE user check, etc.).
