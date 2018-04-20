<?php
namespace RainyBot\Command;

class TimestampCommand extends BaseCommand
{
    protected function configure () 
    {
        $this->setHearType(BaseCommand::TYPE_DIRECT);
        $this->setHearType(BaseCommand::TYPE_MENTION);
        $this->setName('timestamp');
    }

    protected function execute($message, $context)
    {
        $args = $this->getArgs($message);
        $dateOrTimestamp = isset($args[1]) ? $args[1] : '';
        $time = isset($args[2]) ? $args[2] : '00:00:00';

        if ('now' === $dateOrTimestamp) {
            $this->send($this->getCurrentChannel(), null, strtotime($dateOrTimestamp));
            return;
        }

        if (is_numeric($dateOrTimestamp)) {
            $this->send($this->getCurrentChannel(), null, date('Y-m-d H:i:s', $dateOrTimestamp));
        } else {
            $this->send($this->getCurrentChannel(), null, strtotime($dateOrTimestamp . ' ' . $time));
        }

    }
}
