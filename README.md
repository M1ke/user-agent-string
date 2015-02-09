# User Agent String

A simple PHP interface to return data about a user agent string, specifically whether it is human or bot.

### Install

You can install Worldpay with [Composer](http://getcomposer.org). Add the following to the `require` key of your `composer.json` file:

    "m1ke/user-agent-string": "dev-master"

The `user_agent_string` class will become accessible through Composer's Classmap. You will currently need to add:

	require __DIR__.'/vendor/m1ke/easy-site-utils/init.php';

To include some utility functions that this class uses. It is intended to migrate these to a static singleton object which will work with auto loaders.

### Authors

Written by [Mike Lehan](http://twitter.com/m1ke) and [StuRents.com](http://sturents.com).
