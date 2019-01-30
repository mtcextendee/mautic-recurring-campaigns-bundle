# MauticRecurringCampaignsBundle 

<strong style="color:#cc7700">Bundle is deprecated</strong>. 
Mautic 2.14 finally have added support for recurring campaigns

#### Support projects

- Extensions family for Mautic https://mtcextendee.com/
- Recommendations engine for Mautic https://mtcrecombee.com/
- Support my work by <a href="https://www.paypal.me/kuzmany">PayPal</a> or host your Mautic on recommended affil host  <a href="https://www.vultr.com/?ref=7223705">Vultr</a>

## Recurring Campaigns

Repeating tasks for Mautic

## Workaround

Mautic insert every action of campaigns to campaign_lead_event_log table. This plugin just remove logs from contact. It's basic workaround, but keep in mind, you lost data from campaign statistics (not emails stats etc.).

## Installation

### Composer from Mautic root directory

composer require kuzmany/mautic-recurring-campaigns-bundle


### Then:

1. Go to Mautic > Plugins and click to the button Install/Upgrade plugins
![image](https://user-images.githubusercontent.com/462477/34650614-28cf7e1a-f3c4-11e7-8653-2ffd04f62d4a.png)
2. New plugin should be added 
![image](https://user-images.githubusercontent.com/462477/36288188-cdf87d7e-12b9-11e8-9fd1-40f3ab211036.png)
3. Open and enable plugin 
![image](https://user-images.githubusercontent.com/462477/36288252-046e87f4-12ba-11e8-9a1e-d5d490b36f73.png)
4. Go to campaigns and use new action Recurring Campaigns - Remove logs
![image](https://user-images.githubusercontent.com/462477/36288291-3bb37e90-12ba-11e8-8a79-e162b1cb77d5.png)
5. Setup campaign action
![image](https://user-images.githubusercontent.com/462477/42267924-9341056a-7f7a-11e8-816a-f071df25723d.png)
