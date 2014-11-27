

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


API
^^^

This section describes the usage of pluploadfe within your own
extensions.

Please take a look at EXT:mailfiles as long as this section is in
work.


Example Code
""""""""""""

::

   public function renderPlupload() {
       t3lib_div::requireOnce(t3lib_extMgm::extPath('pluploadfe', 'pi1/class.tx_pluploadfe_pi1.php'));
       $this->pluploadfe = t3lib_div::makeInstance('tx_pluploadfe_pi1');
       $this->pluploadfe->cObj = $this->cObj;
       
       $this->pluploadfeConf['configUid'] = 123;
       $this->pluploadfeConf['uid'] = "my_plupload";
       
       return $this->pluploadfe->main("", $this->pluploadfeConf);           
   }

