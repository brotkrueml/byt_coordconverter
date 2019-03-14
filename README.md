# Coordinate Converter

[![TYPO3](https://img.shields.io/badge/TYPO3-8%20LTS-orange.svg)](https://typo3.org/)
[![TYPO3](https://img.shields.io/badge/TYPO3-9%20LTS-orange.svg)](https://typo3.org/)
[![Build Status](https://travis-ci.org/brotkrueml/byt_coordconverter.svg?branch=master)](https://travis-ci.org/brotkrueml/byt_coordconverter)
[![Maintainability](https://api.codeclimate.com/v1/badges/b7e02a9299d5d65d18bf/maintainability)](https://codeclimate.com/github/brotkrueml/byt_coordconverter/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/b7e02a9299d5d65d18bf/test_coverage)](https://codeclimate.com/github/brotkrueml/byt_coordconverter/test_coverage)
[![Latest Stable Version](https://poser.pugx.org/brotkrueml/coordconverter/v/stable)](https://packagist.org/packages/brotkrueml/coordconverter)

This is a TYPO3 extension for converting geospacial coordinates from one format into another via a Fluid view helper.


## Requirements

The extension in version 2.0 works with TYPO3 8 LTS and TYPO3 9 LTS. Use version 1.0.5 for TYPO3 7 LTS from the TYPO3 Extension Repository.


## Installation

### Installation via Composer

The recommended way to install this extension is by using [Composer](https://getcomposer.org/). In your Composer based TYPO3 project root, just do

    composer require brotkrueml/coordconverter

### Installation as extension from TYPO3 Extension Repository (TER)

Download and install the extension with the extension manager module.


## Usage

### General

After installation you can use it in every Fluid template. The namespace is set to `cc`, the basic usage:

    <cc:coordinateConverter latitude="{latitude}" longitude="{longitude}"/>

Overview of the possible parameters:

| Parameter              | Description                                      | Default value | Possible values                                  |
|------------------------|--------------------------------------------------|---------------|--------------------------------------------------|
| latitude               | Latitude (required)                              |               | +90.0 to -90.0                                   |
| longitude              | Longitude (required)                             |               | +180.0 to -180.0                                 |
| outputFormat           | The output format of the coordinates             | degree        | degree, degreeMinutes, degreeMinutesSeconds, UTM |
| cardinalPoints         | Results for the cardinal points, separated by \| | N\|S\|E\|W    |                                                  |
| cardinalPointsPosition | Position for the cardinal points                 | before        | before, after                                    |
| numberOfDecimals       | Number of decimals for the result                | 5             | 0-                                               |
| removeTrailingZeros    | Set to true, if trailing zeros should be removed | false         | false, true, 0, 1                                |
| delimiter              | The delimiter between latitude and longitude     |  ,            |                                                  |


### Output formats

#### Degree notation with decimals

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278"/>

The output is: `N 49.48711°, E 8.46628°`

**Notice:** The values for the latitude variable are number-only and range from +90.0 to -90.0, the positives values are north, the negative values are south.
The values for the longitude variable range from +180.0 to -180.0, the positives values are east, the negative values are west.
This input format is ideal to store in databases.

The next example is identical, the output format parameter defaults to "degree":

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degree"/>


#### Degree/minutes notation

To convert the coordinate pair into the degree/minutes format just add the output format parameter to the view helper:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degreeMinutes"/>

Now you get the result: `N 49° 29.22666', E 8° 27.97668'`


#### Degree/minutes/seconds notation

If you want to output the coordinate pair in minutes and seconds just use this syntax:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="degreeMinutesSeconds"/>

The result is: `N 49° 29' 13.59960", E 8° 27' 58.60080"`


#### UTM notation

You can also convert the latitude/longitude coordinates to the UTM (Universal Transverse Mercator) notation:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" outputFormat="UTM"/>

The result is: `32U 461344 5481745`


### Number of decimals

The default number of decimals to show in the coordinates is set to 5. If you want to change the just use the numberOfDecimals parameter:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" numberOfDecimals="4"/>

The output is: `N 49.4871°, E 8.4663°`

The parameter has no effect in output format "UTM notation".


### Remove trailing zeros

Sometimes the coordinates look nicer when the trailing zeros are stripped. Just use the `removeTrailingZeros` parameter:

    <cc:coordinateConverter latitude="49.48710" longitude="8.46600" removeTrailingZeros="1"/>

The output is: `N 49.4871°, E 8.466°`

This parameter has no effect in output format "UTM notation".


### Delimiter

The default delimiter between the two coordinates is the comma with a white space. You can change it:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" delimiter=" / "/>

You get the result: `N 49.48711° / E 8.46628°`

The parameter has no effect in output format "UTM notation".


### Cardinal points

You don't like the abbreviations N, S, E, W? You can change it:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPoints="North|South|East|West"/>

Now you get: `North 49.48711° / East 8.46628°`

Or you like to use the german version?

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPoints="N|S|O|W"/>

This outputs: `N 49.48711° / O 8.46628°`

The parameter has no effect in output format "UTM notation".


### Cardinal points position

You can choose, at which position to show the cardinal point, before or after the coordinate:

    <cc:coordinateConverter latitude="49.487111" longitude="8.466278" cardinalPointsPosition="after"/>

Now you get the cardinal point after each coordinate: `49.48711° N, 8.46628° E`

The parameter has no effect in output format "UTM notation".


## Using the XML Schema (XSD) for Validation in your Template

It is possible to assist your code editor on suggesting the tag name and the possible attributes.
Just add the `cc` namespace to the root of your Fluid template:

    <html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers" xmlns:cc="http://typo3.org/ns/Brotkrueml/Coordconverter/ViewHelpers" cc:schemaLocation="https://brot.krue.ml/schemas/byt_coordconverter-2.0.0.xsd" data-namespace-typo3-fluid="true">

The relevant part is the namespace declaration (`xmlns:cc="http://typo3.org/ns/Brotkrueml/Coordconverter/ViewHelpers"`). The content of the `cc:schemaLocation` attribute points to the recent XSD definition.

You can also import the XSD file into your favorite IDE, it is shipped with the extension. You can find the file in the folder `Resources/Private/Schemas/`.

## Upgrading from version 1.0 to version 2.0

Version 1.0 is available for TYPO3 7 LTS, version 2.0 works only for TYPO3 8 LTS und TYPO3 9 LTS. The following breaking changes were made:

- The declaration of the `cc` namespace in the Fluid template to use the view helper is not needed anymore as it is bound to the extension.
- The namespace of the PHP classes changed to `Brotkrueml\BytCoordconverter\`. This shouldn't harm you as the manual declaration of the Fluid namespace is not needed anymore.
