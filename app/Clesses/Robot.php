<?php

class Robot {
  public $x = 0;
  public $y = 0;
  public $rawCommand = '';
  public $analyCommand = '';
  public $direction = 'N';
  public $prefixCompress = ['N', 'E', 'S', 'W'];

  public $prefixDirection = [
    'N' => 'North',
    'S' => 'South',
    'E' => 'East',
    'W' => 'West'
  ];

  public function setDirection()
  {
    $this->direction = $this->prefixCompress[0];
  }

  public function getDirectionName()
  {
    return  $this->prefixDirection[$this->direction];
  }

  public function setStraight($command)
  {
    $positions = intval(str_replace('W', '', $command));

    if ($this->direction === 'N'):
      // Y +
      $this->y += $positions;
    endif;

    if ($this->direction === 'E'):
      // X +
      $this->x += $positions;
    endif;

    if ($this->direction === 'S'):
      // Y -
      $this->y -= $positions;;
    endif;

    if ($this->direction === 'W'):
      // X -
      $this->x -= $positions;
    endif;
  }

  public function setTurn($direction)
  {
    if ($direction === 'L') {
      $pop = array_pop($this->prefixCompress);
      array_unshift($this->prefixCompress, $pop);
    }

    if ($direction === 'R') {
      $shift = array_shift($this->prefixCompress);
      array_push($this->prefixCompress, $shift);
    }

    $this->setDirection();
  }

  public function analyCommand()
  {
    $arrAnalyCommand = [];
    $stack = [];
    foreach($this->command as $index => $command):
      // is-number
      if (preg_match('/^[0-9]/', $command)):
        $index = count($arrAnalyCommand) - 1;
        $arrAnalyCommand[$index] .= $command;
        continue;
      endif;

      array_push($arrAnalyCommand, $command);
    endforeach;

    $this->analyCommand = $arrAnalyCommand;
  }

  public function command($command)
  {
    $this->rawCommand = $command;
    $this->command = str_split($command);
    $this->analyCommand();

    $this->execCommand();
  }

  public function execCommand()
  {
    foreach($this->analyCommand as $command):
      if (in_array($command, ['L', 'R'])):
        $this->setTurn($command);
        continue;
      endif;

      $this->setStraight($command);
    endforeach;

    $directionName = $this->getDirectionName();
    echo "X: $this->x Y: $this->y Direction: $directionName";
  }
}