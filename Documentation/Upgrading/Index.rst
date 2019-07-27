.. include:: ../Includes.txt


.. _upgrading:

=========
Upgrading
=========

Upgrading from version 1 to version 2
=====================================

Version 1.0 is available for TYPO3 7 LTS, version 2.0+ works only for TYPO3 8 LTS und TYPO3 9 LTS.
The following breaking changes were made:

* The declaration of the :html:`cc` namespace in the Fluid template to use the view helper is not needed anymore as it
  is bound to the extension.
* The namespace of the PHP classes changed to :php:`Brotkrueml\BytCoordconverter`. This shouldn't harm you as the
  declaration of the Fluid namespace is not needed anymore.
