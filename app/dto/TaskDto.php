<?php

namespace app\dto;
class TaskDto
{
    public ?int $id;
    public string $describe;
    public string $deadline;
    public int $prioritetId;
    public string $prioritetName;

    public array $users;

}