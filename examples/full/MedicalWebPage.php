<?php

namespace SchemaOrg;

/**
 * Medical Web Page
 *
 * @link http://schema.org/MedicalWebPage
 */
class MedicalWebPage extends WebPage
{
    /**
     * Aspect
     *
     * @var string An aspect of medical practice that is considered on the page, such as 'diagnosis', 'treatment', 'causes', 'prognosis', 'etiology', 'epidemiology', etc.
     */
    protected $aspect;
}
