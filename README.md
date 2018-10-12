Coordinate Converter
====================

This is a TYPO3 extension for converting geospacial coordinates from one format into another via a Fluid view helper.


Requirements
------------

The extension in the recent version requires TYPO3 v8 LTS or TYPO3 v9 LTS.


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


### Output formats

#### Degree notation with decimals

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" />

The output is: `N 49.48711°, E 8.46628°`

**Notice:** The values for the latitude variable are number-only and range from +90.0 to -90.0, the positives values are north, the negative values are south.
The values for the longitude variable range from +180.0 to -180.0, the positives values are east, the negative values are west.
This input format is ideal to store in databases.

The next example is identical, the output format parameter defaults to "degree":

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degree" />


#### Degree/minutes notation

To convert the coordinate pair into the degree/minutes format just add the output format parameter to the view helper:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degreeMinutes" />

Now you get the result: `N 49° 29.22666', E 8° 27.97668'`


#### Degree/minutes/seconds notation

If you want to output the coordinate pair in minutes and seconds just use this syntax:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degreeMinutesSeconds" />

The result is: `N 49° 29' 13.59960", E 8° 27' 58.60080"`


#### UTM notation

You can also convert the latitude/longitude coordinates to the UTM (Universal Transverse Mercator) notation:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="UTM" />

The result is: `32U 461344 5481745`


### Number of decimals

The default number of decimals to show in the coordinates is set to 5. If you want to change the just use the numberOfDecimals parameter:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" numberOfDecimals="4" />

The output is: `N 49.4871°, E 8.4663°`

The parameter has no effect in output format "UTM notation".


### Remove trailing zeros

Sometimes the coordinates look nicer when the trailing zeros are stripped. Just use the `removeTrailingZeros` parameter:

    <cc:coordinateConverter latitude="49.48710" longitude="8.46600" removeTrailingZeros="1" />

The output is: `N 49.4871°, E 8.466°`

This parameter has no effect in output format "UTM notation".


### Delimiter

The default delimiter between the two coordinates is the comma with a white space. You can change it:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" delimiter=" / " />

You get the result: `N 49.48711° / E 8.46628°`

The parameter has no effect in output format "UTM notation".


### Cardinal points

You don't like the abbreviations N, S, E, W? You can change it:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPoints="North|South|East|West" />

Now you get: `North 49.48711° / East 8.46628°`

Or you like to use the german version?

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPoints="N|S|O|W" />

This outputs: `N 49.48711° / O 8.46628°`

The parameter has no effect in output format "UTM notation".


### Cardinal points position

You can choose, at which position to show the cardinal point, before or after the coordinate:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPointsPosition="after" />

Now you get the cardinal point after each coordinate: `49.48711° N, 8.46628° E`

The parameter has no effect in output format "UTM notation".


### Errors

If you enter an invalid value for a parameter no output is shown. You can get the error messages if you set the error parameter to 1:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="somethingNotDefined" error="1" />

And get the output:

    Wrong output format (given: somethingNotDefined, allowed: degree, degreeMinutes, degreeMinutesSeconds, UTM)


Collaboration
-------------

If you stumble upon a problem or find a bug, don't hesitate to contact me. You can also provide a patch or feature via a pull request.