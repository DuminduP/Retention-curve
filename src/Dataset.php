<?php

namespace src;

interface Dataset
{
    public function setData(array $data): void;

    public function getAllData(): array;
}
