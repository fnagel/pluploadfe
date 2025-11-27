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


.. contents:: Within this page
   :local:
   :depth: 3



Integrating EXT:pluploafe in your own extensions
------------------------------------------------

Take a look at the following extension on how to integrate EXT:plupload in your extension:

* https://github.com/fnagel/mailfiles
* https://github.com/fnagel/pluploadfe_powermail


Using Fluid ViewHelper
^^^^^^^^^^^^^^^^^^^^^^

TypoScript
""""""""""

.. code-block:: ts

	settings {
		pluploadfe < plugin.tx_pluploadfe_pi1
		pluploadfe {
         templateFile = EXT:example/Resources/Private/Templates/template.html
         configUid = 123
		}
	}

Template integration
""""""""""""""""""""

.. code-block:: xml
   <html xmlns:plupload="http://typo3.org/ns/FelixNagel/Pluploadfe/ViewHelpers">
   <plupload:render configUid="{settings.configUid}" settings="{settings.pluploadfe}" />


Using TypoScript
^^^^^^^^^^^^^^^^

TypoScript
"""""""""

.. code-block:: ts

   lib.examplePluploadFe < plugin.tx_pluploadfe_pi1
   lib.examplePluploadFe {
      templateFile = EXT:example/Resources/Private/Templates/template.html
      configUid = 123
   }


Template integration
""""""""""""""""""""

.. code-block:: xml

   <f:cObject typoscriptObjectPath="lib.examplePluploadFe" />


Gather data in controller
^^^^^^^^^^^^^^^^^^^^^^^^^

**Version 7.x and up**

.. code-block:: php

   // Get saved files (by config record UID)
   $files = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_pluploadfe_123_files');

   // Get saved messages (by config record UID)
   $files = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_pluploadfe_123_messages');

   // Reset files in session
   $this->getTsFeController()->fe_user->setKey('ses', 'tx_pluploadfe_123_files', '');
   $this->getTsFeController()->fe_user->storeSessionData();


**Version 6.x**

.. code-block:: php

   // Get saved files (all files or by config record UID)
   $files = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_pluploadfe_files');
   $files = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_pluploadfe_123_files');

   // Get saved messages (by config record UID only)
   $files = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_pluploadfe_123_messages');

   // Reset files in session
   $this->getTsFeController()->fe_user->setKey('ses', 'tx_pluploadfe_files', '');
   $this->getTsFeController()->fe_user->setKey('ses', 'tx_pluploadfe_123_files', '');
   $this->getTsFeController()->fe_user->storeSessionData();


**Version 5.x and below**

.. code-block:: php

   // Get saved files (all files)
   $files = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_pluploadfe_files');

   // Reset files in session
   $this->getTsFeController()->fe_user->setKey('ses', 'tx_pluploadfe_files', '');
   $this->getTsFeController()->fe_user->storeSessionData();
