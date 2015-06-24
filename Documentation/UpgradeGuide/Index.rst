

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



Updade Guide
------------

.. only:: html

	.. contents:: Within this page
		:local:
		:depth: 3



Upgrade to 1.1.0
^^^^^^^^^^^^^^^^

Extension is now compatible with TYPO3 CMS 7.x.
You need to clear the cache in backend after upgrading.



Upgrade to 1.0.0
^^^^^^^^^^^^^^^^

Add the new static TypoScript configuration to your TS template.
Version 1.0.0 comes with Plupload 2.1.2 so make sure to update your
template file if needed.

You need to make sure jQuery is available on your website.
It's no longer included by default.

Please note: The initial JavaScript is now added as footer JS to
ensure frontend development best practice.

