<?php

namespace SchemaOrg;

/**
 * Audio Object
 *
 * @link http://schema.org/AudioObject
 */
class AudioObject extends MediaObject
{
    /**
     * Transcript
     *
     * @var string If this MediaObject is an AudioObject or VideoObject, the transcript of that object.
     */
    protected $transcript;
}
