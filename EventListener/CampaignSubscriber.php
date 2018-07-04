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
use Mautic\CampaignBundle\Entity\Event;
use Mautic\CampaignBundle\Event\CampaignBuilderEvent;
use Mautic\CampaignBundle\Event\CampaignExecutionEvent;
use Mautic\CampaignBundle\Model\CampaignModel;
use Mautic\CampaignBundle\Model\EventModel;
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
     * @var Connection
     */
    protected $db;

    /**
     * @var CampaignModel
     */
    protected $campaignModel;

    /**
     * @var EventModel
     */
    private $eventModel;

    /**
     * ButtonSubscriber constructor.
     *
     * @param IntegrationHelper $integrationHelper
     * @param Connection        $db
     * @param CampaignModel     $campaignModel
     * @param EventModel        $eventModel
     *
     * @internal param IntegrationHelper $helper
     */
    public function __construct(IntegrationHelper $integrationHelper, Connection $db, CampaignModel $campaignModel, EventModel $eventModel)
    {
        $this->integrationHelper = $integrationHelper;
        $this->db = $db;
        $this->campaignModel = $campaignModel;
        $this->eventModel = $eventModel;
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
        /** @var MailTesterIntegration $myIntegration */
        $myIntegration = $this->integrationHelper->getIntegrationObject('RecurringCampaigns');

        if (false === $myIntegration || !$myIntegration->getIntegrationSettings()->getIsPublished()) {
            return;
        }

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

        /** @var MailTesterIntegration $myIntegration */
        $myIntegration = $this->integrationHelper->getIntegrationObject('RecurringCampaigns');

        if (false === $myIntegration || !$myIntegration->getIntegrationSettings()->getIsPublished()) {
            return;
        }

        $lead = $event->getLead();
        $campaigns = $event->getConfig()['campaigns'];
        $limit = $event->getConfig()['limit'];
        $qb = $this->db;

        $properties = $event->getEvent()['properties'];
        /** @var Event $event */
        $eventEntity = $this->eventModel->getEntity($event->getEvent()['id']);
        $numberOfRotation = isset($properties['numberOfRotation']) ? $properties['numberOfRotation'] : 0;

        // return true if max execution
        if (!empty($limit) && $numberOfRotation >= $limit) {
            return $event->setResult(true);
        }

        $properties['numberOfRotation'] = $numberOfRotation + 1;
        $eventEntity->setProperties($properties);
        $this->eventModel->saveEntity($eventEntity);

        foreach ($campaigns as $campaignId) {
            if(!empty($event->getConfig()['action'])){
                $qb->delete(
                    MAUTIC_TABLE_PREFIX.'campaign_lead_event_log',
                    [
                        'lead_id' => (int)$lead->getId(),
                        'campaign_id' => $campaignId,
                        'is_scheduled' => 1,
                    ]
                );
            }else {
                $qb->delete(
                    MAUTIC_TABLE_PREFIX.'campaign_lead_event_log',
                    [
                        'lead_id' => (int)$lead->getId(),
                        'campaign_id' => $campaignId,
                    ]
                );
            }
            if(!empty($event->getConfig()['remove'])){
                $this->campaignModel->removeLead($this->campaignModel->getEntity($campaignId), $lead->getId(), true);
            }
        }
    }
}
