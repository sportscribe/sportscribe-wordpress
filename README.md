# sportscribe-wp
SportScribe Wordpress Plugin v0.1.3

### This is a very preliminary version of the plugin. If you have questions, comments or feature requests, please contact support@sportscribe.co

### The aim of this plugin is to pull the data from the API and populate a Custom Post Type with enough meta data to allow customization of the post display.


## Installation instructions

1. Clone this repository you wp-content/plugins directory
1. Go to your WP Admin panel -> Plugins and 'Activate' the SportScribe plugin
1. On the admin menu go to "SportScribe Plugin" and enter the correct API KEY and click Save. 
  1. This will do a test API call and confirm whether you entererd it correctly.


## Usage Instructions

The plugin will automatically pull posts from the SportScribe API n days into the future. By default n is 3 days, and can be changed in the SportScribe settings admin view.

You can also manually pull specific dates by using the "Grab Posts" form in the admin view.

When the data is posted, there will be a "Match Previews" admin menu item where all the match previews will be posted

There is a checkbox in the admin view to specify whether to include these posts in the home page view. Other than that, you are responsible for modifying your code to display the data in the appropriate spots. If you have custom requirements we are happy to help or point you towards a wordpress developer.

## Meta Data

The following meta data is set for each post

* ss_meta_league_id = sport scribe league_id
* ss_meta_league_name = sport scribe league name
* ss_meta_hometeam_name = match's home team's name
* ss_meta_hometeam_id = match's home team's id
* ss_meta_visitorteam_name = match's visitor team's name
* ss_meta_visitorteam_id = match's visitor team's id
* ss_meta_formation_img = url for a formation img *( coming soon )*
* ss_meta_quick_items = array of short items about the fixture *( coming soon )*
* ss_meta_stadium_city = match's venue city name
* ss_meta_stadium_name = match's venue name
* ss_meta_fixture_date = match's date *( YYYY-MM-DD )*
* ss_meta_match_img = url for match's header img *( coming soon )*
* ss_meta_match_img_txt = url for match's header img with text *( coming soon )*
* ss_meta_headline = headline for match *( coming soon )*

#### Taxonomies

* league = The match's league name
* country = The match's country

### Change Log

v0.1.4 = Minor bug fixes
v0.1.3 = Changed custom tax to be public
v0.1.2 = Minor bug fixes
v0.1.1 = Added custom_code.php to allow easy customization, and cleaned up dir structure
