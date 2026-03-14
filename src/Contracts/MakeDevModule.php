<?php

namespace MakeDev\MakeDev\Contracts;

interface MakeDevModule
{
    /**
     * @return array{
     *     name: string,
     *     description: string,
     *     version: string,
     *     keyFiles: array<int, string>,
     *     capabilities: array<int, string>,
     *     dependencies: array<int, string>,
     *     agentReadme: ?string,
     * }
     */
    public function moduleInfo(): array;
}
