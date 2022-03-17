=== Ninja Mail ===
Contributors: kbjohnson90, kstover
Donate Link: https://ninjaforms.com
Tags: forms, email, transactional
Requires at least: 4.7
Tested up to: 4.9
Stable Tag: 1.0.3
License: GPLv2 or later

Improve the reliability of Ninja Forms submission emails.

== Description ==

Ninja Mail is a service from the makers of Ninja Forms that allows you to improve the deliverability of Ninja Forms submission emails. Without Ninja Mail, when someone submits a Ninja Form, all email actions are routed through your web host, which may or may not actually deliver the email. Ninja Mail bypasses your host altogether, avoiding any possible issues. This plugin allows you to connect to Ninja Mail using a secure OAuth connection.

When this plugin is installed, you’ll be able to sign up for the Ninja Mail service from the new “Services” tab within your Ninja Forms dashboard. Once you’re signed up, all your Ninja Forms submission emails will be routed through my.ninjaforms.com. We know that sending all your form submission data through a third-party can be scary, so please can check out our privacy policy and terms and conditions.

= Installation ==

1. Install and activate Ninja Forms
1. Visit your Ninja Forms plugin dashboard (the place where all your forms are listed)
1. Click on the Services tab, then click Signup in the Ninja Mail section

== Frequently asked questions ==

Q. Is the Ninja Mail service free?
A. No. Ninja Mail is a paid service.

Q. Does this plugin work without signing up for the Ninja Mail service?
A. No. This plugin only serves to connect you to the Ninja Mail service, so if you don’t use the service, the plugin doesn’t have anything to do.

Q. Does the Ninja Mail plugin work without Ninja Forms?
A. No. The plugin and service are both designed to improve Ninja Forms submission email reliability, so they require the use of the Ninja Forms plugin.

== Upgrade Notice ==

* Reduced the number of external requests to the server.

== Changelog ==

= 1.0.3 (01 August 2018) =

* Reduced the number of external requests to the server.

= 1.0.2 (05 July 2018) =

* Reverted fallback to avoid possible duplicate emails.
* Fixed a PHP Warning when custom email headers are not set.

= 1.0.1 (19 June 2018) =

*Changes:*

* Add a fallback for when mail isn't sent by the service, ie Unauthorized account.
* Persist sign-up prompts until sign-up is complete.
* Removed development specific code.

= 1.0.0 (11 June 2018) =

* Initial release.
