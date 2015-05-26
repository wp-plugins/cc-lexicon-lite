=== CC Lexicon Lite ===

Plugin Name: CC Lexicon Lite
Contributors: caterhamcomputing
Plugin URI: http://cclexiconlite.ccplugins.co.uk/
Author URI: http://www.caterhamcomputing.net/
Donate Link: http://cclexiconlite.ccplugins.co.uk/donate/
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: 1.0.1
Version: 1.0.1
Tags: lexicon,shortcode,dictionary,term,terms,definitions,glossary,glossaries,list,lists,FAQs,FAQ

Provides an easy way to maintain and organise dictionary or glossary-style entries, or any type of term-based list. Display is via a simple shortcode.

== Description ==

Lexicon Entries consist of a "Term" and a "Definition" (if you are creating FAQs, this equates to a "Question" and an "Answer"), and can be managed in exactly the same way as standard WordPress posts.

The Lexicon Entries can also be organised into Categories.

The Lexicon Entries are displayed using a shortcode, allowing you to display all entries or those for certain categories.

The terms are indexed alphabetically, and initially only the terms are displayed - clicking on any term will expand the entry to show the definition.

= Using the shortcode =

The simplest usage would be to use the shortcode with no parameters:

`[lexicon]`

This would show all Lexicon Entries in all Categories with the default styling.

To show the Lexicon Entries for a single category, you would specify the category slug using the `category` parameter:

`[lexicon category="general-entries"]`

To show Lexicon Entries for a number of categories, simply supply a comma-separated list of category slugs:

`[lexicon category="general-entries,specialist-subjects,misc-entries"]`

You can change the styling of the Lexicon Entries using the `before_heading`, `after_heading`, `before_title` and `after_title` parameters:

The `before_heading` and `after_heading` parameters specify the HTML used before and after the indexation heading. By default, `before_heading` is set to `<h4>` and `after_heading` is set to `</h4>`.

If you wanted to have these items displayed at a larger size you could use something like:

`[lexicon before_heading="<h1>" after_heading="</h1>"]`

Similarly, the `before_title` and `after_title` parameters specify the HTML used before and after the actual Lexicon Term. By default, `before_title` is set to `<h5>` and `after_title` is set to `</h5>`.

If you wanted to have these items displayed at a larger size you could use something like:

`[lexicon before_title="<h1>" after_title="</h1>"]`

The default instructions that are displayed above the entries by the plugin read: "Click on any term below to reveal the description." ... you can change these instructions by specifying the `instructions` parameter:

`[lexicon instructions="Click on any item below to reveal more ..."]`

You can change how the instructions are displayed by specifying the `before_instructions` and `after_instructions` parameters. The default value for `before_instructions` is `<h5>`, and for `after_instructions` is `</h5>`.

For example, you could specify that the instructions are displayed in a `<div>` element as follows:

`[lexicon before_instructions="<div>" after_instructions="</div>"]`

You can specify a `skin` parameter, which will apply some standard styling to the Lexicon entries. This parameter can take the following values: `simple` (the default value), `red`, `green`and `blue`.

For example, the following would display the Lexicon entries in blue `[lexicon skin="blue"`.

If you want to add your own styling to the Lexicon entries, you can specify the `class` parameter to add your own class to the Lexicon entries for styling with CSS. Specifying the `class` parameter will cause the `skin` parameter to be ignored.

For example, you could use:

`[lexicon class="myclass"]`

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Default (Simple) skin: `[lexicon]` or `[lexicon skin="simple"]`
2. Skin for Red colour schemes: `[lexicon skin="red"]`
3. Skin for Green colour schemes: `[lexicon skin="green"]`
4. Skin for Blue colour schemes: `[lexicon skin="blue"]`

== Changelog ==

= 1.0.1 =
* Small bug fix

= 1.0 =
* Initial Release

== Upgrade Notice ==

= 1.0.1 =
* Small bug fix
