<?php

namespace App\Filament\Resources\HabitResource\Pages;

use App\Filament\Resources\HabitResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHabits extends ListRecords
{
    protected static string $resource = HabitResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
