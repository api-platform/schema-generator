<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SchemaOrgModel\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console Logger
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ConsoleLogger extends AbstractLogger
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {
        if ($level === LogLevel::DEBUG || LogLevel::INFO) {
            $formatter = 'info';
        } else {
            $formatter = 'error';
        }

        $this->output->writeln(sprintf('<%s>[%s] %s</%s>', $formatter, $level, $message, $formatter));
    }
}
