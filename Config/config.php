<?php

return [
    'name'        => 'RecurringCampaigns',
    'description' => 'Repeating tasks for Mautic',
    'author'      => 'kuzmany.biz',
    'version'     => '1.0.0',
    'services' => [
        'events' => [
            'mautic.plugin.reccuring.campaigns.campaign.subscriber' => [
                'class'     => \MauticPlugin\MauticRecurringCampaignsBundle\EventListener\CampaignSubscriber::class,
                'arguments' => [
                    'mautic.helper.integration',
                    'doctrine.dbal.default_connection',
                    'mautic.campaign.model.campaign',
                    'mautic.campaign.model.event',
                ],
            ],
        ],
        'forms' => [
            'mautic.plugin.reccuring..campaigns.type.remove.logs.campaign.action' => [
                'class' => \MauticPlugin\MauticRecurringCampaignsBundle\Form\Type\CampaignEventRemoveLogsActionType::class,
                'alias' => 'removelogs',
            ],
        ],
        'integrations' => [
            'mautic.integration.reccuring.campaigns' => [
                'class'     => \MauticPlugin\MauticRecurringCampaignsBundle\Integration\RecurringCampaignsIntegration::class,
                'arguments' => [
                ],
            ],
        ],
    ],
];
