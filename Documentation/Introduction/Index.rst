.. include:: /Includes.rst.txt


.. _introduction:

============
Introduction
============


.. _what-it-does:

What does it do?
================

The extension converts spatial geo coordinates (latitude and longitude) from the
degree notation to other output formats with the help of a Fluid view helper.

Example::

   <cc:coordinateConverter
      latitude="49.487111"
      longitude="8.466278"
      outputFormat="degreeMinutesSeconds"
    />

The result is:

.. code-block:: text

   N 49° 29' 13.59960", E 8° 27' 58.60080"

Currently supported are the formats:

* Degree
* Degree with minutes
* Degree with minutes and seconds
* UTM (Universal Transverse Mercator)
