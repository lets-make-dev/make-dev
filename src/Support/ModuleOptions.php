<?php

namespace MakeDev\MakeDev\Support;

use Illuminate\Http\Request;

class ModuleOptions
{
    /** @var array<int, string> */
    protected array $flags = [];

    public function __construct(Request $request)
    {
        if ($request->hasHeader('X-Livewire')) {
            $this->flags = session('module_options.flags', []);
        } else {
            $this->flags = $this->parseFlags($request->query('mo', ''));
            session(['module_options.flags' => $this->flags]);
        }
    }

    public function showSkills(): bool
    {
        return $this->hasFlag('skills');
    }

    public function hasFlag(string $flag): bool
    {
        return in_array($flag, $this->flags, true);
    }

    /**
     * @return array<int, string>
     */
    public function flags(): array
    {
        return $this->flags;
    }

    /**
     * @return array<int, string>
     */
    protected function parseFlags(string $raw): array
    {
        if ($raw === '') {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', explode(',', $raw)),
            fn (string $flag) => $flag !== ''
        ));
    }
}
