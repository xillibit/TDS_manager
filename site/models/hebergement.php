<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_gesttaxesejour
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( '_JEXEC' ) or die ();

require_once JPATH_ADMINISTRATOR . '/components/com_gesttaxesejour/libraries/model.php';

/**
* Common Model for Gesttaxesejour
*
* @since 2.0
*/
class GesttaxesejourModelHebergement extends GesttaxeModel {

}

[6/5/2012 8:43:47 PM] Joe Collins: I keep getting spam reports from John (John) for posts that are not spam.
[6/5/2012 8:45:48 PM] Mortti: me too... I check that when it come and there was one another topic that was spam what I Banned... at least that url in that spam report was wrong
[6/5/2012 8:51:41 PM] Mortti: Spam what there was this when I get that "John" spam report: http://www.kunena.org/forum/119-Feature-Requests/123179-Kitchens-for-sale-London
[6/5/2012 8:53:06 PM] Mortti: it was latest post in forum then...
[6/5/2012 8:53:43 PM] Mortti: spam report say totally different topic
[6/5/2012 8:53:52 PM] Matias Griese: i've not assigned as being moderator, so i'm not getting those ;)
[6/5/2012 8:54:10 PM] Matias Griese: maybe need to check what's going on
[6/5/2012 8:54:21 PM] Matias Griese: likely a bug...
[6/5/2012 8:54:44 PM] Mortti: or... spammer do also spam reports
[6/5/2012 8:55:26 PM] Matias Griese: i suspect that there's topic id vs message id collision (they used to be the same)
[6/5/2012 9:00:10 PM] Mortti: Spam Report was this: http://screencast.com/t/quEUPhSplqXr
[6/5/2012 9:09:24 PM] Mortti: and when I check that, it didn't a spam, but at the same time there was latest forum post a spam (that "Kitchens for sale..." topic)
[6/5/2012 9:10:07 PM] Matias Griese: ok, my suspection was right
[6/5/2012 9:10:16 PM] Matias Griese: topic id != first post id anymore
[6/5/2012 9:10:23 PM] Matias Griese: so reports are wrong
[6/5/2012 9:10:28 PM] Matias Griese: can you report a bug?
[6/5/2012 9:19:22 PM] Mortti: I think Joe can add/say that for better english in github :)
[1:57:10 AM] Joe Collins: I have been AFK for 5 hours, did you make a report on Github Mortti?
[2:05:06 AM] Mortti: No I didn't
[6:39:21 AM] Michael Russell: Yes, I've received a couple of spam reports in the past couple of days - reports about messages being spam but, in fact, the messages were not spam. I'm surprised that Matias is not receiving these things.
[6:44:38 AM] Mortti: I just tell what I see, when spam report come to mail, and read/check it.
[7:09:53 AM] Michael Russell: I just received another wrong "report to moderator" from yaksushi which has nothing to do with the report.
[7:10:35 AM] Michael Russell: My conclusion is that the report to moderator function at K.org is binding the wrong message id with the report. Needs to be investigated.