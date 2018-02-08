London Landmarks - a simple API for consuming a RESTful service
===============================================================

This is a very basic API written for Symfony 3.4 to serve as an example for accessing an external RESTful web service as a consumer.
  * It uses the Unirest bundle (https://github.com/Kong/unirest-php) for accessing the REST service;
  * It requires PHP7.0, cURL and MySQL;
  * It includes functional tests and test databases.
  * NO authentication mechanism is implemented for using this API

The project has a front page that allows a user to search for a well-known landmark name (e.g. Big Ben in London) stored in the local database or query a public API at Google Maps and return a place id.
  * If the landmark name is found locally, then a map is displayed in an iframe showing the landmark;
  * If the name is found via Google's API, a place id is displayed, which can be added to the database.

There is a parameter "api_key" in parameters.yml used to query Google's API.
If this parameter is left empty or commented out, only a limited number of queries per day will be allowed by Google, as a protection measure.
To get unlimited queries per day you will need to get your own free api key here:

https://developers.google.com/maps/documentation/geocoding/get-api-key

This project contains .sql files for creating and populating two very small databases:
  * one is used for storing landmarks with their place_id
  * one is needed for functional testing only

You can import them locally from the system console like this:

mysql -u username -p -h localhost DATA-BASE-NAME < db.sql
