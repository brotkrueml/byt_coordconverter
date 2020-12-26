.. include:: /Includes.rst.txt


.. _upgrading:

=========
Upgrading
=========

From version 2 to version 3
===========================

The support for PHP 7.0-7.3 and TYPO3 v8 LTS was removed. No other breaking
changes.


From version 1 to version 2
===========================

Version 1.0 is available for TYPO3 v7 LTS, version 2.x works with TYPO3 v8+.
The following breaking changes were made:

* The declaration of the :html:`cc` namespace in the Fluid template to use the
  view helper is not needed anymore as it is bound to the extension.
* The namespace of the PHP classes changed to
  :php:`Brotkrueml\BytCoordconverter`. This shouldn't harm you as the
  declaration of the Fluid namespace is not needed anymore.
