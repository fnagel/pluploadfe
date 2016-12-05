

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


Configuration
^^^^^^^^^^^^^

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         title

   Data type
         string

   Description
         Title of the configuration file (not used in FE)

   Default
         fileadmin


.. container:: table-row

   Property
         upload\_path

   Data type
         filepath

   Description
         Filepath to upload files (required)

   Default
		-

.. container:: table-row

   Property
         extensions

   Data type
         Comma separated list

   Description
         Comma separated list of allowed file types (required)

   Default
         jpeg,jpg,gif,png,zip,rar,7zip,gz


.. container:: table-row

   Property
         feuser\_required

   Data type
         boolean

   Description
         If true a logged-in FE user is required in order to upload files

   Default
         true


.. container:: table-row

   Property
         feuser\_field

   Data type
         string

   Description
         If FE user is logged-in create a subdirectory by username or any of these: uid, pid, name, logindate, ...

   Default
         ''


.. container:: table-row

   Property
         save\_session

   Data type
         boolean

   Description
         If the uploaded files should be available in the FE user session (key:
         'tx\_pluploadfe\_files')

   Default
         false


.. container:: table-row

   Property
         obscure\_dir

   Data type
         boolean

   Description
         If true every file is pseudo secured by adding a 20 chars long random
         string directory to the upload path

   Default
         true


.. container:: table-row

   Property
         check\_mime

   Data type
         boolean

   Description
         Checks (real) MIME type after uploading file. Safety level depends on
         PHP version / server configuration.
         uploads (see

   Default
         true


.. ###### END~OF~TABLE ######

