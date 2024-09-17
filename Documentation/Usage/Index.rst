.. include:: /Includes.rst.txt

.. _usage:

=====
Usage
=====

Target group: **Integrators**, **Developers**


General
=======

After installation you can use the coordinate converter view helper in every
Fluid template. The namespace is set to :html:`cc`, the basic usage:

.. code-block:: html

   <cc:coordinateConverter latitude="49.487113" longitude="8.466284"/>

The output is:

.. code-block:: plaintext

   N 49.48711°, E 8.46628°


The view helper arguments
=========================

The following arguments are available:

.. confval-menu::
   :name: viewhelper-arguments

   .. confval:: latitude
      :name: viewhelper-latitude
      :type: float
      :Possible values: `+90.0` to `-90.0`
      :required:

      The latitude: a positive value is north, a negative value is south.


   .. confval:: longitude
      :name: viewhelper-longitude
      :type: float
      :Possible values: `+180.0` to `-180.0`
      :required:

      The longitude: a positive value is east, a negative value is west.


   .. confval:: outputFormat
      :name: viewhelper-outputformat
      :type: string
      :Possible values: `degree`, `degreeMinutes`, `degreeMinutesSeconds`, `UTM`
      :Default: `degree`

      The output format of the coordinates.

      **Example: Degree/minutes notation**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.487111"
            longitude="8.466278"
            outputFormat="degreeMinutes"
         />

      The output is:

      .. code-block:: plaintext

         N 49° 29.22666', E 8° 27.97668'

      **Example: Degree/minutes/seconds notation**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.487111"
            longitude="8.466278"
            outputFormat="degreeMinutesSeconds"
         />

      The result is:

      .. code-block:: plaintext

         N 49° 29' 13.59960", E 8° 27' 58.60080"

      **Example: UTM (Universal Transverse Mercator) notation**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.487111"
            longitude="8.466278"
            outputFormat="UTM"
         />

      The result is:

      .. code-block:: plaintext

         32U 461344 5481745


   .. confval:: cardinalPoints
      :name: viewhelper-cardinalpoints
      :type: string
      :Default: `N|S|E|W`

      Results for the cardinal points, separated by `|`. The argument has no
      effect in :confval:`output format <viewhelper-outputformat>` :html:`UTM`.

      **Example: Use full cardinal point name**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.487111"
            longitude="8.466278"
            cardinalPoints="North|South|East|West"
         />

      The result is:

      .. code-block:: plaintext

         North 49.48711° / East 8.46628°

      **Example: Use German abbreviations**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.487111"
            longitude="8.466278"
            cardinalPoints="N|S|O|W"
         />

      The result is:

      .. code-block:: plaintext

         N 49.48711° / O 8.46628°


   .. confval:: cardinalPointsPosition
      :name: viewhelper-cardinalpointsposition
      :type: string
      :Possible values: `before`, `after`
      :Default: `before`

      Position for the cardinal points. The argument has no effect in
      :confval:`output format <viewhelper-outputformat>` :html:`UTM`.

      **Example: Move cardinal point position to the end**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.487111"
            longitude="8.466278"
            cardinalPointsPosition="after"
         />

      The result is:

      .. code-block:: plaintext

         49.48711° N, 8.46628° E


   .. confval:: numberOfDecimals
      :name: viewhelper-numberofdecimals
      :type: int
      :Possible values: >= 0
      :Default: `5`

      Number of decimals for the result. The argument has no effect in
      :confval:`output format <viewhelper-outputformat>` :html:`UTM`.

      **Example: Show three decimals**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.487111"
            longitude="8.466278"
            numberOfDecimals="3"
         />

      The result is:

      .. code-block:: plaintext

         N 49.487°, E 8.466°


   .. confval:: removeTrailingZeros
      :name: viewhelper-removeTrailingZeros
      :type: bool
      :Default: `0`

      Set to `1` to remove trailing zeros in a coordinate. The argument has no
      effect in :confval:`output format <viewhelper-outputformat>` :html:`UTM`.

      **Example: Show trailing zeros (the default)**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.48710"
            longitude="8.46600"
            removeTrailingZeros="1"
         />

      The result is:

      .. code-block:: plaintext

         N 49.4871°, E 008.466°


   .. confval:: delimiter
      :name: viewhelper-delimiter
      :type: string
      :Default: `,`

      The delimiter between latitude and longitude. The argument has no effect
      in :confval:`output format <viewhelper-outputformat>` :html:`UTM`.

      **Example:**

      .. code-block:: html
         :emphasize-lines: 4

         <cc:coordinateConverter
            latitude="49.487111"
            longitude="8.466278"
            delimiter=" / "
         />

      The result is:

      .. code-block:: plaintext

         N 49.48711° / E 8.46628°


Using the XML Schema (XSD) for validation in your template
==========================================================

It is possible to assist your code editor on suggesting the tag name and the
possible attributes. Just add the :html:`cc` namespace to the root of your Fluid
template:

.. code-block:: html
   :emphasize-lines: 3-4

   <html
      xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
      xmlns:cc="http://typo3.org/ns/Brotkrueml/Coordconverter/ViewHelpers"
      cc:schemaLocation="https://brotkrueml.dev/schemas/byt_coordconverter-3.0.0.xsd"
      data-namespace-typo3-fluid="true"
   >
      ...
   </html>

The relevant part is the namespace declaration
(:html:`xmlns:cc="http://typo3.org/ns/Brotkrueml/Coordconverter/ViewHelpers"`).
The content of the :html:`cc:schemaLocation` attribute points to the recent XSD
definition.

You can also import the XSD file into your favorite IDE, it is shipped with the
extension. You can find the file in the folder
:file:`Resources/Private/Schemas/`.
