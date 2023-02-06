<?php

namespace App\Filament\Resources\HabitResource\Pages;

use App\Filament\Resources\HabitResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHabit extends EditRecord
{
    protected static string $resource = HabitResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
