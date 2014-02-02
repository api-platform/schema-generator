<?php

namespace SchemaOrg;

/**
 * Allocate Action
 *
 * @link http://schema.org/AllocateAction
 */
class AllocateAction extends OrganizeAction
{
    /**
     * Purpose (Thing)
     *
     * @var Thing A goal towards an action is taken. Can be concrete or abstract.
     */
    protected $purposeThing;
    /**
     * Purpose (MedicalDevicePurpose)
     *
     * @var MedicalDevicePurpose A goal towards an action is taken. Can be concrete or abstract.
     */
    protected $purposeMedicalDevicePurpose;
}
