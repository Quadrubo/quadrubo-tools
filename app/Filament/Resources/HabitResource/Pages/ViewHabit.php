<?php

namespace App\Filament\Resources\HabitResource\Pages;

use App\Filament\Resources\HabitResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHabit extends ViewRecord
{
    protected static string $resource = HabitResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
