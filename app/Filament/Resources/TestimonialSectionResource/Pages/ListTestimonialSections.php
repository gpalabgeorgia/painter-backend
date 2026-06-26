<?php

namespace App\Filament\Resources\TestimonialSectionResource\Pages;

use App\Filament\Resources\TestimonialSectionResource;
use App\Models\TestimonialSection;
use Filament\Resources\Pages\ListRecords;

class ListTestimonialSections extends ListRecords
{
    protected static string $resource = TestimonialSectionResource::class;

    public function mount(): void
    {
        parent::mount();

        // Находим или создаем единственную запись
        $record = TestimonialSection::first() ?? TestimonialSection::create([
            'quote' => 'Really beautiful professional abstracts led quis malesuada aenean risus, gravida eu nunc quis bibendum venenatis.',
            'author_name' => 'JONATHAN DOE',
            'author_title' => 'ABC Architect',
        ]);

        // Получаем системное имя роута
        $routeName = TestimonialSectionResource::getRouteBaseName() . '.edit';

        // Просто вызываем редирект, Livewire сам всё поймет и перенаправит куда надо
        redirect()->route($routeName, ['record' => $record->id]);
    }
}
