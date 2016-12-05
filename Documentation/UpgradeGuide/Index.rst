

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



Upgrade to 1.5.2
^^^^^^^^^^^^^^^^

Changelog
"""""""""

* Fix bug in folder generation with user name (replaced invalid `realName` field with `name`)


How to upgrade
""""""""""""""

You need to clear the cache.

Make sure to check the `feuser_field` in your configuration records.



Upgrade to 1.5.1
^^^^^^^^^^^^^^^^

Changelog
"""""""""

* Fix bug in new content element wizard TSconfig

* Remove folder input wizard workaround for TYPO3 7.6.11+

* Remove old changelog


How to upgrade
""""""""""""""

You need to clear the cache.



Upgrade to 1.5.0
^^^^^^^^^^^^^^^^

Changelog
"""""""""

* TYPO3 8.x support

* Update Plupload to v2.1.9

* Rework TCA to match latest TYPO3 API

* Rework folder structure to match TYPO3 defaults

* Fix TCA tab configuration for TYPO3 6.2


How to upgrade
""""""""""""""

You need to clear the cache and make sure your TS configuration is up to date!



Upgrade to 1.4.0
^^^^^^^^^^^^^^^^

Changelog
"""""""""

* New feature: Using fe_user properties as upload folder (thanks to Daniel Wagner)!

* Improve config record TCA (now using tabs, improved localization)

* New template marker for max upload size (###FILE_MAX_SIZE###)


How to upgrade
""""""""""""""

You need to clear the cache and create the new DB field after upgrading.
Make sure your template match latest changes.



Upgrade to 1.3.x
^^^^^^^^^^^^^^^^

Extension is now compatible with TYPO3 CMS 7.5 and 7.6.

Plupload plugin has been updated, make sure everything works as expected.

You need to clear the cache in backend after upgrading.


Note: Version 1.3.0 was replaced with 1.3.1 due to upload errors.



Upgrade to 1.2.0
^^^^^^^^^^^^^^^^

Extension is now compatible with TYPO3 CMS 7.x.

Plupload plugin has been updated, make sure everything works as expected.

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

