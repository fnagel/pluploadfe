

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


FE Plugin wont work
^^^^^^^^^^^^^^^^^^^

As `Plupload's jQuery UI Widget <http://www.plupload.com/punbb/viewtopic.php?id=422>`_ needs jQuery,
jQuery UI and a few other CSS and JS files.

Using multiple JS frameworks or multiple versions of jQuery could cause errors.
Please note that other TYPO3 Extensions may include JS files automatically.

Following best practice you should make sure to use only one JS framework and not to use multiple versions like
jQuery 1.5 and jQuery 1.7. Another solution could be fallback mechanisms like jQuery's noConflict option.
This is not recommended.

**Please note**
It's not needed to use jQuery at all in order to make use of Plupload.
Only the Plupload jQuery UI Widget uses jQuery, the Plupload Core is written in native JS.
See the `documentation <#http://www.plupload.com/documentation.php>`_ for more info.

