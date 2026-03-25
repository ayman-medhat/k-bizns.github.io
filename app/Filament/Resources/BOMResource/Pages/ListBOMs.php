<?php

namespace App\Filament\Resources\BOMResource\Pages;

use App\Filament\Resources\BOMResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBOMs extends ListRecords
{
    protected static string $resource = BOMResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
