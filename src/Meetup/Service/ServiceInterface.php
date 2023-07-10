<?php
declare(strict_types=1);

namespace Meetup\Service;

interface ServiceInterface
{
    public function get(): array;
}