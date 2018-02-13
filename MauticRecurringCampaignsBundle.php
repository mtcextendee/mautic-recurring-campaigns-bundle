<?php

namespace MauticPlugin\MauticRecurringCampaignsBundle;

use Mautic\PluginBundle\Bundle\PluginBundleBase;

class MauticRecurringCampaignsBundle extends PluginBundleBase
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            CampaignEvents::CAMPAIGN_ON_BUILD      => ['onCampaignBuild', 0],
            LeadEvents::ON_CAMPAIGN_TRIGGER_ACTION => [
                ['onCampaignTriggerActionChangePoints', 0],
                ['onCampaignTriggerActionChangeLists', 1],
                ['onCampaignTriggerActionUpdateLead', 2],
                ['onCampaignTriggerActionUpdateTags', 3],
                ['onCampaignTriggerActionAddToCompany', 4],
                ['onCampaignTriggerActionChangeCompanyScore', 4],
                ['onCampaignTriggerActionDeleteContact', 6],
                ['onCampaignTriggerActionChangeOwner', 7],
            ],
            LeadEvents::ON_CAMPAIGN_TRIGGER_CONDITION => ['onCampaignTriggerCondition', 0],
        ];
    }
}
