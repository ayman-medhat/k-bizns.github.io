<?php

namespace App\Filament\Resources\BOMResource\Pages;

use App\Filament\Resources\BOMResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBOM extends EditRecord
{
    protected static string $resource = BOMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
