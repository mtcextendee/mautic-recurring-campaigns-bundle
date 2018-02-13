<?php

return [
    'name'        => 'Recurring Campaigns',
    'description' => 'Solution for repeating tasks',
    'author'      => 'kuzmany.biz',
    'version'     => '1.0.0',
    'services' => [
        'events' => [
            'mautic.plugin.reccuring.campaigns.campaign.subscriber' => [
                'class'     => \MauticPlugin\MauticRecurringCampaignsBundle\EventListener\CampaignSubscriber::class,
                'arguments' => [
                    'mautic.helper.integration',
                    'doctrine.dbal.default_connection',
                ],
            ],
        ],
        'forms' => [
            'mautic.plugin.reccuring..campaigns.type.remove.logs.campaign.action' => [
                'class' => \MauticPlugin\MauticRecurringCampaignsBundle\Form\Type\CampaignEventRemoveLogsActionType::class,
                'alias' => 'removelogs',
            ],
        ]
    ],
];
