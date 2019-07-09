.. include:: ../Includes.txt


.. _usage:

=====
Usage
=====

Target group: **Integrators** **Developers**


General
=======

After installation you can use the coordinate converter view helper in every Fluid template.
The namespace is set to cc, the basic usage:

.. code-block:: html

   <cc:coordinateConverter latitude="{latitude}" longitude="{longitude}"/>


The view helper arguments
=========================

The following arguments are possible:

======================= ================================================== ============= ================================================
Argument                Description                                        Default value Possible values
======================= ================================================== ============= ================================================
latitude                Latitude (required)                                              +90.0 to -90.0
longitude               Longitude (required)                                             +180.0 to -180.0
outputFormat            The output format of the coordinates               degree        degree, degreeMinutes, degreeMinutesSeconds, UTM
cardinalPoints          Results for the cardinal points, separated by |    N|S|E|W
cardinalPointsPosition  Position for the cardinal points                   before        before, after
numberOfDecimals        Number of decimals for the result                  5             0-
removeTrailingZeros     Set to 1, if trailing zeros should be removed      0             0, 1
delimiter               The delimiter between latitude and longitude       ,
======================= ================================================== ============= ================================================

Below are the arguments described.


Output formats
--------------

Degree notation with decimals
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278"/>

The output is:

::

   N 49.48711°, E 8.46628°

.. note::

   The value for the latitude argument is number-only and ranges from +90.0 to -90.0, a positive values is north,
   a negative values is south. The value for the longitude argument ranges from +180.0 to -180.0, a positive value
   is east, a negative value is west. This format is ideal to store in databases.

The result of the next example is identical to the previous one, the output format parameter defaults to ``degree``:

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degree"/>


Degree/minutes notation
~~~~~~~~~~~~~~~~~~~~~~~

To convert the coordinate pair into the degree/minutes format just add the output format parameter to the view helper:

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degreeMinutes"/>

Now you'll get the result:

::

   N 49° 29.22666', E 8° 27.97668'


Degree/minutes/seconds notation
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you want to output the coordinate pair in minutes and seconds just use this syntax:

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degreeMinutesSeconds"/>


The result is:

::

   N 49° 29' 13.59960", E 8° 27' 58.60080"


UTM notation
~~~~~~~~~~~~

You can also convert the latitude/longitude coordinates to the UTM (Universal Transverse Mercator) notation:

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="UTM"/>

The result is:

::

   32U 461344 5481745


Number of decimals
------------------

The default number of decimals to show in the coordinates is set to 5. If you want to change it, just use the ``numberOfDecimals``argument:

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" numberOfDecimals="4"/>


The result is:

::

   N 49.4871°, E 8.4663°

.. note::

   The argument has no effect in output format ``UTM notation``.


Remove trailing zeros
---------------------

Sometimes the coordinates look nicer when the trailing zeros are stripped off. Just use the ``removeTrailingZeros`` argument:

::

   <cc:coordinateConverter latitude="49.48710" longitude="8.46600" removeTrailingZeros="1"/>

The result is:

::

   N 49.4871°, E 8.466°

.. note::

   The argument has no effect in output format ``UTM notation``.


Delimiter
---------

The default delimiter between the two coordinates is the comma with a white space. You can change it:

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" delimiter=" / "/>

You'll get the result:

::

   N 49.48711° / E 8.46628°

.. note::

   The argument has no effect in output format ``UTM notation``.


Cardinal points
---------------

You don't like the default abbreviations N, S, E, W (for North, South, East, West)? You can change it:

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPoints="North|South|East|West"/>

Now you'll get:

::

   North 49.48711° / East 8.46628°

Or you like to use the German version?

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPoints="N|S|O|W"/>

The result is:

::

   N 49.48711° / O 8.46628°

.. note::

   The argument has no effect in output format ``UTM notation``.


Cardinal points position
------------------------

You can choose, at which position to show the cardinal point, before or after a coordinate:

::

   <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPointsPosition="after"/>

Now you get the cardinal point after each coordinate:

::

   49.48711° N, 8.46628° E

.. note::

   The argument has no effect in output format ``UTM notation``.


Using the XML Schema (XSD) for Validation in your Template
==========================================================

It is possible to assist your code editor on suggesting the tag name and the possible attributes. Just add the ``cc``
namespace to the root of your Fluid template:

::

   <html
      xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
      xmlns:cc="http://typo3.org/ns/Brotkrueml/Coordconverter/ViewHelpers"
      cc:schemaLocation="https://brot.krue.ml/schemas/byt_coordconverter-2.0.0.xsd"
      data-namespace-typo3-fluid="true"
   >
      ...
   </html>

The relevant part is the namespace declaration (``xmlns:cc="http://typo3.org/ns/Brotkrueml/Coordconverter/ViewHelpers"``).
The content of the ``cc:schemaLocation attribute`` points to the recent XSD definition.

You can also import the XSD file into your favorite IDE, it is shipped with the extension. You can find the file
in the folder ``Resources/Private/Schemas/``.
