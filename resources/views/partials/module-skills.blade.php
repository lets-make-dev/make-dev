@php
    $popoverPosition ??= 'below';
@endphp

@foreach (app(\MakeDev\MakeDev\Support\ModuleSkillRegistry::class)->resolve() as $skill)
    @include($skill->view(), ['popoverPosition' => $popoverPosition])
@endforeach
