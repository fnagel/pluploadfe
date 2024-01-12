

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

.. _chunked-upload-feature:

Plupload's chunked upload feature
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you need to upload very big files, please try using the `chunk_size` option.
Since version 1.1.0 of this extension the chunked upload feature of plupload is officially supported.

See plupload documentation for more information:
* http://plupload.com/docs/Chunking
* https://www.plupload.com/docs/v2/Options#chunk_size


It's recommended not to use too small chunks as each upload operation
is expensive regarding performance (DB request, FE user check, etc.).


**How to use it**

Enable the `chunk_size` option in your template:
https://github.com/fnagel/mailfiles/blob/fa7eb29683b5441eb827f358cec7ff035d9cb854/Resources/Private/Templates/template.html#L22C39-L22C41

Disable the `max_file_size` option in your template:
https://github.com/fnagel/mailfiles/blob/fa7eb29683b5441eb827f358cec7ff035d9cb854/Resources/Private/Templates/template.html#L32
