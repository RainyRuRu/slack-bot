<?php
namespace RainyBot\Command;

use PhpSlackBot\Command\BaseCommand as SlackBotBase;

abstract Class BaseCommand extends SlackBotBase
{
    const TYPE_DIRECT_MENTION = 'direct.mention';
    const TYPE_MENTION = 'mention';
    const TYPE_DIRECT = 'direct';
    const TYPE_AMBIENT = 'ambient';

    private $hearType = [];

    public function executeCommand($message, $context) {
        if (!$this->checkHearType($message, $context)) {
            return false;
        }
        return $this->execute($message, $context);
    }

    protected function checkHearType($message, $context)
    {
        $check = false;
        $channelType = $this->getCurrentChannel()[0];

        foreach ($this->hearType as $type) {
            switch ($type) {
                case 'ambient':
                    $check = true;
                    break;
                case 'mention':
                    if (strpos($message['text'], '<@'.$context['self']['id'].'>') !== false) {
                        $check = true;
                    }
                    break;
                case 'direct':
                    if ('D' === $channelType) {
                        $check = true;
                    }
                    break;
                case 'direct.mention':
                    if (strpos($message['text'], '<@'.$context['self']['id'].'>') !== false && 'D' === $channelType) {
                        $check = true;
                    }
                    break;
                default:
                    $check = false;
            }
            if ($check) {
                break;
            }
        }
        return $check;
    }

    public function setHearType($type)
    {
        $this->hearType[] = $type;
    }

    public function getHearType()
    {
        return $this->hearType;
    }

    public function getArgs($message) {
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
