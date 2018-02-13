<?php

/*
 * @copyright   2016 Mautic, Inc. All rights reserved
 * @author      Mautic, Inc
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticRecurringCampaignsBundle;

/**
 * Class RecurringCampaignsEvents.
 *
 * Events available for MauticRecurringCampaignsBundle
 */
final class RecurringCampaignsEvents
{
    /**
     * The mautic.recurring.campaign.on_campaign_trigger_action event is fired when the campaign action triggers.
     *
     * The event listener receives a
     * Mautic\CampaignBundle\Event\CampaignExecutionEvent
     *
     * @var string
     */
    const ON_CAMPAIGN_TRIGGER_ACTION = 'mautic.recurring.campaign.on_campaign_trigger_action';
}
