<?php

namespace MauticPlugin\MauticRecurringCampaignsBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

class RecurringCampaignsIntegration extends AbstractIntegration
{
    public function getName()
    {
        // should be the name of the integration
        return 'RecurringCampaigns';
    }

    public function getAuthenticationType()
    {
        /* @see \Mautic\PluginBundle\Integration\AbstractIntegration::getAuthenticationType */
        return 'none';
    }

}
