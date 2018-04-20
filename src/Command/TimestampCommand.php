<?php
namespace RainyBot\Command;

use PhpSlackBot\Command\BaseCommand;

class TimestampCommand extends BaseCommand
{
    protected function configure () 
    {
        $this->setMentionOnly(true);
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

     private function getArgs($message) {
         $args = array();
         if (isset($message['text'])) {
             $args = array_values(array_filter(explode(' ', $message['text'])));
         }
         $commandName = $this->getName();
         // Remove args which are before the command name
         $finalArgs = array();
         $remove = true;
         foreach ($args as $arg) {
             if ($commandName == $arg) {
                 $remove = false;
             }
             if (!$remove) {
                 $finalArgs[] = $arg;
             }
         }
         return $finalArgs;
     }
}

