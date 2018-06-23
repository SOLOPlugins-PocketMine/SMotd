<?php

namespace solo\smotd;

use pocketmine\scheduler\Task;

class MotdChangeTask extends Task{

  private $owner;

  public function __construct(SMotd $owner){
    $this->owner = $owner;
  }

  public function onRun(int $currentTick){
    if($currentTick % $this->owner->getChangeInterval() != 0){
      return;
    }
    $this->owner->next();
    $this->owner->getServer()->getNetwork()->setName(str_ireplace(
      [
        '{PLAYERS}',
        '{MAXPLAYERS}',
        '{TPS}',
        '{AVERAGETPS}'
      ],
      [
        count($this->owner->getServer()->getOnlinePlayers()),
        $this->owner->getServer()->getMaxPlayers(),
        $this->owner->getServer()->getTicksPerSecond(),
        $this->owner->getServer()->getTicksPerSecondAverage()
      ],
      $this->owner->getCurrentMotd()
    ));
  }
}
