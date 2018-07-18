<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticRecurringCampaignsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * Class CampaignEventRemoveLogsActionType.
 */
class CampaignEventRemoveLogsActionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add(
            'campaigns',
            'campaign_list', [
            'label'      => 'mautic.campaign.campaigns',
            'attr'       => [
                'class'   => 'form-control',
            ],
            'multiple'   => true,
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'mautic.core.value.required',
                ]),
            ],
        ]);

        $builder->add(
            'action',
            'yesno_button_group',
            [
                'label' => 'plugin.recurring.campaigns.campaign.remove.scheduled',
                'attr'=> [
                  'tooltip'=>'plugin.recurring.campaigns.campaign.remove.scheduled.desc'
                ],
                'data'       => !empty($options['data']['action']) ? true : false,
            ]
        );

        $builder->add(
            'remove',
            'yesno_button_group',
            [
                'label' => 'plugin.recurring.campaigns.campaign.remove.from',
                'attr'=> [
                  'tooltip'=>'plugin.recurring.campaigns.campaign.remove.from.desc'
                ],
                'data'       => !empty($options['data']['remove']) ? true : false,
            ]
        );

        $builder->add(
            'add_to_segments',
            'leadlist_choices',
            [
                'label'      => 'plugin.recurring.campaigns.campaign.add_to_segments',
                'label_attr' => ['class' => 'control-label'],
                'multiple'   => true,
                'required'   => false,
                'global_only' => false,
            ]
        );

        $builder->add(
            'remove_from_segments',
            'leadlist_choices',
            [
                'label'      => 'plugin.recurring.campaigns.campaign.remove_from_segments',
                'label_attr' => ['class' => 'control-label'],
                'multiple'   => true,
                'required'   => false,
                'global_only' => false,
            ]
        );

        $builder->add(
            'tags',
            'modify_lead_tags',
            [
                'label'      => false,
            ]
        );

    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'removelogs';
    }
}
