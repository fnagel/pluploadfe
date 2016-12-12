

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


.. _developer-guide:

Developer Guide
===============

Target group: **Developers**


.. only:: html

	.. contents:: Within this page
		:local:
		:depth: 3



Integrating EXT:pluploafe in your own extensions
------------------------------------------------

TypoScript
^^^^^^^^^^

.. code-block:: ts

   lib.examplePluploadFe < plugin.tx_pluploadfe_pi1
   lib.examplePluploadFe {
      templateFile = fileadmin/some/file.html
      uid = some-unique-string
      configUid = 123
   }


Template integration
^^^^^^^^^^^^^^^^^^^^

.. code-block:: xml

   <f:cObject typoscriptObjectPath="lib.examplePluploadFe" />


Usage in controller
-------------------

.. code-block:: php

      // Get saved files
		$files = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_pluploadfe_files');

		// Reset files in session
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_pluploadfe_files', '');
		$GLOBALS['TSFE']->fe_user->storeSessionData();
