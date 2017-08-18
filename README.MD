

# Facebook Marketing API examples

There is demo app for Facebook Marketing Api. There is custom api client that eorks with facebook marketing api with Facebook SDK or plain HTTP requests

Implemented/tested some examples from documentation.

Facebook Marketing API Documentation:

[https://developers.facebook.com/docs/marketing-apis](https://developers.facebook.com/docs/marketing-apis) 



# Quick start

**1. Register app**

[https://developers.facebook.com/apps/](https://developers.facebook.com/apps/)

My application is here:

[https://developers.facebook.com/apps/371590979930811/dashboard/](https://developers.facebook.com/apps/371590979930811/dashboard/)

Get app id and app secret. It will be used in project

**2. Create marketing app from existing(if needed)**

Probably need to create marketing app. It will add marketing api features to existing app

[https://developers.facebook.com/docs/marketing-apis](https://developers.facebook.com/docs/marketing-apis)

Just click link &quot;add product&quot;

[https://developers.facebook.com/apps/371590979930811/marketing-api/](https://developers.facebook.com/apps/371590979930811/marketing-api/)

Also need to accept some agreements as well

[https://www.facebook.com/ads/leadgen/tos](https://www.facebook.com/ads/leadgen/tos)

[https://www.facebook.com/ads/manage/customaudiences/tos/?act=912757582133242](https://www.facebook.com/ads/manage/customaudiences/tos/?act=912757582133242)





# Working with Marketing API

There are 3 main parts:

**1. Ads management**

**2. Audience management**

**3. Ads insights**

# Ads management

Documentation is here: [https://developers.facebook.com/docs/marketing-api/buying-api](https://developers.facebook.com/docs/marketing-api/buying-api)

Examples are here:

[https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookAddsClient.php](https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookAddsClient.php)

Root entity is Campaign. Campaign can have multiple AdSets, AdSets can have multiple Ads.

Ads can be different types, and then there are additional entities for customizing ads.

See more info in documentation. Entities, Campaign structure etc.

There are some extra features available. For example, **Dynamic ads** help to show specific ads to specific auditory. You have multiple adds(catalog) and multiple auditory. Dynamic ads combine it and show to relevant ads to people. More info: [https://developers.facebook.com/docs/marketing-api/dynamic-ad](https://developers.facebook.com/docs/marketing-api/dynamic-ad)

Another thing is **Canvas Ads**. According to documentation it allows to combine different Ads elements like Image, Background, Video, etc. And it can be created automatically using api. More information is here: [https://developers.facebook.com/docs/marketing-api/guides/canvas-ads](https://developers.facebook.com/docs/marketing-api/guides/canvas-ads)

Finaly, what I&#39;m interested in is Marketing API Messenger feature. As I understand, it helps to create advertisement chatbot for Facebook Messenger. More info: [https://developers.facebook.com/docs/marketing-api/guides/messenger-sponsored/v2.10](https://developers.facebook.com/docs/marketing-api/guides/messenger-sponsored/v2.10)

What I personally used is Facebook Leads. I used it in 9round project, more info in separate document, **Facebook Add Leads Review.docx**

Shortly about Facebook Leads – it allow to create Leadgen Form on facebook page. Then visitors complete this form. Form data is stored in facebook and can be fetched with API. It also can send webhooks in real time. Form data can be used in your project for sales / marketing / analytics purposes.

**More info here:** [https://developers.facebook.com/docs/marketing-api/guides/lead-ads/v2.10](https://developers.facebook.com/docs/marketing-api/guides/lead-ads/v2.10)

**Examples:** [https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookLeadsClient.php](https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookLeadsClient.php)

_Form wasn&#39;t added to page. Seems like Campaign must be approved first. Use test lead generator for testing purpoces._ [_https://developers.facebook.com/tools/lead-ads-testing_](https://developers.facebook.com/tools/lead-ads-testing)



# Audience management

It&#39;s all about audience and targeting. You can create custom audience and add people here. Or you can use targeting to find people by some criterias (interests, location, live events, etc.)

**Documentation available here:**

[https://developers.facebook.com/docs/marketing-api/audiences-api](https://developers.facebook.com/docs/marketing-api/audiences-api)

[https://developers.facebook.com/docs/marketing-api/reference/custom-audience](https://developers.facebook.com/docs/marketing-api/reference/custom-audience)

**Examples are here:**

[https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookAudienceClient.php](https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookAudienceClient.php)



# Ads insights

It&#39;s all about marketing api analytics and statistics. For example, it can get statics for specific Campaign etc. Not sure because I checked it very basically. Deeper investigation needed. Tried to make api call to get Leadgen form insights. Get empty data for now.

**Documentation is here:**

[https://developers.facebook.com/docs/marketing-api/insights-api](https://developers.facebook.com/docs/marketing-api/insights-api)

**Examples are here:**

[https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookInsightsClient.php](https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookInsightsClient.php)

# Api Client

**Project on github:**

[https://github.com/antonshell/facebook-marketing-api](https://github.com/antonshell/facebook-marketing-api)

**Samples:**

[https://github.com/antonshell/facebook-marketing-api/blob/master/examples.php](https://github.com/antonshell/facebook-marketing-api/blob/master/examples.php)

**Facebook Adds:**

[https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookAddsClient.php](https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookAddsClient.php)

Implemented Create Campaign, Search Targetings, CreateAddSet(error), CreateCreative(error), CreateAdd(error)

**Facebook Leads:**

[https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookLeadsClient.php](https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookLeadsClient.php)

Implemented Get Forms, Get Leads, Check webhook subscription, Subscribe to webhook, Create Legal Content, Create Legal Content Card, Create Leadgen Form.

**Facebook Insights:**

[https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookInsightsClient.php](https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookInsightsClient.php)

Implemented Get Campaign Insights

**Facebook Audience:**

[https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookAudienceClient.php](https://github.com/antonshell/facebook-marketing-api/blob/master/classes/marketing/FacebookAudienceClient.php)

Implemented Create Audience, Add people, Remove people.