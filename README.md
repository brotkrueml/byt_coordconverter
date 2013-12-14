Coordinate Converter
====================

This is a TYPO3 extension for converting geospacial coordinates from one format into another via a Fluid view helper.


Requirements
------------

This extension requires TYPO3 version 6.0+.


Installation
------------

Just install this extension like any other extension via the extension manager.


Usage
-----

### General

After installation you can use it in every Fluid template. First you have to declare a namespace for the view helper. So, edit your template in which you want to use it and add the following snippet:

    {namespace cc=Byterror\BytCoordconverter\ViewHelpers}

Instead of cc you can use any other unique identifier for your template.

Now you can add the new view helper. In the minimal version you must assign a latitude and longitude in the decimal degree notation:


### Degree notation with decimals

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" />

The output is: `N 49.487111, E 8.466278`

**Notice:** The values for the latitude variable are number-only and range from +90.0 to -90.0, the positives values are north, the negative values are south.
The values for the longitude variable range from +180.0 to -180.0, the positives values are east, the negative values are west.
This input format is ideal to store in databases.

The next example is identical, the output format parameter defaults to "degree":

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degree" />


### Degree/minutes notation

To convert the coordinate pair into the degree/minutes format just add the output format parameter to the view helper:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degreeMinutes" />

Now you get the result: `N 49°29.227', E 8°27.977'`


### Degree/minutes/seconds notation

If you want to output the coordinate pair in minutes and seconds just use this syntax:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degreeMinutesSeconds" />

The result is: `N 49° 29' 13.60", E 8° 27' 58.60"`


### UTM notation

You can also convert the latitude/longitude coordinates to the UTM (Universal Transverse Mercator) notation:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="UTM" />

The result is: `32U 461344 5481745`


### Delimiter

The default delimiter between the two coordinates is the comma with a white space. You can change it:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" delimiter=" / " />

You get the result: `N 49.487111 / E 8.466278`


### Cardinal points

You don't like the abbreviations N, S, E, W? You can change it:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPoints="North|South|East|West" />

Now you get: `North 49.487111 / East 8.466278`

Or you like to use the german version?

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPoints="N|S|O|W" />

This outputs: `N 49.487111 / O 8.466278`


### Cardinal points position

You can choose, at which position to show the cardinal point, before or after the coordinate:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPointsPosition="after" />

Now you get the cardinal point after each coordinate: `49.487111 N, 8.466278 E`


### Errors

If you enter an invalid value for a parameter no output is shown. You can get the error messages if you set the error parameter to 1:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="somethingNotDefined" error="1" />

And get the output:

    Wrong output format (given: somethingNotDefined, allowed: degree, degreeMinutes, degreeMinutesSeconds)


Known problems
--------------

None at this time.

If you stumble upon a problem or find a bug, don't hesitate to contact me. You can also provide a patch or feature via a pull request.