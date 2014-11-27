

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

It should be possible to use this feature but its not fully tested
yet. I recommend not to use too small chunks as each upload operation
is performance hungry (DB request, FE user check, etc.).

Please give feedback if you test this feature of Plupload with this
TYPO3 extension.

Please note: MIME type check is not available when using chunked
uploads because MIME type is always “application/octet-stream”.

