<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticRecurringCampaignsBundle\EventListener;

use Doctrine\DBAL\Connection;
use Mautic\CampaignBundle\CampaignEvents;
use Mautic\CampaignBundle\Event\CampaignBuilderEvent;
use Mautic\CampaignBundle\Event\CampaignExecutionEvent;
use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\MauticRecurringCampaignsBundle\RecurringCampaignsEvents;

class CampaignSubscriber extends CommonSubscriber
{
    /**
     * @var IntegrationHelper
     */
    protected $integrationHelper;

    /**
     * @var $db
     */
    protected $db;

    /**
     * ButtonSubscriber constructor.
     *
     * @param IntegrationHelper $helper
     */
    public function __construct(IntegrationHelper $integrationHelper, Connection $db)
    {
        $this->integrationHelper = $integrationHelper;
        $this->db = $db;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            CampaignEvents::CAMPAIGN_ON_BUILD      => ['onCampaignBuild', 0],
            RecurringCampaignsEvents::ON_CAMPAIGN_TRIGGER_ACTION => ['onCampaignTriggerAction', 0],
        ];
    }

    /**
     * Add event triggers and actions.
     *
     * @param CampaignBuilderEvent $event
     */
    public function onCampaignBuild(CampaignBuilderEvent $event)
    {
        $action = [
            'label' => 'plugin.campaign.recurring.campaign.event.remove.logs',
            'eventName' => RecurringCampaignsEvents::ON_CAMPAIGN_TRIGGER_ACTION,
            'formType' => 'removelogs',
            'channel' => 'campaign',
            'channelIdField' => 'campaign_id',
        ];
        $event->addAction('campaign.recurring.remove.logs', $action);
    }
    /**
     * @param CampaignExecutionEvent $event
     */
    public function onCampaignTriggerAction(CampaignExecutionEvent $event)
    {
        static $alreadyRemoved = [];

        $lead = $event->getLead();
        $campaigns = $event->getConfig()['campaigns'];
        $removeAllLogs = $event->getConfig()['all'];

        $qb = $this->db;
        foreach ($campaigns as $campaign) {
            if($removeAllLogs && !isset($alreadyRemoved[$campaign])){
                $qb->delete(
                    MAUTIC_TABLE_PREFIX.'campaign_lead_event_log',
                    [
                        'campaign_id' => $campaign,
                    ]
                );
                $alreadyRemoved[$campaign] = true;
            }else {
                $qb->delete(
                    MAUTIC_TABLE_PREFIX.'campaign_lead_event_log',
                    [
                        'lead_id' => (int)$lead->getId(),
                        'campaign_id' => $campaign,
                    ]
                );
            }
        }
    }
}
